package controllers;

import DBConnector.CityConnect;
import DBConnector.EmailConnect;
import com.google.common.hash.Hashing;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import javafx.stage.Stage;
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

public class InsertProviderController implements Initializable {

    @FXML private TextField fieldFName;
    @FXML private TextField fieldLName;
    @FXML private TextField fieldMail;
    @FXML private TextField fieldCompany;
    @FXML private TextField fieldCity;
    @FXML private TextField fieldDepartment;
    @FXML private TextField fieldRegion;
    @FXML private TextField fieldAddress;

    @FXML private Label stateLbl;

    @FXML public Button backBtn;


    @FXML
    public void insertProvider(ActionEvent event) throws SQLException, UnsupportedEncodingException, NoSuchAlgorithmException {

        String firstName = fieldFName.getText();
        String lastName = fieldLName.getText();
        String mail = fieldMail.getText();
        String company = fieldCompany.getText();
        String city = fieldCity.getText().toLowerCase();
        String department = fieldDepartment.getText().toLowerCase();
        String region = fieldRegion.getText().toLowerCase();
        String address = fieldAddress.getText().toLowerCase();


        if (firstName.equals("") || lastName.equals("") || mail.equals("") || company.equals("") || city.equals("") || department.equals("") || region.equals("") || address.equals("")) {
            stateLbl.setText("Please fill all fields");
        }else {

            /*If the city exist nor not in the Database*/
            CityConnect cityConnect = new CityConnect();
            City newCity = cityConnect.cityExists(city, region, department);

            /*If the email address isn't already taken*/
            EmailConnect emailExists = new EmailConnect();
            int nbrRetour = emailExists.emailProvider(mail);

            if (nbrRetour == 0){
                if (saveDataProvider(mail, firstName, lastName, company, address, city) > 0){
                    reset();
                    stateLbl.setText("Provider added !");
                }else {
                    stateLbl.setText("Provider not added !");

                }
            }else{
                stateLbl.setText("Please review email address");
            }
        }
    }


    public int saveDataProvider(String email,String firstName, String lastName, String company, String address, String city) throws SQLException, NoSuchAlgorithmException, UnsupportedEncodingException {

        int nbrRetour = 0;

        UUID uuid = UUID.randomUUID();
        String randomUUIDString = uuid.toString();
        try{
            Connection conn2 = DBConnector.DBconnect.connect();
            String sqlInsertCity = "INSERT INTO PROVIDER (providerFirstName, providerLastName, providerEmail, providerPassword, providerAddress, providerIdCity, companyName,providerGUID) VALUES (?,?,?,?,?,?,?,?)";
            PreparedStatement statement2 = conn2.prepareStatement(sqlInsertCity);

            statement2.setString(1,firstName);
            statement2.setString(2, lastName);
            statement2.setString(3, email);

            final String hashed = Hashing.sha256().hashString(email, StandardCharsets.UTF_8).toString();
            statement2.setString(4, hashed);


            statement2.setString(5, address);


            CityConnect cityTest = new CityConnect();
            int nbr = cityTest.cityIdGetByName(city);
            statement2.setInt(6,nbr);

            statement2.setString(7, company);
            statement2.setString(8, randomUUIDString);

            nbrRetour = statement2.executeUpdate();
            conn2.close();

        }catch (Exception e){
            System.out.println("Error in save data provider:" +e);
        }
        return nbrRetour;
    }


    public void reset(){
        fieldFName.clear();
        fieldLName.clear();
        fieldMail.clear();
        fieldCity.clear();
        fieldCompany.clear();
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
        fieldCompany.clear();
        fieldRegion.clear();
        fieldDepartment.clear();
        fieldAddress.clear();
        stateLbl.setText("");
    }

    @FXML
    public void back(ActionEvent event) {
        Stage stage = (Stage) backBtn.getScene().getWindow();
        stage.close();
    }

    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {

    }



}
