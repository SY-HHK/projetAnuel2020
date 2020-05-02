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
import model.Provider;
import model.User;

import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ResourceBundle;

public class ProviderController implements Initializable {


    @FXML private TableView<Provider> tableProvider;
    @FXML private TableColumn<Provider, String> firstName;
    @FXML private TableColumn<Provider, String> lastName;
    @FXML private TableColumn<Provider, String> mail;
    @FXML private TableColumn<Provider, String> company;
    @FXML private TableColumn<Provider, String> address;
    @FXML private TableColumn<Provider, String> city;

    @FXML public Button backBtn;

    public ObservableList<Provider> data = FXCollections.observableArrayList();

    @FXML
    public void showProvider(ActionEvent actionEvent) {

        /*Clear the actual table before showing*/
        tableProvider.getItems().clear();

        try{
            Connection conn = DBConnector.DBconnect.connect();
            String sqlSelectUSer = "SELECT * FROM PROVIDER INNER JOIN CITY ON CITY.idCity = providerIdCity";
            PreparedStatement statement = conn.prepareStatement(sqlSelectUSer);
            ResultSet rs = statement.executeQuery();

            while(rs.next()){

                /*Check if the city exists in the database*/
                String intCity = rs.getString(8);

                CityConnect cityConnect = new CityConnect();
                City newCity = cityConnect.cityInfoGet(intCity);

                if ( newCity != null){
                    data.add(new Provider(rs.getString(2), rs.getString(3), rs.getString(5), rs.getString(9), rs.getString(7), newCity.getCityName()));
                }
            }
        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }

        firstName.setCellValueFactory(new PropertyValueFactory<Provider, String>("firstName"));
        lastName.setCellValueFactory(new PropertyValueFactory<Provider, String>("lastName"));
        mail.setCellValueFactory(new PropertyValueFactory<Provider, String>("mail"));
        company.setCellValueFactory(new PropertyValueFactory<Provider, String>("companyName"));
        address.setCellValueFactory(new PropertyValueFactory<Provider, String>("address"));
        city.setCellValueFactory(new PropertyValueFactory<Provider, String>("city"));
        tableProvider.setItems(data);
    }


    @FXML
    public void addProvider(ActionEvent actionEvent) throws IOException {
        Stage stage = new Stage();
        Parent root = FXMLLoader.load(getClass().getResource("/vue/insertProvider.fxml"));
        Scene scene = new Scene(root);
        stage.setTitle("provider add");
        stage.setScene(scene);
        stage.show();
    }

    @FXML
    public void updateDelete(ActionEvent actionEvent) throws IOException {
        Stage stage = new Stage();
        Parent root = FXMLLoader.load(getClass().getResource("/vue/updateDeleteProvider.fxml"));
        Scene scene = new Scene(root);
        stage.setTitle("provider update delete");
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
