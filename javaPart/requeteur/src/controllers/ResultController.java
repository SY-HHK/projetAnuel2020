package controllers;

import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.cell.PropertyValueFactory;
import model.*;

import java.lang.reflect.Array;
import java.lang.reflect.Field;
import java.net.URL;
import java.sql.*;
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

        String request = "SELECT * FROM " + getSqlInnerJoin() + getSqlWhere();
        //System.out.println(request);

        String[] attributList = getAttributList();
        for (int i = 0; i < attributList.length; i++) {
            TableColumn col = new TableColumn(attributList[i]);
            col.setCellValueFactory(new PropertyValueFactory<>(attributList[i]));
            tableResult.getColumns().add(col);
        }

        fetchInfos(request);

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

    private void fetchInfos(String request) {
        try {
            Connection conn = DBConnector.DBconnect.connect();
            PreparedStatement statement = conn.prepareStatement(request);
            ResultSet result = statement.executeQuery();

            while (result.next()) {
                if (getModel().matches("USERBILL")) {
                    try {
                        tableResult.getItems().add(new UserBill(
                                result.getString("userFirstName"),
                                result.getString("userLastName"),
                                result.getString("userEmail"),
                                result.getString("userPhone"),
                                result.getString("userAddress"),
                                result.getInt("BILL.idBill"),
                                result.getString("billDate"),
                                result.getString("billDescription"),
                                result.getFloat("billPrice"),
                                result.getInt("billState"),
                                result.getString("billStripeId")));
                    } catch (SQLException throwables) {
                        throwables.printStackTrace();
                    }
                }
                if (getModel().matches("USERBILLDELIVERY")) {
                    try {
                        tableResult.getItems().add(new UserBillDelivery(
                                result.getString("userFirstName"),
                                result.getString("userLastName"),
                                result.getString("userEmail"),
                                result.getString("userPhone"),
                                result.getString("userAddress"),
                                result.getInt("BILL.idBill"),
                                result.getString("billDate"),
                                result.getString("billDescription"),
                                result.getFloat("billPrice"),
                                result.getInt("billState"),
                                result.getString("billStripeId"),
                                result.getInt("DELIVERY.idDelivery"),
                                result.getInt("DELIVERY.idService"),
                                result.getInt("DELIVERY.idProvider"),
                                result.getString("deliveryHourStart"),
                                result.getString("deliveryHourEnd"),
                                result.getInt("deliveryState"),
                                result.getInt("deliveryRate")));
                    } catch (SQLException throwables) {
                        throwables.printStackTrace();
                    }
                }
                if (getModel().matches("USERBILLDELIVERYPROVIDER")) {
                    try {
                        tableResult.getItems().add(new UserBillDeliveryProvider(
                                result.getString("userFirstName"),
                                result.getString("userLastName"),
                                result.getString("userEmail"),
                                result.getString("userPhone"),
                                result.getString("userAddress"),
                                result.getInt("BILL.idBill"),
                                result.getString("billDate"),
                                result.getString("billDescription"),
                                result.getFloat("billPrice"),
                                result.getInt("billState"),
                                result.getString("billStripeId"),
                                result.getInt("DELIVERY.idDelivery"),
                                result.getInt("DELIVERY.idService"),
                                result.getInt("DELIVERY.idProvider"),
                                result.getString("deliveryHourStart"),
                                result.getString("deliveryHourEnd"),
                                result.getInt("deliveryState"),
                                result.getInt("deliveryRate"),
                                result.getString("providerFirstName"),
                                result.getString("providerLastName"),
                                result.getString("providerEmail"),
                                result.getString("companyName"),
                                result.getString("providerAddress")));
                    } catch (SQLException throwables) {
                        throwables.printStackTrace();
                    }
                }
                if (getModel().matches("USERBILLDELIVERYSERVICE")) {
                    try {
                        tableResult.getItems().add(new UserBillDeliveryService(
                                result.getString("userFirstName"),
                                result.getString("userLastName"),
                                result.getString("userEmail"),
                                result.getString("userPhone"),
                                result.getString("userAddress"),
                                result.getInt("BILL.idBill"),
                                result.getString("billDate"),
                                result.getString("billDescription"),
                                result.getFloat("billPrice"),
                                result.getInt("billState"),
                                result.getString("billStripeId"),
                                result.getInt("DELIVERY.idDelivery"),
                                result.getInt("DELIVERY.idService"),
                                result.getInt("DELIVERY.idProvider"),
                                result.getString("deliveryHourStart"),
                                result.getString("deliveryHourEnd"),
                                result.getInt("deliveryState"),
                                result.getInt("deliveryRate"),
                                result.getString("serviceTitle"),
                                result.getFloat("servicePrice"),
                                result.getString("serviceDescription")));
                    } catch (SQLException throwables) {
                        throwables.printStackTrace();
                    }
                }
                if (getModel().matches("USERBILLDELIVERYPROVIDERSERVICE")) {
                    try {
                        tableResult.getItems().add(new UserBillDeliveryProviderService(
                                result.getString("userFirstName"),
                                result.getString("userLastName"),
                                result.getString("userEmail"),
                                result.getString("userPhone"),
                                result.getString("userAddress"),
                                result.getInt("BILL.idBill"),
                                result.getString("billDate"),
                                result.getString("billDescription"),
                                result.getFloat("billPrice"),
                                result.getInt("billState"),
                                result.getString("billStripeId"),
                                result.getInt("DELIVERY.idDelivery"),
                                result.getInt("DELIVERY.idService"),
                                result.getInt("DELIVERY.idProvider"),
                                result.getString("deliveryHourStart"),
                                result.getString("deliveryHourEnd"),
                                result.getInt("deliveryState"),
                                result.getInt("deliveryRate"),
                                result.getString("providerFirstName"),
                                result.getString("providerLastName"),
                                result.getString("providerEmail"),
                                result.getString("companyName"),
                                result.getString("providerAddress"),
                                result.getString("serviceTitle"),
                                result.getFloat("servicePrice"),
                                result.getString("serviceDescription")));
                    } catch (SQLException throwables) {
                        throwables.printStackTrace();
                    }
                }
                if (getModel().matches("BILLDELIVERY")) {
                    try {
                        tableResult.getItems().add(new BillDelivery(
                                result.getInt("BILL.idBill"),
                                result.getString("billDate"),
                                result.getString("billDescription"),
                                result.getFloat("billPrice"),
                                result.getInt("billState"),
                                result.getString("billStripeId"),
                                result.getInt("DELIVERY.idDelivery"),
                                result.getInt("DELIVERY.idService"),
                                result.getInt("DELIVERY.idProvider"),
                                result.getString("deliveryHourStart"),
                                result.getString("deliveryHourEnd"),
                                result.getInt("deliveryState"),
                                result.getInt("deliveryRate")));
                    } catch (SQLException throwables) {
                        throwables.printStackTrace();
                    }
                }
                if (getModel().matches("BILLDELIVERYPROVIDER")) {
                    try {
                        tableResult.getItems().add(new BillDeliveryProvider(
                                result.getInt("BILL.idBill"),
                                result.getString("billDate"),
                                result.getString("billDescription"),
                                result.getFloat("billPrice"),
                                result.getInt("billState"),
                                result.getString("billStripeId"),
                                result.getInt("DELIVERY.idDelivery"),
                                result.getInt("DELIVERY.idService"),
                                result.getInt("DELIVERY.idProvider"),
                                result.getString("deliveryHourStart"),
                                result.getString("deliveryHourEnd"),
                                result.getInt("deliveryState"),
                                result.getInt("deliveryRate"),
                                result.getString("providerFirstName"),
                                result.getString("providerLastName"),
                                result.getString("providerEmail"),
                                result.getString("companyName"),
                                result.getString("providerAddress")));
                    } catch (SQLException throwables) {
                        throwables.printStackTrace();
                    }
                }
                if (getModel().matches("BILLDELIVERYPROVIDERSERVICE")) {
                    try {
                        tableResult.getItems().add(new BillDeliveryProviderService(
                                result.getInt("BILL.idBill"),
                                result.getString("billDate"),
                                result.getString("billDescription"),
                                result.getFloat("billPrice"),
                                result.getInt("billState"),
                                result.getString("billStripeId"),
                                result.getInt("DELIVERY.idDelivery"),
                                result.getInt("DELIVERY.idService"),
                                result.getInt("DELIVERY.idProvider"),
                                result.getString("deliveryHourStart"),
                                result.getString("deliveryHourEnd"),
                                result.getInt("deliveryState"),
                                result.getInt("deliveryRate"),
                                result.getString("providerFirstName"),
                                result.getString("providerLastName"),
                                result.getString("providerEmail"),
                                result.getString("companyName"),
                                result.getString("providerAddress"),
                                result.getString("serviceTitle"),
                                result.getFloat("servicePrice"),
                                result.getString("serviceDescription")));
                    } catch (SQLException throwables) {
                        throwables.printStackTrace();
                    }
                }
                if (getModel().matches("BILLDELIVERYSERVICE")) {
                    try {
                        tableResult.getItems().add(new BillDeliveryService(
                                result.getInt("BILL.idBill"),
                                result.getString("billDate"),
                                result.getString("billDescription"),
                                result.getFloat("billPrice"),
                                result.getInt("billState"),
                                result.getString("billStripeId"),
                                result.getInt("DELIVERY.idDelivery"),
                                result.getInt("DELIVERY.idService"),
                                result.getInt("DELIVERY.idProvider"),
                                result.getString("deliveryHourStart"),
                                result.getString("deliveryHourEnd"),
                                result.getInt("deliveryState"),
                                result.getInt("deliveryRate"),
                                result.getString("serviceTitle"),
                                result.getFloat("servicePrice"),
                                result.getString("serviceDescription")));
                    } catch (SQLException throwables) {
                        throwables.printStackTrace();
                    }
                }
                if (getModel().matches("DELIVERYPROVIDER")) {
                    try {
                        tableResult.getItems().add(new DeliveryProvider(
                                result.getInt("DELIVERY.idDelivery"),
                                result.getInt("DELIVERY.idBill"),
                                result.getInt("DELIVERY.idService"),
                                result.getInt("DELIVERY.idProvider"),
                                result.getString("deliveryHourStart"),
                                result.getString("deliveryHourEnd"),
                                result.getInt("deliveryState"),
                                result.getInt("deliveryRate"),
                                result.getString("providerFirstName"),
                                result.getString("providerLastName"),
                                result.getString("providerEmail"),
                                result.getString("companyName"),
                                result.getString("providerAddress")));
                    } catch (SQLException throwables) {
                        throwables.printStackTrace();
                    }
                }
                if (getModel().matches("DELIVERYSERVICE")) {
                    try {
                        tableResult.getItems().add(new DeliveryService(
                                result.getInt("DELIVERY.idDelivery"),
                                result.getInt("DELIVERY.idBill"),
                                result.getInt("DELIVERY.idService"),
                                result.getInt("DELIVERY.idProvider"),
                                result.getString("deliveryHourStart"),
                                result.getString("deliveryHourEnd"),
                                result.getInt("deliveryState"),
                                result.getInt("deliveryRate"),
                                result.getString("serviceTitle"),
                                result.getFloat("servicePrice"),
                                result.getString("serviceDescription")));
                    } catch (SQLException throwables) {
                        throwables.printStackTrace();
                    }
                }
                if (getModel().matches("DELIVERYPROVIDERSERVICE")) {
                    try {
                        tableResult.getItems().add(new DeliveryProviderService(
                                result.getInt("DELIVERY.idDelivery"),
                                result.getInt("DELIVERY.idBill"),
                                result.getInt("DELIVERY.idService"),
                                result.getInt("DELIVERY.idProvider"),
                                result.getString("deliveryHourStart"),
                                result.getString("deliveryHourEnd"),
                                result.getInt("deliveryState"),
                                result.getInt("deliveryRate"),
                                result.getString("providerFirstName"),
                                result.getString("providerLastName"),
                                result.getString("providerEmail"),
                                result.getString("companyName"),
                                result.getString("providerAddress"),
                                result.getString("serviceTitle"),
                                result.getFloat("servicePrice"),
                                result.getString("serviceDescription")));
                    } catch (SQLException throwables) {
                        throwables.printStackTrace();
                    }
                }
                if (getModel().matches("DELIVERY")) {
                    try {
                        tableResult.getItems().add(new Delivery(
                                result.getInt("DELIVERY.idDelivery"),
                                result.getInt("DELIVERY.idBill"),
                                result.getInt("DELIVERY.idService"),
                                result.getInt("DELIVERY.idProvider"),
                                result.getString("deliveryHourStart"),
                                result.getString("deliveryHourEnd"),
                                result.getInt("deliveryState"),
                                result.getInt("deliveryRate")));
                    } catch (SQLException throwables) {
                        throwables.printStackTrace();
                    }
                }
                if (getModel().matches("BILL")) {
                    try {
                        tableResult.getItems().add(new Bill(
                                result.getInt("BILL.idBill"),
                                result.getString("billDate"),
                                result.getString("billDescription"),
                                result.getFloat("billPrice"),
                                result.getInt("billState"),
                                result.getString("billStripeId")));
                    } catch (SQLException throwables) {
                        throwables.printStackTrace();
                    }
                }
            }

            conn.close();

        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }
    }

    private String getModel() {
        String tablesString ="";
        for (int i = 0; i < tables.size(); i++) {
            tablesString = tablesString + tables.get(i);
        }
        return tablesString;
    }

    private String[] getAttributList() {
        if (getModel().matches("USERBILL")) {
            return UserBill.getAllVariable();
        }
        if (getModel().matches("USERBILLDELIVERY")) {
            return UserBillDelivery.getAllVariable();
        }
        if (getModel().matches("USERBILLDELIVERYPROVIDER")) {
            return UserBillDeliveryProvider.getAllVariable();
        }
        if (getModel().matches("USERBILLDELIVERYSERVICE")) {
            return UserBillDeliveryService.getAllVariable();
        }
        if (getModel().matches("USERBILLDELIVERYPROVIDERSERVICE")) {
            return UserBillDeliveryProviderService.getAllVariable();
        }
        if (getModel().matches("BILLDELIVERY")) {
            return BillDelivery.getAllVariable();
        }
        if (getModel().matches("BILLDELIVERYPROVIDER")) {
            return BillDeliveryProvider.getAllVariable();
        }
        if (getModel().matches("BILLDELIVERYPROVIDERSERVICE")) {
            return BillDeliveryProviderService.getAllVariable();
        }
        if (getModel().matches("BILLDELIVERYSERVICE")) {
            return BillDeliveryService.getAllVariable();
        }
        if (getModel().matches("DELIVERYPROVIDER")) {
            return DeliveryProvider.getAllVariable();
        }
        if (getModel().matches("DELIVERYSERVICE")) {
            return DeliveryService.getAllVariable();
        }
        if (getModel().matches("DELIVERYPROVIDERSERVICE")) {
            return DeliveryProviderService.getAllVariable();
        }
        if (getModel().matches("DELIVERY")) {
            return Delivery.getAllVariable();
        }
        else return Bill.getAllVariable();
    }
}
