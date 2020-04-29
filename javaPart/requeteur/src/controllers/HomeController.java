package controllers;

import DBConnector.*;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.CheckBox;
import javafx.scene.control.ChoiceBox;
import javafx.scene.control.TextField;
import application.*;
import javafx.scene.layout.AnchorPane;
import javafx.stage.Stage;

import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;

import static org.slf4j.MDC.clear;

public class HomeController implements Initializable {

    @FXML
    private AnchorPane rootPane;

    @FXML
    private CheckBox checkUsers;

    @FXML
    private CheckBox checkProvider;

    @FXML
    private CheckBox checkService;

    @FXML
    private CheckBox checkBill;

    @FXML
    private CheckBox checkDelivery;

    @FXML
    private void showBtn() throws IOException {

        if (checkUsers.isSelected()){
            Stage stage = new Stage();
            Parent root = FXMLLoader.load(getClass().getResource("/vue/user.fxml"));
            Scene scene = new Scene(root);
            stage.setTitle("user");
            stage.setScene(scene);
            stage.show();
        }
        if (checkProvider.isSelected()){

        }
        if (checkService.isSelected()){

        }

        if (checkBill.isSelected()){

        }

        if (checkDelivery.isSelected()){

        }
    }


    @FXML
    public void userLaunch() throws IOException {
        Stage stage = new Stage();
        Parent root = FXMLLoader.load(getClass().getResource("/vue/user.fxml"));
        Scene scene = new Scene(root);
        stage.setTitle("user");
        stage.setScene(scene);
        stage.show();

    }

    /* Menus bar functions */

    @FXML
    public void quitter(ActionEvent actionEvent) {
        System.exit(0);
    }

    @FXML
    public void aboutBringMe(ActionEvent event) {
        Alert alert = new Alert(Alert.AlertType.INFORMATION);
        alert.setTitle("About");
        alert.setHeaderText(null);
        alert.setContentText("Cette application a été crée par BringMe");
        alert.showAndWait();
    }

    /*Initialiser */
    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {

    }

}
