package controllers;

import DBConnector.*;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.CheckBox;
import javafx.scene.control.ChoiceBox;
import javafx.scene.control.TextField;
import application.*;

import java.net.URL;
import java.util.ResourceBundle;

public class ControllerMainPage implements Initializable {

    private Main main;


    @FXML
    private ChoiceBox idSelectBox;

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
    private TextField valueField;

    @FXML
    private void initialize(){
        //idSelectBox.setItems(idSelectBoxList);
    }


    @FXML
    private void showBtn(){

        if (checkUsers.isSelected()){
            UserConnect connect = new UserConnect();
            connect.getAllUser();
        }
        if (checkProvider.isSelected()){
            ProviderConnect connect = new ProviderConnect();
            connect.getAllProvider();
        }
        if (checkService.isSelected()){
            ServiceConnect connect = new ServiceConnect();
            connect.getAllService();
        }

        if (checkBill.isSelected()){
            BillConnect connect = new BillConnect();
            connect.getAllBill();
        }

        if (checkDelivery.isSelected()){
            DeliveryConnect connect = new DeliveryConnect();
            connect.getAllDelivery();
        }


    }


    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {

    }

    @FXML
    public void quitter(ActionEvent actionEvent) {
        System.exit(0);
    }
}
