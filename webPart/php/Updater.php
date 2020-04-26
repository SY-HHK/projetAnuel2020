<?php

require_once __DIR__ . '/DatabaseManager.php';

class Updater
{

    private $post;
    private $databasemanager;
    private $id;

    public function __construct($post, $id)
    {
        $this->post = $post;
        $this->databasemanager = DatabaseManager::getInstance();
        $this->id = $id;
    }

    public function isAllSet():string {
        if (!isset($this->post["name"]) || empty($this->post["name"])) {
            return "name";
        }

        if (!isset($this->post["email"]) || empty($this->post["email"])) {
            return "email";
        }

        if (!isset($this->post["cityName"]) || empty($this->post["cityName"])) {
            return "cityName";
        }

        if (!isset($this->post["address"]) || empty($this->post["address"])) {
            return "address";
        }

        if (!isset($this->post["cityDepartment"]) || empty($this->post["cityDepartment"])) {
            return "cityDepartment";
        }

        if (!isset($this->post["cityRegion"]) || empty($this->post["cityRegion"])) {
            return "cityRegion";
        }

        if (!isset($this->post["password"]) || empty($this->post["password"])) {
            return "password";
        }

        return "ok";
    }

    public function isGoodPasswordProvider():bool {
        print_r($this->id);
        $result = $this->databasemanager->findOne("SELECT idProvider FROM PROVIDER WHERE providerPassword = ? && providerGuid = ?",
                                        [hash("sha256",$this->post["password"]), $this->id]);
        if ($result) return true;
        else return false;
    }

    public function isGoodPasswordUser():bool {
        $result = $this->databasemanager->findOne("SELECT idUser FROM USER WHERE userPassword = ? && userGuid = ?",
            [hash("sha256",$this->post["password"]), $this->id]);
        if ($result) return true;
        else return false;
    }

    private function separateNames():array {
        return $name = explode(" ", $this->post["name"]);
    }

    private function getProviderIdCity():string {
        $idCity = $this->databasemanager->findOne("SELECT providerIdCity FROM PROVIDER WHERE providerGuid = ?", [$this->id]);
        return $idCity["providerIdCity"];
    }

    private function getUserIdCity():string {
        $idCity = $this->databasemanager->findOne("SELECT userIdCity FROM USER WHERE userGuid = ?", [$this->id]);
        return $idCity["userIdCity"];
    }

    private function newPassword():string {
        if (isset($this->post["newPassword"]) && !empty($this->post["newPassword"])) {
            return $this->post["newPassword"];
        }
        else return $this->post["password"];
    }

    public function updateProvider():int {
        $name = $this->separateNames();
        $password = $this->newPassword();
        $updateProvider = $this->databasemanager->exec("UPDATE PROVIDER SET providerFirstName = ?, providerLastName = ?, providerEmail = ?,  providerAddress = ?, providerPassword = ? WHERE providerGuid = ?",
                                        [$name[0], $name[1], $this->post["email"], $this->post["address"], hash("sha256", $password), $this->id]);

        if ($updateProvider == false) return 0;

        $updateProviderCity = $this->databasemanager->exec("UPDATE CITY SET cityName = ?, cityDepartement = ?, cityRegion = ? WHERE idCity = ?",
                                        [$this->post["cityName"], $this->post["cityDepartment"], $this->post["cityRegion"], $this->getProviderIdCity()]);

        if ($updateProviderCity == false) return 1;
        else return 2;
    }

    public function updateUser():int {
        $name = $this->separateNames();
        $password = $this->newPassword();
        $updateUser = $this->databasemanager->exec("UPDATE USER SET userFirstName = ?, userLastName = ?, userEmail = ?,  userAddress = ?, userPassword = ? WHERE userGuid = ?",
            [$name[0], $name[1], $this->post["email"], $this->post["address"], hash("sha256", $password), $this->id]);

        if ($updateUser == false) return 0;

        $updateUserCity = $this->databasemanager->exec("UPDATE CITY SET cityName = ?, cityDepartement = ?, cityRegion = ? WHERE idCity = ?",
            [$this->post["cityName"], $this->post["cityDepartment"], $this->post["cityRegion"], $this->getUserIdCity()]);

        if ($updateUserCity == false) return 1;
        else return 2;
    }

}