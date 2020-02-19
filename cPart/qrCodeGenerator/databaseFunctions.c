//
// Created by hhk on 19/02/2020.
//

#include "databaseFunctions.h"

void finish_with_err(MYSQL *conn){

    fprintf(stderr, "%s\n", mysql_error(conn));
    mysql_close(conn);
    exit(1);

}

void db_connect(MYSQL *conn){

    char dbname[250] = "bringmeC" ;
    char host[250] = "localhost";
    char user[250] = "admin";
    char pass[250] = "test123";
    unsigned int port = 3306;


    if (conn == NULL) {
        finish_with_err(conn);
    }

    if(mysql_real_connect(conn, host, user, pass, dbname, port, NULL, 0) == NULL) {
        finish_with_err(conn);
    }

    printf("MySQL client version: %s\n", mysql_get_client_info());
    printf("Successfully connected to %s !\n", dbname);
    printf("Welcome %s !\n", user);

}

void closeConnection(MYSQL *conn) {
    printf("Fermeture de la connexion...\n");
    mysql_close(conn);
}



