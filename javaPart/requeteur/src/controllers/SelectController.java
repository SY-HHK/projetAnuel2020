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

    @FXML private TextField where1;
    @FXML private TextField where2;
    @FXML private TextField where3;
    @FXML private TextField where4;
    @FXML private TextField where5;

    @FXML private ChoiceBox op1;
    @FXML private ChoiceBox op2;
    @FXML private ChoiceBox op3;
    @FXML private ChoiceBox op4;
    @FXML private ChoiceBox op5;

    private ArrayList<String> tables;

    private static ArrayList<String> columns = new ArrayList<String>();

    private static ArrayList<String> where = new ArrayList<String>();

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
        columns.clear();
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

        setOpChoice();
    }

    @FXML
    private void executeBtn() throws IOException {

        where.clear();

        if (!where1.getText().isEmpty()){
            where.add(col1.getValue().toString()+op1.getValue().toString()+"'"+where1.getText()+"'");
        }
        if (!where2.getText().isEmpty()){
            where.add(col2.getValue().toString()+op2.getValue().toString()+"'"+where2.getText()+"'");
        }
        if (!where3.getText().isEmpty()){
            where.add(col3.getValue().toString()+op3.getValue().toString()+"'"+where3.getText()+"'");
        }
        if (!where4.getText().isEmpty()){
            where.add(col4.getValue().toString()+op4.getValue().toString()+"'"+where4.getText()+"'");
        }
        if (!where5.getText().isEmpty()){
            where.add(col5.getValue().toString()+op5.getValue().toString()+"'"+where5.getText()+"'");
        }

        Stage stage = new Stage();
        Parent root = FXMLLoader.load(getClass().getResource("/vue/result.fxml"));
        Scene scene = new Scene(root);
        stage.setUserData(tables);
        stage.setTitle("Resultats");
        stage.setScene(scene);
        stage.show();
    }

    public static ArrayList<String> getWhere() {
        return where;
    }

    public static void setWhere(ArrayList<String> where) {
        SelectController.where = where;
    }

    public static ArrayList<String> getColumns() {
        return columns;
    }

    public static void setColumns(ArrayList<String> columns) {
        SelectController.columns = columns;
    }

    //need clean code here
    private void setOpChoice() {
        op1.getItems().add(" = ");
        op1.getItems().add(" > ");
        op1.getItems().add(" >= ");
        op1.getItems().add(" < ");
        op1.getItems().add(" <= ");

        op2.getItems().add(" = ");
        op2.getItems().add(" > ");
        op2.getItems().add(" >= ");
        op2.getItems().add(" < ");
        op2.getItems().add(" <= ");

        op3.getItems().add(" = ");
        op3.getItems().add(" > ");
        op3.getItems().add(" >= ");
        op3.getItems().add(" < ");
        op3.getItems().add(" <= ");

        op4.getItems().add(" = ");
        op4.getItems().add(" > ");
        op4.getItems().add(" >= ");
        op4.getItems().add(" < ");
        op4.getItems().add(" <= ");

        op5.getItems().add(" = ");
        op5.getItems().add(" > ");
        op5.getItems().add(" >= ");
        op5.getItems().add(" < ");
        op5.getItems().add(" <= ");
    }
}
