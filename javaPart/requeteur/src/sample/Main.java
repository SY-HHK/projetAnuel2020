package sample;

import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.stage.Stage;

public class Main extends Application {

    @Override
    public void start(Stage primaryStage) throws Exception{
        Parent root = FXMLLoader.load(getClass().getResource("test.fxml"));
        primaryStage.setTitle("Requêteur de base de données");
        primaryStage.setScene(new Scene(root, 900, 705));
        primaryStage.show();
    }


    public static void main(String[] args) {
        launch(args);

      /*  private static void show(){
            FXMLLoader loader = new FXMLLoader();
            loader.setLocation(Main.class.getResource("sample.fxml"));
        }*/








    }
}
