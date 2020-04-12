package sample;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.scene.control.ChoiceBox;
import javafx.scene.control.TextField;


public class Controller {

    private Main main;
    ObservableList<String>idSelectUserBoxList = FXCollections.observableArrayList("idUser","userEmail","userFirstName", "userLastName", "userAddress", "userIdCity","userPrivilege","userAnnulation","state","*");

    @FXML
    private ChoiceBox idSelectUserBox;
    @FXML
    private ChoiceBox idSelectServiceBox;
    @FXML
    private ChoiceBox idSelectProviderBox;
    @FXML
    private ChoiceBox idSelectBillBox;
    @FXML
    private ChoiceBox idSelectDeliveryBox;


    @FXML
    private TextField valueField;

    @FXML
    private void initialize(){
        idSelectUserBox.setItems(idSelectUserBoxList);
    }

    @FXML
    private void select() {
        System.out.println(idSelectUserBox.getValue());
        System.out.println(valueField.getText());
    }

}
