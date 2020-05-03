module requeteur {
    requires javafx.fxml;
    requires java.sql;
    requires scenebuilder;
    requires javafx.controls;
    opens application;
    opens controllers;
    opens DBConnector;
    opens model;
    opens vue;
}