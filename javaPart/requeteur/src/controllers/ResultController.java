package controllers;

import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;

import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.ResourceBundle;

public class ResultController implements Initializable {

    @FXML
    private TableView tableResult;

    ArrayList<String> tables;
    ArrayList<String> columns;
    ArrayList<String> where;

    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {
        tables = HomeController.getTables();
        columns = SelectController.getColumns();
        where = SelectController.getWhere();

        if (columns.size() > 15) {
            tableResult.setPrefWidth(1600.0);
        }
        if (columns.size() > 20) {
            tableResult.setPrefWidth(2500.0);
        }
        if (columns.size() > 25) {
            tableResult.setPrefWidth(3000.0);
        }
        if (columns.size() > 30) {
            tableResult.setPrefWidth(3500.0);
        }

        for (int i = 0; i < columns.size(); i++) {
            tableResult.getColumns().add(new TableColumn(columns.get(i)));
        }

        String request = "SELECT * FROM ";
        //ajouter INNER JOIN nomTable pour chaque iteration
        //ajouter dans HomeControler un bloquage si les tables sont pas liés

        try {
            Connection conn = DBConnector.DBconnect.connect();
            PreparedStatement statement = conn.prepareStatement(request);
            ResultSet result = statement.executeQuery();

            while (result.next()) {
                //columns.add(tables.get(i)+"."+result.getString(1));
            }
            conn.close();

        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }
    }
}
