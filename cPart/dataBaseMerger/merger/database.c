//
// Created by hhk on 11/03/2020.
//
#include "database.h"

void finish_with_err(MYSQL *conn){

    fprintf(stderr, "%s\n", mysql_error(conn));
    mysql_close(conn);
    exit(1);

}

int db_connect(MYSQL *conn){

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

    return 1;

}

void closeConnection(MYSQL *conn) {
    printf("Fermeture de la connexion...\n");
    mysql_close(conn);
}

void selectNextLine(char line[], FILE *ptr) {

    fgets(line,795,ptr);

}

int alreadyExist(MYSQL *conn, char guid[]) {

    char query[150];

    sprintf(query, "SELECT companyName FROM PROVIDER WHERE providerGuid = '%s'", guid);

    if(mysql_query(conn, query)) finish_with_err(conn);
    MYSQL_RES *result = mysql_store_result(conn);

    if (result->row_count >= 1) return 1;
    else return 0;

}

void insertProvider(MYSQL *conn, char line[]) {

    MYSQL_ROW row;
    char insertIntoProvider[1000];

    char companyName[50];
    char providerFirstName[50];
    char providerLastName[50];
    char providerBirth[10];
    char providerEmail[50];
    char providerPhone[15];
    char providerAddress[100];
    int idCity;
    char providerGuid[37];
    int size; //taille de la chaine
    int start = 3; //emplacement de départ
    size = strchr(line+start,',') - line-start;
    strncpy(companyName, line+start, size);

    start += size+1;
    size = strchr(line+start,',') - line-start;
    strncpy(providerFirstName, line+start, size);

    printf("%s", providerFirstName);

    /*sprintf(insertIntoProvider,
            "INSERT INTO PROVIDER (companyName, providerFirstName, providerLastName, providerBirth, providerEmail, providerPhone, providerAddress, idCity, providerGuid) "
            "VALUES ('%s')", line+3);

    if(mysql_query(conn, insertIntoProvider))
        finish_with_err(conn);

    printf("%s", insertIntoProvider);*/

}