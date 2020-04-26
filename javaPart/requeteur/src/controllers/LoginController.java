package controllers;

import DBConnector.DBconnect;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Label;
import javafx.scene.control.PasswordField;
import javafx.scene.control.TextField;

import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.util.ResourceBundle;

import java.sql.PreparedStatement;
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

        String sha256hex = org.apache.commons.codec.digest.DigestUtils.sha256Hex(textPassword.getText().toString());

        String sql = "SELECT * FROM USER WHERE userEmail = ? AND userPassword = ? AND userPrivilege = 10";

        try{
            statement = conn.prepareStatement(sql);
            statement.setString(1,textMail.getText().toString());
            statement.setString(2,sha256hex );

            rs = statement.executeQuery();
            if (rs.next()){
                labelState.setText("Conneted !");
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
