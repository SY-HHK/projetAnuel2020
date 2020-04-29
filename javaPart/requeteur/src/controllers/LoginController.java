package controllers;

import com.google.common.hash.Hashing;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Label;
import javafx.scene.control.PasswordField;
import javafx.scene.control.TextField;
import javafx.stage.Stage;

import java.net.URL;

import java.nio.charset.StandardCharsets;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.util.ResourceBundle;

import java.sql.ResultSet;
import java.sql.SQLException;



public class LoginController implements Initializable  {


    @FXML private TextField textMail;
    @FXML private PasswordField textPassword;
    @FXML private Label labelState;


    @FXML
    public void login(ActionEvent event) throws SQLException{
        
        Connection conn = DBConnector.DBconnect.connect();
        PreparedStatement statement =null;
        ResultSet rs = null;

        final String hashed = Hashing.sha256().hashString(textPassword.getText().toString(), StandardCharsets.UTF_8).toString();

        String sql = "SELECT * FROM USER WHERE userEmail = ? AND userPassword = ? AND userPrivilege = 10";

        try{
            statement = conn.prepareStatement(sql);
            statement.setString(1,textMail.getText().toString());
            statement.setString(2,hashed );

            rs = statement.executeQuery();
            if (rs.next()){
                labelState.setText("Conneted !");
                Stage stage = new Stage();
                Parent root = FXMLLoader.load(getClass().getResource("/vue/home.fxml"));
                Scene scene = new Scene(root);
                stage.setTitle("Home");
                stage.setScene(scene);
                stage.show();

            }else{
                labelState.setText("No connected");
            }
        }catch (Exception e){
            System.out.println("Error:" + e);
        }

    }


    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {

    }
}
