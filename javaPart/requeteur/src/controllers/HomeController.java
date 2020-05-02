package controllers;

import DBConnector.*;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.fxml.JavaFXBuilderFactory;
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
import java.util.ArrayList;
import java.util.ResourceBundle;

import static org.slf4j.MDC.clear;

public class HomeController implements Initializable {

    @FXML
    private AnchorPane rootPane;

    @FXML
    private CheckBox checkUsers;
    @FXML private void blockUser() {
        blockIfNotJoined("USER");
    }

    @FXML
    private CheckBox checkProvider;
    @FXML private void blockProvider() {
        blockIfNotJoined("PROVIDER");
    }

    @FXML
    private CheckBox checkService;
    @FXML private void blockService() {
        blockIfNotJoined("SERVICE");
    }

    @FXML
    private CheckBox checkBill;
    @FXML private void blockBill() {
        blockIfNotJoined("BILL");
    }

    @FXML
    private CheckBox checkDelivery;
    @FXML private void blockDelivery() {
        blockIfNotJoined("DELIVERY");
    }

    private static ArrayList<String> tables = new ArrayList<String>();

    @FXML
    private void showBtn() throws IOException {
        tables.clear();

        if (checkUsers.isSelected()){
            tables.add("USER");
        }
        if (checkBill.isSelected()){
            tables.add("BILL");
        }
        if (checkDelivery.isSelected()){
            tables.add("DELIVERY");
        }
        if (checkProvider.isSelected()){
            tables.add("PROVIDER");
        }
        if (checkService.isSelected()){
            tables.add("SERVICE");
        }

        Stage stage = new Stage();
        Parent root = FXMLLoader.load(getClass().getResource("/vue/select.fxml"));
        Scene scene = new Scene(root);
        stage.setUserData(tables);
        stage.setTitle("Selection");
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

    private void blockIfNotJoined(String table) {
        if (table.matches("USER")) {
            checkBill.setDisable(false);
            if (!checkBill.isSelected()) checkDelivery.setDisable(true);
            if (checkDelivery.isSelected() || checkProvider.isSelected()) checkProvider.setDisable(false);
            else checkProvider.setDisable(true);
            if (checkDelivery.isSelected() || checkService.isSelected()) checkService.setDisable(false);
            else checkService.setDisable(true);
        }
        if (table.matches("BILL")) {
            if (checkBill.isSelected()) {
                checkUsers.setDisable(false);
                checkDelivery.setDisable(false);
                if (checkDelivery.isSelected() || checkProvider.isSelected()) checkProvider.setDisable(false);
                else checkProvider.setDisable(true);
                if (checkDelivery.isSelected() || checkService.isSelected()) checkService.setDisable(false);
                else checkService.setDisable(true);
            }
            else {
                if (checkDelivery.isSelected()){
                    checkUsers.setSelected(false);
                    checkUsers.setDisable(true);
                }
            }
        }
        if (table.matches("DELIVERY")) {
            if (checkDelivery.isSelected()) {
                if (!checkBill.isSelected()) checkUsers.setDisable(true);
                checkBill.setDisable(false);
                checkProvider.setDisable(false);
                checkService.setDisable(false);
            }
            else {
                checkProvider.setSelected(false);
                checkProvider.setDisable(true);
                checkService.setSelected(false);
                checkService.setDisable(true);
                }
        }
        if (table.matches("PROVIDER")) {
            if (!checkUsers.isSelected()) checkUsers.setDisable(true);
            checkDelivery.setDisable(false);
            if (checkDelivery.isSelected()) checkBill.setDisable(false); else checkBill.setDisable(true);
            if (checkDelivery.isSelected()) checkService.setDisable(false);
        }
        if (table.matches("SERVICE")) {
            if (!checkUsers.isSelected()) checkUsers.setDisable(true);
            checkDelivery.setDisable(false);
            if (checkDelivery.isSelected()) checkBill.setDisable(false); else checkBill.setDisable(true);
            if (checkDelivery.isSelected()) checkProvider.setDisable(false);
        }
        if (!checkUsers.isSelected() && !checkBill.isSelected() && !checkDelivery.isSelected() && !checkProvider.isSelected() && !checkService.isSelected()) {
            checkUsers.setDisable(false);
            checkBill.setDisable(false);
            checkDelivery.setDisable(false);
            checkProvider.setDisable(false);
            checkService.setDisable(false);
        }
    }

    public static ArrayList<String> getTables() {
        return tables;
    }

    public static void setTables(ArrayList<String> tables) {
        HomeController.tables = tables;
    }
}
