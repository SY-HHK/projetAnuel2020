package sample;


import java.sql.*;


public class DBconnect {
    private Connection connection;
    private Statement statement;
    private ResultSet resultSet;
    private String url, name, pwd, erreur,dma;
    private ResultSetMetaData rsmd;
    private String all = "all";


    public DBconnect() {
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
    }


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

    public void setUrl(String url) {
        this.url = url;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getPwd() {
        return pwd;
    }

    public void setPwd(String pwd) {
        this.pwd = pwd;
    }

    public String getErreur() {
        return erreur;
    }

    public void setErreur(String erreur) {
        this.erreur = erreur;
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