package controllers;

import DBConnector.CityConnect;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import javafx.stage.Stage;
import model.City;
import model.Provider;

import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ResourceBundle;

public class UpdateDeleteProvider implements Initializable {

    @FXML
    private TextField fieldFind;

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
    public void findProvider(ActionEvent event) throws SQLException {
        String find = fieldFind.getText();

        if (find.equals("")){
            stateLbl.setText("Please fill the first field");
        }else {

            if ( find(find) != null){
                Provider provider = find(find);

                CityConnect cityConnect = new CityConnect();
                City infoCity = cityConnect.cityInfoGetByName(provider.getCity());

                fieldFName.setText(provider.getFirstName());
                fieldLName.setText(provider.getLastName());
                fieldMail.setText(provider.getMail());
                fieldCompany.setText(provider.getCompanyName());
                fieldCity.setText(provider.getCity());
                fieldAddress.setText(provider.getAddress());
                fieldRegion.setText(infoCity.getCityRegion());
                fieldDepartment.setText(infoCity.getCityDepartment());

            }else {
                stateLbl.setText("Provider not found");
            }
        }
    }

    @FXML
    public void updateProvider(ActionEvent event) throws SQLException {

        String find = fieldFind.getText();
        String firstName = fieldFName.getText();
        String lastName = fieldLName.getText();
        String mail = fieldMail.getText();
        String company = fieldCompany.getText();
        String city = fieldCity.getText().toLowerCase();
        String department = fieldDepartment.getText().toLowerCase();
        String region = fieldRegion.getText().toLowerCase();
        String address = fieldAddress.getText().toLowerCase();


        if (find.equals("") || firstName.equals("") || lastName.equals("") || mail.equals("") || company.equals("")|| city.equals("") || department.equals("") || region.equals("") || address.equals("")) {
            stateLbl.setText("Please fill all fields");
        } else {
            /*If the city exist nor not in the Database*/
            CityConnect cityConnect = new CityConnect();
            City newCity = cityConnect.cityExists(city, region, department);

            /*Update Provider*/
            if (update(find, mail, firstName, lastName,company, address, city) > 0){
                reset();
                stateLbl.setText("Provider updated !");
            }else {
                stateLbl.setText("Provider not updated !");

            }
        }
    }

    @FXML
    public void deleteProvider(ActionEvent event){

        String find = fieldFind.getText();

        if (find.equals("")){
            stateLbl.setText("Please fill the first field");
        }else {

            if(delete(find)>0){
                reset();
                stateLbl.setText("Provider deleted ! ");

            }else{
                stateLbl.setText("Provider couldn't be deleted");
            }
        }
    }


    public Provider find(String mail){
        try{
            Connection conn2 = DBConnector.DBconnect.connect();
            String sqlSelectFind = "SELECT * FROM PROVIDER INNER JOIN CITY ON idCity = providerIdCity WHERE providerEmail = ?";
            PreparedStatement statement2 = conn2.prepareStatement(sqlSelectFind);
            statement2.setString(1, mail);

            ResultSet rs = statement2.executeQuery();

            if (rs.next()){
                /*Check if the city exists in the database*/
                String intCity = rs.getString(8);

                CityConnect cityConnect = new CityConnect();
                City newCity = cityConnect.cityInfoGet(intCity);

                Provider provider =  new Provider(rs.getString(2), rs.getString(3), rs.getString(5), rs.getString(9),rs.getString(7), newCity.getCityName());
                return provider;
            }

            conn2.close();
        }catch (SQLException e){
            System.out.println("Error in function find:" +e);
        }

        return null;

    }

    public int update(String find,String email,String firstName, String lastName,String company, String address, String city){
        int nbrRetour = 0;

        try{
            Connection conn2 = DBConnector.DBconnect.connect();
            String sqlInsertCity = "UPDATE PROVIDER SET providerEmail = ?, providerFirstName =?, providerLastName=?, companyName = ?,providerAddress=?, providerIdCity=? WHERE providerEmail = ?";
            PreparedStatement statement2 = conn2.prepareStatement(sqlInsertCity);

            statement2.setString(1, email);
            statement2.setString(2,firstName);
            statement2.setString(3, lastName);
            statement2.setString(4, company);
            statement2.setString(5, address);


            CityConnect cityTest = new CityConnect();
            int nbr = cityTest.cityIdGetByName(city);
            statement2.setInt(6,nbr);

            statement2.setString(7,find);

            nbrRetour = statement2.executeUpdate();
            conn2.close();

        }catch (Exception e){
            System.out.println("Error in save data:" +e);
        }
        return nbrRetour;

    }

    public int delete(String mail){
        int nbrRetour = 0;

        try{
            Connection conn2 = DBConnector.DBconnect.connect();
            String sqlInsertCity = "DELETE FROM PROVIDER WHERE providerEmail = ?";
            PreparedStatement statement2 = conn2.prepareStatement(sqlInsertCity);
            statement2.setString(1, mail);
            nbrRetour = statement2.executeUpdate();
            conn2.close();

        }catch (SQLException e){
            System.out.println("Error in save data:" +e);
        }
        return nbrRetour;
    }

    public void reset(){
        fieldFind.clear();
        fieldFName.clear();
        fieldLName.clear();
        fieldMail.clear();
        fieldCompany.clear();
        fieldCity.clear();
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
