package controllers;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.CheckBox;
import javafx.scene.control.Label;
import javafx.scene.layout.AnchorPane;
import javafx.stage.Stage;
import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;


public class HomeController implements Initializable {

    @FXML
    private AnchorPane rootPane;

    @FXML
    private CheckBox checkUsers;

    @FXML
    private CheckBox checkProvider;

    @FXML
    private CheckBox checkBill;

    @FXML
    private CheckBox checkDelivery;

    @FXML
    private CheckBox checkServices;

    @FXML
    private Label stateLbl;

    @FXML
    private void selectBtn() throws IOException {

        if (checkUsers.isSelected()){

        }
        if (checkProvider.isSelected()){

        }

        if (checkBill.isSelected()){

        }

        if (checkDelivery.isSelected()){

        }

        if (checkServices.isSelected()){

        }
    }


    @FXML
    private void insertTable() throws IOException {

        stateLbl.setText("");

        if (checkUsers.isSelected() && checkProvider.isSelected()==false && checkServices.isSelected()==false && checkBill.isSelected()==false && checkDelivery.isSelected()==false){

            Stage stage = new Stage();
            Parent root = FXMLLoader.load(getClass().getResource("/vue/user.fxml"));
            Scene scene = new Scene(root);
            stage.setTitle("user");
            stage.setScene(scene);
            stage.show();

        }
        if (checkProvider.isSelected() && checkUsers.isSelected()==false && checkServices.isSelected()==false && checkBill.isSelected()==false && checkDelivery.isSelected()==false){

            Stage stage = new Stage();
            Parent root = FXMLLoader.load(getClass().getResource("/vue/provider.fxml"));
            Scene scene = new Scene(root);
            stage.setTitle("Provider");
            stage.setScene(scene);
            stage.show();

        }

        if (checkServices.isSelected() && checkProvider.isSelected()==false && checkUsers.isSelected()==false && checkBill.isSelected()==false && checkDelivery.isSelected()==false){

            Stage stage = new Stage();
            Parent root = FXMLLoader.load(getClass().getResource("/vue/service.fxml"));
            Scene scene = new Scene(root);
            stage.setTitle("Service");
            stage.setScene(scene);
            stage.show();
        }

        if (checkDelivery.isSelected() || checkBill.isSelected()){
            stateLbl.setText("You can not insert in this or these table(s)");
        }



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
