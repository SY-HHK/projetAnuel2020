package controllers;

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

import model.Service;

import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ResourceBundle;

public class ServiceController implements Initializable {


    @FXML
    private TableView<Service> tableService;
    @FXML private TableColumn<Service, String> title;
    @FXML private TableColumn<Service, Float> price;
    @FXML private TableColumn<Service, String> description;

    @FXML public Button backBtn;

    public ObservableList<Service> data = FXCollections.observableArrayList();

    @FXML
    public void showService(ActionEvent actionEvent) {

        /*Clear the actual table before showing*/
        tableService.getItems().clear();

        try{
            Connection conn = DBConnector.DBconnect.connect();
            String sqlSelectService = "SELECT * FROM SERVICE";
            PreparedStatement statement = conn.prepareStatement(sqlSelectService);
            ResultSet rs = statement.executeQuery();

            while(rs.next()){
                data.add(new Service(rs.getString(2), rs.getFloat(3), rs.getString(4)));
            }
        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }

        title.setCellValueFactory(new PropertyValueFactory<Service, String>("title"));
        price.setCellValueFactory(new PropertyValueFactory<Service, Float>("price"));
        description.setCellValueFactory(new PropertyValueFactory<Service, String>("description"));

        tableService.setItems(data);
    }


    @FXML
    public void addService(ActionEvent actionEvent) throws IOException {
        Stage stage = new Stage();
        Parent root = FXMLLoader.load(getClass().getResource("/vue/insertService.fxml"));
        Scene scene = new Scene(root);
        stage.setTitle("service add");
        stage.setScene(scene);
        stage.show();
    }

    @FXML
    public void updateDelete(ActionEvent actionEvent) throws IOException {
        Stage stage = new Stage();
        Parent root = FXMLLoader.load(getClass().getResource("/vue/updateDeleteService.fxml"));
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
