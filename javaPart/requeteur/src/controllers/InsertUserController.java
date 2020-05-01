package controllers;

import DBConnector.CityConnect;
import com.google.common.hash.Hashing;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import model.City;
import java.io.UnsupportedEncodingException;
import java.net.URL;
import java.nio.charset.StandardCharsets;
import java.security.NoSuchAlgorithmException;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.util.ResourceBundle;
import java.util.UUID;

public class InsertUserController implements Initializable {

    @FXML private TextField fieldFName;
    @FXML private TextField fieldLName;
    @FXML private TextField fieldMail;
    @FXML private TextField fieldCity;
    @FXML private TextField fieldDepartment;
    @FXML private TextField fieldRegion;
    @FXML private TextField fieldAddress;

    @FXML private Label stateLbl;

    @FXML
    public void insertUser() throws NoSuchAlgorithmException, SQLException, UnsupportedEncodingException {
        String firstName = fieldFName.getText();
        String lastName = fieldLName.getText();
        String mail = fieldMail.getText();
        String city = fieldCity.getText().toLowerCase();
        String department = fieldDepartment.getText().toLowerCase();
        String region = fieldRegion.getText().toLowerCase();
        String address = fieldAddress.getText().toLowerCase();


        if (firstName.equals("") || lastName.equals("") || mail.equals("") || city.equals("") || department.equals("") || region.equals("") || address.equals("")) {
            stateLbl.setText("Please fill all fields");
        }else {

            /*If the city exist nor not in the Database*/
            CityConnect cityConnect = new CityConnect();
            City newCity = cityConnect.cityExists(city, region, department);


            if (saveData(mail, firstName, lastName, address, city) > 0){
                reset();
                stateLbl.setText("User added !");
            }else {
                stateLbl.setText("User not added !");

            }
        }
    }

    public int saveData(String email,String firstName, String lastName, String address, String city) throws SQLException, NoSuchAlgorithmException, UnsupportedEncodingException {

        int nbrRetour = 0;

        UUID uuid = UUID.randomUUID();
        String randomUUIDString = uuid.toString();
        try{
            Connection conn2 = DBConnector.DBconnect.connect();
            String sqlInsertCity = "INSERT INTO USER (userEmail, userPassword, userFirstName, userLastName, userAddress, userIdCity, userPrivilege, userGuid) VALUES (?,?,?,?,?,?,?,?)";
            PreparedStatement statement2 = conn2.prepareStatement(sqlInsertCity);

            statement2.setString(1, email);

            final String hashed = Hashing.sha256().hashString(email, StandardCharsets.UTF_8).toString();
            statement2.setString(2, hashed);

            statement2.setString(3,firstName);
            statement2.setString(4, lastName);
            statement2.setString(5, address);


            CityConnect cityTest = new CityConnect();
            int nbr = cityTest.cityIdGetByName(city);
            statement2.setInt(6,nbr);

            statement2.setInt(7, 1);
            statement2.setString(8, randomUUIDString);

            nbrRetour = statement2.executeUpdate();
            conn2.close();

        }catch (Exception e){
            System.out.println("Error in save data:" +e);
        }
        return nbrRetour;
    }

    public void reset(){
        fieldFName.clear();
        fieldLName.clear();
        fieldMail.clear();
        fieldCity.clear();
        fieldRegion.clear();
        fieldDepartment.clear();
        fieldAddress.clear();
        stateLbl.setText("");
    }

    @FXML
    public void reset(ActionEvent event){
        fieldFName.clear();
        fieldLName.clear();
        fieldMail.clear();
        fieldCity.clear();
        fieldRegion.clear();
        fieldDepartment.clear();
        fieldAddress.clear();
        stateLbl.setText("");
    }

    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {

    }
}
