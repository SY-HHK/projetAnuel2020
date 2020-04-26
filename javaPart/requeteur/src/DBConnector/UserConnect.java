package DBConnector;

import java.sql.Date;
import java.sql.ResultSet;
import java.sql.SQLException;

public class UserConnect extends DBconnect {


    public UserConnect() {
        super();
    }

   /* public void getData(String colonne, String value){
        try{

            PreparedStatement recherchePersonne = getConnection().prepareStatement("SELECT * FROM USER INNER JOIN CITY ON CITY.idCity = userIdCity WHERE "+colonne+" = ?");
            recherchePersonne.setString(1,value);

            setResultSet(recherchePersonne.executeQuery());

            showResult(getResultSet());

        }catch (Exception e){
            System.out.println(e);
        }
    }*/


    public void getAllUser(){
        try{

            String querySelectAllUser = "SELECT * FROM USER INNER JOIN CITY ON CITY.idCity = userIdCity";
            setResultSet(getStatement().executeQuery(querySelectAllUser));
            System.out.println("--------------------------USERS--------------------------");
            showResult(getResultSet());



        }catch (Exception e){
            System.out.println(e);
        }
    }

    public void showResult(ResultSet rs){

        try {

            while (getResultSet().next()) {
                String id = getResultSet().getString("idUser");
                String firstName = getResultSet().getString("userFirstName");
                String lastName = getResultSet().getString("userLastName");
                String email = getResultSet().getString("userEmail");
                Date birth = getResultSet().getDate("userBirth");
                String phone = getResultSet().getString("userPhone");
                String address = getResultSet().getString("userAddress") + getResultSet().getString("cityDepartement") + getResultSet().getString("cityName");

                System.out.println(
                        "First name : " + firstName + "|" +
                        "Last Name : " + lastName + "|" +
                        "Mail : " + email + " |" +
                        "Birth : " + birth + " |" +
                        "Phone : " + phone + " |" +
                        "Address : " + address + " \n"
                );

            }
        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }

    }
}
