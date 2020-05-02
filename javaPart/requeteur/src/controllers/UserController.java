package controllers;

import DBConnector.CityConnect;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.stage.Stage;
import model.City;
import model.User;
import java.io.IOException;
import java.net.URL;
import java.sql.*;
import java.util.ResourceBundle;


public class UserController implements Initializable {

    @FXML private TableView<User> tableUser;
    @FXML private TableColumn<User, String> firstName;
    @FXML private TableColumn<User, String> lastName;
    @FXML private TableColumn<User, String> mail;
    @FXML private TableColumn<User, String> address;
    @FXML private TableColumn<User, String> city;

    @FXML public Button backBtn;

    public ObservableList<User> data = FXCollections.observableArrayList();

    @FXML
    public void showUsers(ActionEvent actionEvent) {

        /*Clear the actual table before showing*/
        tableUser.getItems().clear();

        try{
            Connection conn = DBConnector.DBconnect.connect();
            String sqlSelectUSer = "SELECT * FROM USER INNER JOIN CITY ON CITY.idCity = userIdCity WHERE USER.userPrivilege != 10";
            PreparedStatement statement = conn.prepareStatement(sqlSelectUSer);
            ResultSet rs = statement.executeQuery();

            while(rs.next()){

                /*Check if the city exists in the database*/
                String intCity = rs.getString(20);

                CityConnect cityConnect = new CityConnect();
                City newCity = cityConnect.cityInfoGet(intCity);

                if ( newCity != null){
                    data.add(new User(rs.getString(4), rs.getString(5), rs.getString(2), rs.getString(7), newCity.getCityName()));
                }
            }
        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }

        firstName.setCellValueFactory(new PropertyValueFactory<User, String>("firstName"));
        lastName.setCellValueFactory(new PropertyValueFactory<User, String>("lastName"));
        mail.setCellValueFactory(new PropertyValueFactory<User, String>("mail"));
        address.setCellValueFactory(new PropertyValueFactory<User, String>("address"));
        city.setCellValueFactory(new PropertyValueFactory<User, String>("city"));
        tableUser.setItems(data);
    }


    @FXML
    public void addUser(ActionEvent actionEvent) throws IOException {
        Stage stage = new Stage();
        Parent root = FXMLLoader.load(getClass().getResource("/vue/insertUser.fxml"));
        Scene scene = new Scene(root);
        stage.setTitle("user add");
        stage.setScene(scene);
        stage.show();
    }

    @FXML
    public void updateDelete(ActionEvent actionEvent) throws IOException {
        Stage stage = new Stage();
        Parent root = FXMLLoader.load(getClass().getResource("/vue/updateDeleteUser.fxml"));
        Scene scene = new Scene(root);
        stage.setTitle("user update delete");
        stage.setScene(scene);
        stage.show();

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
