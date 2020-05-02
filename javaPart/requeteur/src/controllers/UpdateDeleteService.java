package controllers;


import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.TextArea;
import javafx.scene.control.TextField;
import javafx.stage.Stage;
import model.Service;

import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ResourceBundle;

public class UpdateDeleteService implements Initializable {

    @FXML private TextField fieldFind;

    @FXML private TextField fieldTitle;
    @FXML private TextField fieldPrice;
    @FXML private TextArea fieldDescription;


    @FXML private Label stateLbl;

    @FXML public Button backBtn;

    @FXML
    public void findService(ActionEvent event) throws SQLException {
        String find = fieldFind.getText();

        if (find.equals("")){
            stateLbl.setText("Please fill the first field");
        }else {

            if ( find(find) != null){
                Service service = find(find);

                fieldTitle.setText(service.getTitle());
                fieldPrice.setText(String.valueOf(service.getPrice()));
                fieldDescription.setText(service.getDescription());

            }else {
                stateLbl.setText("Service not found");
            }
        }
    }

    @FXML
    public void updateService(ActionEvent event) throws SQLException {

        String find = fieldFind.getText();
        String title = fieldTitle.getText();
        String price = fieldPrice.getText();
        String description = fieldDescription.getText();

        Float newFloat = Float.valueOf(price);


        if (find.equals("") || title.equals("") || price.equals("") || description.equals("")) {
            stateLbl.setText("Please fill all fields");
        } else {
            /*Update Service*/
            if (update(find,title,newFloat, description) > 0){
                reset();
                stateLbl.setText("Service updated !");
            }else {
                stateLbl.setText("Service not updated !");

            }
        }
    }

    @FXML
    public void deleteService(ActionEvent event){

        String find = fieldFind.getText();

        if (find.equals("")){
            stateLbl.setText("Please fill the first field");
        }else {

            if(delete(find)>0){
                reset();
                stateLbl.setText("Service deleted ! ");

            }else{
                stateLbl.setText("Service couldn't be deleted");
            }
        }
    }


    public Service find(String title){
        try{
            Connection conn = DBConnector.DBconnect.connect();
            String sqlSelectFind = "SELECT * FROM SERVICE WHERE serviceTitle=?";
            PreparedStatement statement = conn.prepareStatement(sqlSelectFind);
            statement.setString(1, title);

            ResultSet rs = statement.executeQuery();

            if (rs.next()){

                Service service =  new Service(rs.getString(2), rs.getFloat(3), rs.getString(4));
                return service;
            }

            conn.close();
        }catch (SQLException e){
            System.out.println("Error in function find service:" +e);
        }

        return null;

    }

    public int update(String find,String title,Float price, String description){
        int nbrRetour = 0;

        try{
            Connection conn = DBConnector.DBconnect.connect();
            String sqlUpdateService = "UPDATE SERVICE SET serviceTitle = ?, servicePrice =?, serviceDescription=? WHERE serviceTitle = ?";
            PreparedStatement statement2 = conn.prepareStatement(sqlUpdateService);

            statement2.setString(1, title);
            statement2.setFloat(2,price);
            statement2.setString(3, description);
            statement2.setString(4, find);

            nbrRetour = statement2.executeUpdate();
            conn.close();

        }catch (Exception e){
            System.out.println("Error in update service:" +e);
        }
        return nbrRetour;

    }

    public int delete(String title){
        int nbrRetour = 0;

        try{
            Connection conn = DBConnector.DBconnect.connect();
            String sqlDeleteService = "DELETE FROM SERVICE WHERE serviceTitle = ?";
            PreparedStatement statement = conn.prepareStatement(sqlDeleteService);
            statement.setString(1, title);
            nbrRetour = statement.executeUpdate();
            conn.close();

        }catch (SQLException e){
            System.out.println("Error in delete service:" +e);
        }
        return nbrRetour;
    }

    public void reset(){
        fieldFind.clear();
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
