package sample;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.scene.control.CheckBox;
import javafx.scene.control.ChoiceBox;
import javafx.scene.control.TextField;

import java.security.Provider;

public class ControllerMainPage {

    private Main main;
    ObservableList<String>idSelectBoxList = FXCollections.observableArrayList("all","userEmail","userFirstName", "userLastName", "userAddress", "userIdCity","userPrivilege","userAnnulation","state");

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
    private void selectUser() {

        UserConnect connect = new UserConnect();
        connect.getData((String) idSelectBox.getValue(),valueField.getText() );

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


}
