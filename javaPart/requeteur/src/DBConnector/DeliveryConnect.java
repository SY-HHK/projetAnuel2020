package DBConnector;

        import java.sql.Date;
        import java.sql.PreparedStatement;
        import java.sql.ResultSet;
        import java.sql.SQLException;

public class DeliveryConnect extends DBconnect{


    public DeliveryConnect() {
        super();
    }

    public void getData(String colonne, String value){
        try{

            PreparedStatement findBill = getConnection().prepareStatement("SELECT * FROM DELIVERY INNER JOIN PROVIDER ON PROVIDER.idProvider = DELIVERY.idProvider  WHERE "+colonne+" = ?");
            findBill.setString(1,value);

            setResultSet(findBill.executeQuery());

            showResult(getResultSet());

        }catch (Exception e){
            System.out.println(e);
        }
    }


    public void getAllDelivery(){
        try{

            String querySelectAllDelivery = "SELECT * FROM DELIVERY INNER JOIN PROVIDER ON PROVIDER.idProvider = DELIVERY.idProvider INNER JOIN SERVICE ON SERVICE.idService = DELIVERY.idService INNER JOIN BILL ON BILL.idBill = DELIVERY.idBill INNER JOIN USER ON USER.idUser = BILL.idUser";
            setResultSet(getStatement().executeQuery(querySelectAllDelivery));
            System.out.println("--------------------------DELIVERY--------------------------");
            showResult(getResultSet());



        }catch (Exception e){
            System.out.println(e);
        }
    }

    public void showResult(ResultSet rs){

        try {

            while (getResultSet().next()) {
                String providerFirstName = getResultSet().getString("providerFirstName");
                String userFirstName = getResultSet().getString("userFirstName");
                String service = getResultSet().getString("serviceTitle");
                Date dateStart = getResultSet().getDate("deliveryDateStart");
                Date dateEnd = getResultSet().getDate("deliveryDateEnd");
                Date hourStart = getResultSet().getDate("deliveryHourStart");
                Date hourEnd = getResultSet().getDate("deliveryHourEnd");

                System.out.println(
                        "Provider : " + providerFirstName + " |" +
                                "User : " + userFirstName + " |" +
                                "Service : " + service + "|" +
                                "Datestart : " + dateStart + " |" +
                                "DateEnd : " + dateEnd + " |" +
                                "hourStart : " + hourStart + " |" +
                                "hourEnd : " + hourEnd + " \n"
                );

            }
        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }

    }
}
