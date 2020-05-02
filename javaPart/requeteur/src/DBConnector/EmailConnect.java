package DBConnector;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class EmailConnect {

    public int emailFormat(String email){

        String regex = "^(.+)@(.+\\.)+([a-zA-A]{2,4})";
        Pattern pattern = Pattern.compile(regex);

        Matcher matcher = pattern.matcher(email);

        System.out.println(matcher.matches());
       if (matcher.matches() == true){
           return 1;
       }else{
           return 0;
       }
    }

    public int emailProvider(String email) throws SQLException {
        System.out.println(emailFormat(email));
        if (emailFormat(email) == 1){
            Connection conn2 = DBConnector.DBconnect.connect();
            String sqlSelectProvider = "SELECT * FROM PROVIDER WHERE providerEmail = ?";
            try{
                PreparedStatement statement2 = conn2.prepareStatement(sqlSelectProvider);
                statement2.setString(1, String.valueOf(email));
                ResultSet rsCity = statement2.executeQuery();

                if (rsCity.next() ) {
                    conn2.close();
                    return 1;
                }else {
                    return 0;
                }
            }catch (Exception e){
                System.out.println("Error:" +e);
            }
        }else {
            return 1;
        }


        return -1;
    }


    public int emailUser(String email) throws SQLException {
        if (emailFormat(email) == 1){
            Connection conn2 = DBConnector.DBconnect.connect();
            String sqlSelectUser = "SELECT * FROM USER WHERE userEmail = ?";
            try{
                PreparedStatement statement2 = conn2.prepareStatement(sqlSelectUser);
                statement2.setString(1, String.valueOf(email));
                ResultSet rsCity = statement2.executeQuery();

                if (rsCity.next() ) {
                    conn2.close();
                    return 1;
                }else {
                    return 0;
                }
            }catch (Exception e){
                System.out.println("Error:" +e);
            }
        }else{
            return 1;
        }
     return -1;

}
}
