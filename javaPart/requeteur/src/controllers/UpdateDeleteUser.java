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
import model.User;

import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ResourceBundle;


public class UpdateDeleteUser implements Initializable {


    @FXML private TextField fieldFind;

    @FXML private TextField fieldFName;
    @FXML private TextField fieldLName;
    @FXML private TextField fieldMail;
    @FXML private TextField fieldCity;
    @FXML private TextField fieldDepartment;
    @FXML private TextField fieldRegion;
    @FXML private TextField fieldAddress;

    @FXML private Label stateLbl;

    @FXML public Button backBtn;

    @FXML
    public void findUser(ActionEvent event) throws SQLException {
        String find = fieldFind.getText();

        if (find.equals("")){
            stateLbl.setText("Please fill the first field");
        }else {

            if ( find(find) != null){
                User user = find(find);

                CityConnect cityConnect = new CityConnect();
                City infoCity = cityConnect.cityInfoGetByName(user.getCity());

                fieldFName.setText(user.getFirstName());
                fieldLName.setText(user.getLastName());
                fieldMail.setText(user.getMail());
                fieldCity.setText(user.getCity());
                fieldAddress.setText(user.getAddress());
                fieldRegion.setText(infoCity.getCityRegion());
                fieldDepartment.setText(infoCity.getCityDepartment());

            }else {
                stateLbl.setText("User not found");
            }
        }
    }

    @FXML
    public void updateUser(ActionEvent event) throws SQLException {

        String find = fieldFind.getText();
        String firstName = fieldFName.getText();
        String lastName = fieldLName.getText();
        String mail = fieldMail.getText();
        String city = fieldCity.getText().toLowerCase();
        String department = fieldDepartment.getText().toLowerCase();
        String region = fieldRegion.getText().toLowerCase();
        String address = fieldAddress.getText().toLowerCase();


        if (find.equals("") || firstName.equals("") || lastName.equals("") || mail.equals("") || city.equals("") || department.equals("") || region.equals("") || address.equals("")) {
            stateLbl.setText("Please fill all fields");
        } else {
            /*If the city exist nor not in the Database*/
            CityConnect cityConnect = new CityConnect();
            City newCity = cityConnect.cityExists(city, region, department);

            /*Update User*/
            if (update(find, mail, firstName, lastName, address, city) > 0){
                reset();
                stateLbl.setText("User updated !");
            }else {
                stateLbl.setText("User not updated !");

            }
        }
    }

    @FXML
    public void deleteUser(ActionEvent event){

        String find = fieldFind.getText();

        if (find.equals("")){
            stateLbl.setText("Please fill the first field");
        }else {

            if(delete(find)>0){
                reset();
                stateLbl.setText("User deleted ! ");

            }else{
                stateLbl.setText("User couldn't be deleted");
            }
        }
    }


    public User find(String mail){
        try{
            Connection conn2 = DBConnector.DBconnect.connect();
            String sqlSelectFind = "SELECT * FROM USER INNER JOIN CITY ON CITY.idCity = userIdCity WHERE USER.userEmail = ?";
            PreparedStatement statement2 = conn2.prepareStatement(sqlSelectFind);
            statement2.setString(1, mail);

            ResultSet rs = statement2.executeQuery();

            if (rs.next()){
                /*Check if the city exists in the database*/
                String intCity = rs.getString(20);

                CityConnect cityConnect = new CityConnect();
                City newCity = cityConnect.cityInfoGet(intCity);

               User user =  new User(rs.getString(4), rs.getString(5), rs.getString(2), rs.getString(7), newCity.getCityName());
                return user;
            }

            conn2.close();
        }catch (SQLException e){
            System.out.println("Error in function find:" +e);
        }

        return null;

    }

    public int update(String find,String email,String firstName, String lastName, String address, String city){
        int nbrRetour = 0;

        try{
            Connection conn2 = DBConnector.DBconnect.connect();
            String sqlInsertCity = "UPDATE USER SET userEmail = ?, userFirstName =?, userLastName=?, userAddress=?, userIdCity=? WHERE userEmail = ?";
            PreparedStatement statement2 = conn2.prepareStatement(sqlInsertCity);

            statement2.setString(1, email);
            statement2.setString(2,firstName);
            statement2.setString(3, lastName);
            statement2.setString(4, address);


            CityConnect cityTest = new CityConnect();
            int nbr = cityTest.cityIdGetByName(city);
            statement2.setInt(5,nbr);

            statement2.setString(6,find);

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
            String sqlInsertCity = "DELETE FROM USER WHERE userEmail = ?";
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
