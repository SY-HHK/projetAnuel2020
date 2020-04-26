package DBConnector;


import java.sql.*;


public class DBconnect {
    private Connection connection;
    private Statement statement;
    private ResultSet resultSet;
    private static final String url = "jdbc:mysql://localhost:3306/bringme?useUnicode=true&useJDBCCompliantTimezoneShift=true&useLegacyDatetimeCode=false&serverTimezone=UTC";
    private static final String name = "admin";
    private static final String pwd = "test123";


    private String dma;
    private ResultSetMetaData rsmd;
    private String all = "all";

    public static Connection connect() throws SQLException{
        try {
                Class.forName("com.mysql.cj.jdbc.Driver");
                Connection conn = DriverManager.getConnection(url, name, pwd);
                return conn;

        } catch (ClassNotFoundException | SQLException e) {
            System.out.println("Error:" + e);
        }
        return null;
    }



 /*   public DBconnect() {
            try {

                url = "jdbc:mysql://localhost:3306/bringme?useUnicode=true&useJDBCCompliantTimezoneShift=true&useLegacyDatetimeCode=false&serverTimezone=UTC";
                name = "admin";
                pwd = "test123";

                try {
                    Class.forName("com.mysql.cj.jdbc.Driver");
                } catch (ClassNotFoundException e) {
                    erreur = "driver";
                }

                connection = DriverManager.getConnection(url, name, pwd);
                statement = connection.createStatement();


            } catch (Exception e) {
                System.out.println("Error:" + e);
            }
    }*/




    public Connection getConnection() {
        return connection;
    }

    public void setConnection(Connection connection) {
        this.connection = connection;
    }

    public void setStatement(Statement statement) {
        this.statement = statement;
    }

    public String getUrl() {
        return url;
    }


    public String getName() {
        return name;
    }

    public String getPwd() {
        return pwd;
    }



    public String getDma() {
        return dma;
    }

    public void setDma(String dma) {
        this.dma = dma;
    }

    public Statement getStatement() {
        return statement;
    }

    public ResultSet getResultSet() {
        return resultSet;
    }

    public void setResultSet(ResultSet resultSet) {
        this.resultSet = resultSet;
    }

    public ResultSetMetaData getRsmd() {
        return rsmd;
    }

    public void setRsmd(ResultSetMetaData rsmd) {
        this.rsmd = rsmd;
    }


    public String getAll() {
        return all;
    }

    public void setAll(String all) {
        this.all = all;
    }
}