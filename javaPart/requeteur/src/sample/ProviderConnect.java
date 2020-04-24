package sample;

        import java.sql.PreparedStatement;
        import java.sql.ResultSet;
        import java.sql.SQLException;

public class ProviderConnect extends DBconnect{


    public ProviderConnect() {
        super();
    }

    public void getData(String colonne, String value){
        try{

            PreparedStatement findProvider = getConnection().prepareStatement("SELECT * FROM PROVIDER INNER JOIN CITY ON CITY.idCity = providerIdCity WHERE "+colonne+" = ?");
            findProvider.setString(1,value);

            setResultSet(findProvider.executeQuery());

            showResult(getResultSet());

        }catch (Exception e){
            System.out.println(e);
        }
    }


    public void getAllProvider(){
        try{

            String querySelectAllProvider = "SELECT * FROM PROVIDER INNER JOIN CITY ON CITY.idCity = providerIdCity";
            setResultSet(getStatement().executeQuery(querySelectAllProvider));
            System.out.println("--------------------------PROVIDER--------------------------");
            showResult(getResultSet());

        }catch (Exception e){
            System.out.println(e);
        }
    }

    public void showResult(ResultSet rs){

        try {

            while (getResultSet().next()) {
                String id = getResultSet().getString("idProvider");
                String firstName = getResultSet().getString("providerFirstName");
                String lastName = getResultSet().getString("providerLastName");
                String email = getResultSet().getString("providerEmail");
                String phone = getResultSet().getString("providerPhone");
                String address = getResultSet().getString("providerAddress") + getResultSet().getString("cityDepartement") + getResultSet().getString("cityName");

                System.out.println(
                        "First name : " + firstName + "|" +
                                "Last Name : " + lastName + "|" +
                                "Mail : " + email + " | " +
                                "Phone : " + phone + " | " +
                                "Address : " + address +" \n "
                );

            }
        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }

    }
}
