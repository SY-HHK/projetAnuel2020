module requeteur {
    requires javafx.fxml;

    requires java.sql;
    requires scenebuilder;
    requires javafx.controls;
    opens sample;
    opens controllers;
    opens vue;
    opens DBConnector;
    opens application;
    opens model;





}