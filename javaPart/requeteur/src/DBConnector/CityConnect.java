package DBConnector;

import model.City;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class CityConnect {


public int cityInsert(String cityName, String cityRegion, String cityDepartment) throws SQLException {
    int nbrRetour = 0;
    try{
        Connection conn2 = DBConnector.DBconnect.connect();
        String sqlInsertCity = "INSERT INTO CITY(cityName, cityRegion, cityDepartement) VALUES (?,?,?)";
        PreparedStatement statement2 = conn2.prepareStatement(sqlInsertCity);
        statement2.setString(1, String.valueOf(cityName));
        statement2.setString(2, String.valueOf(cityRegion));
        statement2.setString(3, String.valueOf(cityDepartment));

        nbrRetour = statement2.executeUpdate();
        conn2.close();

    }catch (Exception e){
        System.out.println("Error:" +e);
    }
    return nbrRetour;
}

public City cityExists(String city, String region, String departement) throws SQLException {

    Connection conn2 = DBConnector.DBconnect.connect();
    String sqlSelectCity = "SELECT * FROM CITY WHERE cityName = ?";
    try{
        PreparedStatement statement2 = conn2.prepareStatement(sqlSelectCity);
        statement2.setString(1, String.valueOf(city));
        ResultSet rsCity = statement2.executeQuery();

        if (rsCity.next() ) {
            City cityReturn = new City(rsCity.getInt(1),rsCity.getString(2), rsCity.getString(3), rsCity.getString(4));
            conn2.close();
            return cityReturn;
        }else {
            /* if city doesn't exists then we insert it*/
            cityInsert(city, region,departement);
        }
    }catch (Exception e){
            System.out.println("Error:" +e);
    }
        return null;
}
public int cityIdGetByName(String cityName) throws SQLException {

        Connection conn2 = DBConnector.DBconnect.connect();
        String sqlSelectCity = "SELECT * FROM CITY WHERE cityName = ?";
        try{

            PreparedStatement statement2 = conn2.prepareStatement(sqlSelectCity);
            statement2.setString(1, String.valueOf(cityName));
            ResultSet rsCity = statement2.executeQuery();

            if (rsCity.next() ){
                return rsCity.getInt(1);
            }
            else {
                System.out.println("non city");
            }
            conn2.close();
        }catch (Exception e){
            System.out.println("Error:" +e);
        }
        return -1;
    }


public City cityInfoGetByName(String cityName) throws SQLException {

        Connection conn2 = DBConnector.DBconnect.connect();
        String sqlSelectCity = "SELECT * FROM CITY WHERE cityName = ?";
        try{

            PreparedStatement statement2 = conn2.prepareStatement(sqlSelectCity);
            statement2.setString(1, String.valueOf(cityName));
            ResultSet rsCity = statement2.executeQuery();

            if (rsCity.next() ){
                City cityReturn = new City(rsCity.getString(2),rsCity.getString(3),rsCity.getString(4));
                //System.out.println(rsCity.getString(1));
                return cityReturn;
            }
            else {
                System.out.println("non city");
            }
            conn2.close();
        }catch (Exception e){
            System.out.println("Error:" +e);
        }
        return null;
    }



public City cityInfoGet(String idCity) throws SQLException {

    Connection conn2 = DBConnector.DBconnect.connect();
    String sqlSelectCity = "SELECT * FROM CITY WHERE idCity = ?";
    try{

        PreparedStatement statement2 = conn2.prepareStatement(sqlSelectCity);
        statement2.setString(1, String.valueOf(idCity));
        ResultSet rsCity = statement2.executeQuery();

        if (rsCity.next() ){
            City cityReturn = new City(rsCity.getString(2),rsCity.getString(3),rsCity.getString(4));
            return cityReturn;
        }
        else {
            System.out.println("non city");
        }
        conn2.close();
    }catch (Exception e){
        System.out.println("Error:" +e);
    }
    return null;
}




}
