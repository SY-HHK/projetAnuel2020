package controllers;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.CheckBox;
import javafx.scene.control.ChoiceBox;
import javafx.scene.control.TextField;
import javafx.scene.layout.AnchorPane;
import javafx.stage.Stage;
import model.User;

import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.ResourceBundle;

public class SelectController implements Initializable {
    @FXML
    private AnchorPane rootPane;

    @FXML private ChoiceBox col1;
    @FXML private ChoiceBox col2;
    @FXML private ChoiceBox col3;
    @FXML private ChoiceBox col4;
    @FXML private ChoiceBox col5;

    @FXML
    private TextField where1;

    private ArrayList<String> tables;

    private ArrayList<String> columns = new ArrayList<String>();

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
        Stage stage = (Stage) where1.getScene().getWindow();
        stage.close();
    }

    @FXML
    public void aboutBringMe(ActionEvent event) {
        Alert alert = new Alert(Alert.AlertType.INFORMATION);
        alert.setTitle("About");
        alert.setHeaderText(null);
        alert.setContentText("Cette application a été créée par BringMe");
        alert.showAndWait();
    }

    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {
        tables = HomeController.getTables();

        String request;
        for (int i=0;i < tables.size(); i++) {
            request = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME=N'" + tables.get(i) + "' LIMIT 19;";

            try {
                Connection conn = DBConnector.DBconnect.connect();
                PreparedStatement statement = conn.prepareStatement(request);
                ResultSet result = statement.executeQuery();

                while (result.next()) {
                    columns.add(tables.get(i)+"."+result.getString(1));
                }
                conn.close();

            } catch (SQLException throwables) {
                throwables.printStackTrace();
            }
        }

        for (int i = 0; i < columns.size(); i++) {
            col1.getItems().add(columns.get(i));
            col2.getItems().add(columns.get(i));
            col3.getItems().add(columns.get(i));
            col4.getItems().add(columns.get(i));
            col5.getItems().add(columns.get(i));
        }
    }
    
}
