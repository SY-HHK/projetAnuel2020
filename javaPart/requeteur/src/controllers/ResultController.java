package controllers;

import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.cell.PropertyValueFactory;

import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
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
            TableColumn col = new TableColumn(columns.get(i));
            col.setCellValueFactory(new PropertyValueFactory<>(columns.get(i)));
            tableResult.getColumns().add(col);
        }

        String request = "SELECT * FROM " + getSqlInnerJoin() + getSqlWhere();
        System.out.println(request);

        try {
            Connection conn = DBConnector.DBconnect.connect();
            PreparedStatement statement = conn.prepareStatement(request);
            ResultSet result = statement.executeQuery();

            while (result.next()) {
                //tableResult.getItems().add(result);
            }
            conn.close();

        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }
    }

    private String getSqlInnerJoin() {
        String innerTest = "";
        for (int i = 0; i < tables.size(); i++) {
            innerTest = innerTest+tables.get(i);
        }

        if (innerTest.matches("USERBILL")) {
            return "USER INNER JOIN BILL ON USER.idUser = BILL.idUser";
        }
        if (innerTest.matches("USERBILLDELIVERY")) {
            return "USER INNER JOIN BILL ON USER.idUser = BILL.idUser INNER JOIN DELIVERY ON BILL.idBill = DELIVERY.idBill";
        }
        if (innerTest.matches("USERBILLDELIVERYPROVIDER")) {
            return "USER INNER JOIN BILL ON USER.idUser = BILL.idUser INNER JOIN DELIVERY ON BILL.idBill = DELIVERY.idBill" +
                    " INNER JOIN PROVIDER ON DELIVERY.idProvider = PROVIDER.idProvider";
        }
        if (innerTest.matches("USERBILLDELIVERYPROVIDERSERVICE")) {
            return "USER INNER JOIN BILL ON USER.idUser = BILL.idUser INNER JOIN DELIVERY ON BILL.idBill = DELIVERY.idBill" +
                    " INNER JOIN PROVIDER ON DELIVERY.idProvider = PROVIDER.idProvider INNER JOIN SERVICE ON DELIVERY.idService = SERVICE.idService";
        }
        if (innerTest.matches("BILLDELIVERY")) {
            return "BILL INNER JOIN DELIVERY ON BILL.idBill = DELIVERY.idBill";
        }
        if (innerTest.matches("BILLDELIVERYPROVIDER")) {
            return "BILL INNER JOIN DELIVERY ON BILL.idBill = DELIVERY.idBill INNER JOIN PROVIDER ON DELIVERY.idProvider = PROVIDER.idProvider";
        }
        if (innerTest.matches("BILLDELIVERYPROVIDERSERVICE")) {
            return "BILL INNER JOIN DELIVERY ON BILL.idBill = DELIVERY.idBill INNER JOIN PROVIDER ON DELIVERY.idProvider = PROVIDER.idProvider" +
                    " INNER JOIN SERVICE ON DELIVERY.idService = SERVICE.idService";
        }
        if (innerTest.matches("DELIVERYPROVIDER")) {
            return "DELIVERY INNER JOIN PROVIDER ON DELIVERY.idProvider = PROVIDER.idProvider";
        }
        if (innerTest.matches("DELIVERYPROVIDERSERVICE")) {
            return "DELIVERY INNER JOIN PROVIDER ON DELIVERY.idProvider = PROVIDER.idProvider INNER JOIN SERVICE ON DELIVERY.idService = SERVICE.idService";
        }
        if (innerTest.matches("DELIVERYSERVICE")) {
            return "DELIVERY INNER JOIN SERVICE ON DELIVERY.idService = SERVICE.idService";
        }
        return tables.get(0);
    }

    private String getSqlWhere() {
        if (where.size() == 0) return "";
        else {
            String whereString = " WHERE " + where.get(0);
            for (int i = 1; i < where.size(); i++) {
                whereString = whereString + " && " + where.get(i);
            }
            return whereString;
        }
    }
}
