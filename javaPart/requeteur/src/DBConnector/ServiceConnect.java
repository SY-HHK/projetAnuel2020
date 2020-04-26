package DBConnector;

        import DBConnector.DBconnect;

        import java.sql.PreparedStatement;
        import java.sql.ResultSet;
        import java.sql.SQLException;

public class ServiceConnect extends DBconnect {


    public ServiceConnect() {
        super();
    }

    public void getData(String colonne, String value){
        try{

            PreparedStatement findService = getConnection().prepareStatement("SELECT * FROM SERIVCE WHERE "+colonne+" = ?");
            findService.setString(1,value);

            setResultSet(findService.executeQuery());

            showResult(getResultSet());

        }catch (Exception e){
            System.out.println(e);
        }
    }


    public void getAllService(){
        try{

            String querySelectAllService = "SELECT * FROM SERVICE";
            setResultSet(getStatement().executeQuery(querySelectAllService));
            System.out.println("--------------------------SERIVCES--------------------------");
            showResult(getResultSet());



        }catch (Exception e){
            System.out.println(e);
        }
    }

    public void showResult(ResultSet rs){

        try {

            while (getResultSet().next()) {
                String name = getResultSet().getString("serviceTitle");
                String price = getResultSet().getString("servicePrice");
                String description = getResultSet().getString("serviceDescription");
                String image = getResultSet().getString("serviceImage");

                System.out.println(
                        "Service name : " + name + " |" +
                                "Price : " + price + "|" +
                                "Description : " + description + " |" +
                                "Image : " + image + " \n"
                );

            }
        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }

    }
}
