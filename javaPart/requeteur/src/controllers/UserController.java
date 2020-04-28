package controllers;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.cell.PropertyValueFactory;
import model.User;

import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ResourceBundle;

public class UserController implements Initializable {

    @FXML private TableView<User> tableUser;
    @FXML private TableColumn<User, String> firstName;
    @FXML private TableColumn<User, String> lastName;
    @FXML private TableColumn<User, String> mail;
    @FXML private TableColumn<User, String> phone;
    @FXML private TableColumn<User, String> address;

    public ObservableList<User> data = FXCollections.observableArrayList();

    @FXML
    public void showUsers(ActionEvent actionEvent) {
        try{
            Connection conn = DBConnector.DBconnect.connect();
            String sql = "SELECT * FROM USER INNER JOIN CITY ON CITY.idCity = userIdCity WHERE USER.userPrivilege != 10";
            PreparedStatement statement = conn.prepareStatement(sql);
            ResultSet rs = statement.executeQuery();

            while(rs.next()){
                System.out.println("eheheeh");
                data.add(new User(rs.getString(4), rs.getString(5), rs.getString(2), rs.getString(9), rs.getString(7)));

            }
            conn.close();

        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }

        firstName.setCellValueFactory(new PropertyValueFactory<User, String>("firstName"));
        lastName.setCellValueFactory(new PropertyValueFactory<User, String>("lastName"));
        mail.setCellValueFactory(new PropertyValueFactory<User, String>("mail"));
        phone.setCellValueFactory(new PropertyValueFactory<User, String>("phone"));
        address.setCellValueFactory(new PropertyValueFactory<User, String>("address"));
        tableUser.setItems(data);
    }


    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {

    }


}
