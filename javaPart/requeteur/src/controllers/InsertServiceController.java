package controllers;


import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.TextArea;
import javafx.scene.control.TextField;
import javafx.stage.Stage;
import java.io.UnsupportedEncodingException;
import java.net.URL;
import java.security.NoSuchAlgorithmException;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.util.ResourceBundle;


public class InsertServiceController implements Initializable {

    @FXML private TextField fieldTitle;
    @FXML private TextField fieldPrice;
    @FXML private TextArea fieldDescription;

    @FXML private Label stateLbl;

    @FXML public Button backBtn;

    @FXML
    public void insertService() throws NoSuchAlgorithmException, SQLException, UnsupportedEncodingException {
        String title = fieldTitle.getText();
        String price = fieldPrice.getText();
        String description = fieldDescription.getText();



        if (title.equals("") || price.equals("") || description.equals("")) {
            stateLbl.setText("Please fill all fields");
        }else {

            if (saveData(title, price, description) > 0){
                reset();
                stateLbl.setText("Service added !");
            }else {
                stateLbl.setText("Service not added !");

            }
        }
    }

    public int saveData(String title,String price, String description) throws SQLException, NoSuchAlgorithmException, UnsupportedEncodingException {

        int nbrRetour = 0;

        try{
            Connection conn = DBConnector.DBconnect.connect();
            String sqlInsertService = "INSERT INTO SERVICE (serviceTitle, servicePrice, serviceDescription) VALUES (?,?,?)";
            PreparedStatement statement = conn.prepareStatement(sqlInsertService);

            statement.setString(1, title);
            statement.setString(2, price);
            statement.setString(3,description);

            nbrRetour = statement.executeUpdate();
            conn.close();

        }catch (Exception e){
            System.out.println("Error in save data Services:" +e);
        }
        return nbrRetour;
    }

    public void reset(){
        fieldTitle.clear();
        fieldPrice.clear();
        fieldDescription.clear();
        stateLbl.setText("");
    }

    @FXML
    public void reset(ActionEvent event){
        fieldTitle.clear();
        fieldPrice.clear();
        fieldDescription.clear();
        stateLbl.setText("");
    }

    @FXML
    public void back(ActionEvent event) {
        Stage stage = (Stage) backBtn.getScene().getWindow();
        stage.close();
    }

    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {

    }
}
