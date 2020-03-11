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

    if (mysql_num_rows(result) >= 1) return 1;
    else return 0;

}

void insertProvider(MYSQL *conn, char line) {

    MYSQL_ROW row;

    sprintf(selectCity, "SELECT idCity FROM CITY WHERE cityName = '%s'",insert.cityName);

    if(mysql_query(conn, selectCity))
        finish_with_err(conn);
    MYSQL_RES *result = mysql_store_result(conn);

    if (result == NULL)
    {
        finish_with_err(conn);
    }

    if (result->row_count == 0) {

        sprintf(insertIntoCity,
                "INSERT INTO CITY (cityName, cityRegion, cityDepartment) VALUES ('%s', '%s', '%s')",
                insert.cityName,
                insert.cityRegion,
                insert.cityDepartement);

        if(mysql_query(conn, insertIntoCity))
            finish_with_err(conn);


        if(mysql_query(conn, selectCity))
            finish_with_err(conn);
        MYSQL_RES *result = mysql_store_result(conn);

        row = mysql_fetch_row(result);
        sscanf(row[0],"%d",&idCity);

    }

    else {
        row = mysql_fetch_row(result);
        sscanf(row[0],"%d",&idCity);
    }

    mysql_free_result(result);

    uuid_t uuid;
    // generate
    uuid_generate_time_safe(uuid);
    // unparse (to string)
    char uuid_str[37];      // ex. "1b4e28ba-2fa1-11d2-883f-0016d3cca427" + "\0"
    uuid_unparse_lower(uuid, uuid_str);

    sprintf(insertIntoProvider,
            "INSERT INTO PROVIDER (companyName, providerFirstName, providerLastName, providerBirth, providerEmail, providerPhone, providerAddress, idCity, providerGuid) "
            "VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', %d, '%s')",
            insert.companyName,
            insert.providerFirstName,
            insert.providerLastName,
            insert.providerBirth,
            insert.providerEmail,
            insert.providerPhone,
            insert.providerAddress,
            idCity,
            uuid_str);

    if(mysql_query(conn, insertIntoProvider))
        finish_with_err(conn);


    sprintf(selectProvider, "SELECT idProvider FROM PROVIDER WHERE companyName = '%s'",insert.companyName);

    if(mysql_query(conn, selectProvider))
        finish_with_err(conn);
    result = mysql_store_result(conn);

    row = mysql_fetch_row(result);
    sscanf(row[0],"%d",&idProvider);

}