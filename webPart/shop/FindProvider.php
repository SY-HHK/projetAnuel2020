<?php
/**
 * Class supposed to assign booking to provider depending their availibility, Created by SY-HHK 2020***
 */
class FindProvider {

  private $bookList;
  private $pdo;

  function __construct($array, $pdo)
  {
    $this->bookList = $array;
    $this->pdo = $pdo;
  }


///////////////////////////////////////////////////////////////////////////////////////////////////
  public function checkProvider($index, $idUserCity) {
    $availibleProviders = array();
    $getProvider = $this->pdo->prepare("SELECT PROVIDER.idProvider, CITY.cityName, CITY.cityDepartement, CITY.cityRegion FROM CONTRACT
                                        INNER JOIN PROVIDER ON CONTRACT.idProvider = PROVIDER.idProvider
                                        INNER JOIN CITY ON provideridCity = CITY.idCity WHERE idService = ?");
    $getProvider->execute([$this->bookList["idService".$index]]);
    $providers = $getProvider->fetchAll();

    $userCityInfos = $this->getCityInfos($idUserCity);

    foreach ($providers as $provider) {

      if ($provider["cityRegion"] != $userCityInfos["cityRegion"]) {
        $isThisProviderAvailible = 0;
      }
      else {

      $checkProvider = $this->pdo->prepare("SELECT idDelivery, deliveryHourStart, deliveryHourEnd, deliveryDateStart, deliveryDateEnd FROM DELIVERY WHERE idProvider = ? && deliveryDateStart = ?");
      $checkProvider->execute([$provider["idProvider"], date("Y-m-d", strtotime($this->bookList["date".$index]))]);
      $isAvailible = $checkProvider->rowCount();

      if ($isAvailible == 0) {
        $availibleProviders[count($availibleProviders)] = array(
          "idProvider" => $provider["idProvider"],
          "cityName" => $provider["cityName"],
          "cityDepartement" => $provider["cityDepartement"],
          "cityRegion" => $provider["cityRegion"],
        );
      }
      else {
        $deliverys = $checkProvider->fetchAll();
        $isThisProviderAvailible = 1;
        foreach ($deliverys as $delivery) {

          if (strtotime($this->bookList["hourStop".$index]) < strtotime($this->bookList["hourStart".$index])) {
            if (strtotime($this->bookList["hourStart".$index]) > strtotime($delivery["deliveryHourEnd"])) {
              if (strtotime($this->bookList["hourStart".$index]) > strtotime($delivery["deliveryHourStart"])) {
                $isThisProviderAvailible = 0;
              }
              else {
                $date = date_create($this->bookList["date".$index]);
                date_add($date, date_interval_create_from_date_string('1 days'));
                $checkProvider = $this->pdo->prepare("SELECT idDelivery, deliveryHourStart, deliveryHourEnd, deliveryDateStart, deliveryDateEnd FROM DELIVERY WHERE idProvider = ? && deliveryDateStart = ?");
                $checkProvider->execute([$provider["idProvider"], date_format($date, "Y-m-d")]);
                $isAvailible = $checkProvider->rowCount();
                if ($isAvailible != 0) {
                  $deliverysNextDay = $checkProvider->fetchAll();
                  foreach ($deliverysNextDay as $nextDay) {
                    if (strtotime($this->bookList["hourStop".$index]) > strtotime($nextDay["deliveryHourStart"])) {
                      $isThisProviderAvailible = 0;
                    }
                  }
                }
              }
            }
            else {
              $isThisProviderAvailible = 0;
            }
          }
          else {
            if (strtotime($this->bookList["date".$index]) == strtotime($delivery["deliveryDateStart"])) {
              if (strtotime($this->bookList["date".$index]) == strtotime($delivery["deliveryDateEnd"])) {
                if (strtotime($this->bookList["hourStop".$index]) > strtotime($delivery["deliveryHourStart"])) {
                  if (strtotime($delivery["deliveryHourEnd"]) > strtotime($this->bookList["hourStart".$index])) {
                    $isThisProviderAvailible = 0;
                  }
                }
              }
              else {
                if (strtotime($this->bookList["hourStop".$index]) > strtotime($delivery["deliveryHourStart"])) {
                  if (strtotime($delivery["deliveryHourEnd"]."+ 1 days") > strtotime($this->bookList["hourStart".$index])) {
                    $isThisProviderAvailible = 0;
                  }
                }
              }
            }
          }

        }

        if ($isThisProviderAvailible == 1) {
          $availibleProviders[count($availibleProviders)] = array(
            "idProvider" => $provider["idProvider"],
            "cityName" => $provider["cityName"],
            "cityDepartement" => $provider["cityDepartement"],
            "cityRegion" => $provider["cityRegion"],
          );
        }

      }
    }
    }

    if (empty($availibleProviders)) return 0;
    else return $availibleProviders;

  }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



  public function insertDelivery($index, $idBill, $idUserCity) {

      $availibleProviders = $this->checkProvider($index, $idUserCity);

      $idProvider = $this->findInSameLocation($availibleProviders, $idUserCity, "cityName"); //find in the same city
      if ($idProvider == -1) $this->findInSameLocation($availibleProviders, $idUserCity, "cityDepartment"); //find in the same department
      if ($idProvider == -1) $this->findInSameLocation($availibleProviders, $idUserCity, "cityRegion"); //region

      if ($this->bookList["hourStart".$index] > $this->bookList["hourStop".$index]) {
        $dateEnd = date("Y-m-d", strtotime($this->bookList["date".$index]."+ 1 days"));
      }
      else {
        $dateEnd = $this->bookList["date".$index];
      }

      $insertNewDelivery = $this->pdo->prepare("INSERT INTO DELIVERY (deliveryDateStart, deliveryDateEnd, deliveryHourStart, deliveryHourEnd, deliveryState,
                                                idService, idProvider, idBill) VALUES (?,?,?,?,0,?,?,?)");
      $insertNewDelivery->execute([$this->bookList["date".$index],$dateEnd,
                                  $this->bookList["hourStart".$index],$this->bookList["hourStop".$index],
                                  $this->bookList["idService".$index],$idProvider,$idBill]);
  }

  private function findInSameLocation($availibleProviders, $idUserCity, $locationType) {
    $cityUser = $this->getCityInfos($idUserCity);

    foreach ($availibleProviders as $provider) {
      if ($provider[$locationType] == $cityUser[$locationType]) {
        return $provider["idProvider"];
      }
    }
    return -1;
  }

  public function insertBill($idUser) {
    $description = "";
    $i = 1;
    $totalPrice = 0;
    $subHourUsed = 0;
    while (isset($this->bookList["idService".$i])) {
      $time = $this->getTimeOfDelivery($i);
      if (isset($this->bookList["payWithSub".$i])) {
        $description = $description."Service de ".$this->bookList["serviceTitle".$i]." : "
                      .$time." heures le ".date("d/m/yy", strtotime($this->bookList["date".$i]))."(payé avec l'abonnement), ";
        $subHourUsed += $time;

        $updateHourLeft = $this->pdo->prepare("UPDATE USER SET subHourLeft = subHourLeft - ? WHERE idUser = ?");
        $updateHourLeft->execute([$time,$idUser]);
      }
      else {
        $description = $description."Service de ".$this->bookList["serviceTitle".$i]." : "
                      .$time." heures le ".date("d/m/yy", strtotime($this->bookList["date".$i])).", ";
        $totalPrice += $this->getPrice($time, $this->bookList["idService".$i]);
      }
      $i++;
    }

    $insertNewBill = $this->pdo->prepare("INSERT INTO BILL (idUser, billDate, billDescription, billPrice, billState) VALUES (?,now(),?,?,?)");
    $insertNewBill->execute([$idUser, $description, $totalPrice, 0]);

    $billInfos = array(
      "idBill" => $this->pdo->lastInsertId(),
      "description" => $description,
      "totalPrice" => $totalPrice,
      "subHourUsed" => $subHourUsed,
    );
    return $billInfos;
  }

  public function checkSub($idUser) {

    $getTimeSubAvailible = $this->pdo->prepare("SELECT * FROM USER INNER JOIN SUBSCRIPTION ON USER.idSubscription = SUBSCRIPTION.idSub WHERE idUser = ?");
    $getTimeSubAvailible->execute([$idUser]);
    $subInfos = $getTimeSubAvailible->fetch();

    $totalTime = 0;
    $i = 1;
    while(isset($this->bookList["serviceTitle".$i])) {
      if (isset($this->bookList["payWithSub".$i])) {
        if (isset($subInfos["idSubscription"])) {
          if (strtotime($this->bookList["date".$i]."last Monday") >= strtotime($this->bookList["date".$i]."-".($subInfos["subDays"])." days")
              || date("D", strtotime($this->bookList["date".$i])) == "Mon") {
            if (strtotime($this->bookList["hourStart".$i]) >= strtotime($subInfos["subHourStart"].":00:00") && strtotime($this->bookList["hourStop".$i]) <= strtotime($subInfos["subHourEnd"].":00:00")) {
              $totalTime += $this->getTimeOfDelivery($i);
            }
            else {
              return -1;
              exit;
            }
          }
          else {
            return -1;
            exit;
          }
        }
        else {
          return -1;
          exit;
        }
      }
      $i++;
    }

    if ($totalTime > $subInfos["subHourLeft"]) return 0;
    else return 1;
  }

  private function getPrice($time, $idService) {
    $getPrice = $this->pdo->prepare("SELECT servicePrice FROM SERVICE WHERE idService = ?");
    $getPrice->execute([$idService]);
    $price = $getPrice->fetch();

    return $price["servicePrice"] * $time;
  }

  public function getTimeOfDelivery($index) {
    if(strtotime($this->bookList["hourStop".$index]) < strtotime($this->bookList["hourStart".$index])) {
      $time = 24 - $this->decimalHours($_POST["hourStart".$index]) + $this->decimalHours($_POST["hourStop".$index]);
    }
    else {
      $time = $this->decimalHours($_POST["hourStop".$index]) - $this->decimalHours($_POST["hourStart".$index]);
    }

    if ($time < 0.5) return -1;
    else return $time;
  }

  private function decimalHours($time) {
      $hms = explode(":", $time);
      $time = ($hms[0] + ($hms[1]/60));
      return round($time, 2);
  }

  private function getCityInfos($idUserCity) {
    $getCityUser = $this->pdo->prepare("SELECT * FROM CITY WHERE idCity = ?");
    $getCityUser->execute([$idUserCity]);
    $cityUser = $getCityUser->fetch();

    return $cityUser;
  }
}




?>
