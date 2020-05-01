package DBConnector;


import java.sql.*;


public class DBconnect {
    private Connection connection;
    private Statement statement;
    private ResultSet resultSet;
    private static final String url = "jdbc:mysql://localhost:3306/bringme?useUnicode=true&useJDBCCompliantTimezoneShift=true&useLegacyDatetimeCode=false&serverTimezone=UTC";
    private static final String name = "admin";
    private static final String pwd = "test123";



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



    public Connection getConnection() {
        return connection;
    }

    public void setConnection(Connection connection) {
        this.connection = connection;
    }

    public void setStatement(Statement statement) {
        this.statement = statement;
    }


    public String getName() {
        return name;
    }

    public String getPwd() {
        return pwd;
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

}