package sample;

        import java.sql.Date;
        import java.sql.PreparedStatement;
        import java.sql.ResultSet;
        import java.sql.SQLException;

public class BillConnect extends DBconnect{


    public BillConnect() {
        super();
    }

    public void getData(String colonne, String value){
        try{

            PreparedStatement findBill = getConnection().prepareStatement("SELECT * FROM BILL INNER JOIN USER ON USER.idUser = BILL.idUser WHERE "+colonne+" = ?");
            findBill.setString(1,value);

            setResultSet(findBill.executeQuery());

            showResult(getResultSet());

        }catch (Exception e){
            System.out.println(e);
        }
    }


    public void getAllBill(){
        try{

            String querySelectAllBill = "SELECT * FROM BILL INNER JOIN USER ON USER.idUser = BILL.idUser";
            setResultSet(getStatement().executeQuery(querySelectAllBill));
            System.out.println("--------------------------BILL--------------------------");
            showResult(getResultSet());



        }catch (Exception e){
            System.out.println(e);
        }
    }

    public void showResult(ResultSet rs){

        try {

            while (getResultSet().next()) {
                String userFirstName = getResultSet().getString("userFirstName");
                Date date = getResultSet().getDate("billDate");
                String price = getResultSet().getString("billPrice");
                String description = getResultSet().getString("billDescription");
                String state = getResultSet().getString("billState");

                System.out.println(
                        "User : " + userFirstName + " |" +
                                "Price : " + price + "|" +
                                "Description : " + description + " |" +
                                "Date : " + date + " |" +
                                "State : " +state + "\n"
                );

            }
        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }

    }
}
