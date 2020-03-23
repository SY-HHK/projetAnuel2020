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
    printf("Fermeture de la connexion.\n");
    mysql_close(conn);
}

void selectNextLine(char line[], FILE *ptr) {

    fgets(line,795,ptr);

}

int alreadyExist(MYSQL *conn, char column[], char table[], char condition[], char answer[]) {

    char query[150];

    sprintf(query, "SELECT %s FROM %s WHERE %s = '%s'", column, table, condition, answer);

    if(mysql_query(conn, query)) finish_with_err(conn);
    MYSQL_RES *result = mysql_store_result(conn);

    if (result->row_count >= 1) return 1;
    else return 0;

}

void insertProvider(MYSQL *conn, char line[]) {

    char insertIntoProvider[1000];
    char companyName[50];
    char providerFirstName[50];
    char providerLastName[50];
    char providerBirth[15];
    char providerEmail[50];
    char providerPhone[15];
    char providerAddress[100];
    char cityName[50];
    char cityDepartment[5];
    char cityRegion[50];
    char providerGuid[37];
    int size; //taille de la chaine
    int start = 0; //emplacement de départ
    size = strchr(line+start,',') - line-start;
    strncpy(companyName, line+start, size);
    companyName[size] = '\0';
    //Prenom
    start += size+1;
    size = strchr(line+start,',') - line-start;
    strncpy(providerFirstName, line+start, size);
    providerFirstName[size] = '\0';
    //Nom
    start += size+1;
    size = strchr(line+start,',') - line-start;
    strncpy(providerLastName, line+start, size);
    providerLastName[size] = '\0';
    //Date de naissance
    start += size+1;
    size = strchr(line+start,',') - line-start;
    strncpy(providerBirth, line+start, size);
    providerBirth[size] = '\0';
    //Email
    start += size+1;
    size = strchr(line+start,',') - line-start;
    strncpy(providerEmail, line+start, size);
    providerEmail[size] = '\0';
    //Téléphone
    start += size+1;
    size = strchr(line+start,',') - line-start;
    strncpy(providerPhone, line+start, size);
    providerPhone[size] = '\0';
    //Adresse
    start += size+1;
    size = strchr(line+start,',') - line-start;
    strncpy(providerAddress, line+start, size);
    providerAddress[size] = '\0';
    //Ville
    start += size+1;
    size = strchr(line+start,',') - line-start;
    strncpy(cityName, line+start, size);
    cityName[size] = '\0';
    //Departement
    start += size+1;
    size = strchr(line+start,',') - line-start;
    strncpy(cityDepartment, line+start, size);
    cityDepartment[size] = '\0';
    //Region
    start += size+1;
    size = strchr(line+start,',') - line-start;
    strncpy(cityRegion, line+start, size);
    cityRegion[size] = '\0';
    //Guid
    start += size+1;
    strcpy(providerGuid, line+start);
    providerGuid[36] = '\0';

    //création de la ville si elle existe pas
    if (!alreadyExist(conn, "cityName", "CITY", "cityName", cityName)) {
        sprintf(insertIntoProvider, "INSERT INTO CITY (cityName, cityDepartment, cityRegion) "
                                    "VALUES ('%s', %s, '%s')",cityName, cityDepartment, cityRegion);
        if (mysql_query(conn, insertIntoProvider)) {
            finish_with_err(conn);
        }
    }

    //recuperation de l'id de la ville
    sprintf(insertIntoProvider, "SELECT idCity FROM CITY WHERE cityName = '%s'", cityName);
    if (mysql_query(conn, insertIntoProvider)) {
        finish_with_err(conn);
    }

    MYSQL_RES *result = mysql_store_result(conn);
    MYSQL_ROW row = mysql_fetch_row(result);
    int idCity;
    sscanf(row[0],"%d",&idCity);

    printf("%d", idCity);

    sprintf(insertIntoProvider,
            "INSERT INTO PROVIDER (companyName, providerFirstName, providerLastName, providerBirth, providerEmail, providerPhone, providerAddress, idCity, providerGuid) "
            "VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', %d, '%s')",
            companyName,
            providerFirstName,
            providerLastName,
            providerBirth,
            providerEmail,
            providerPhone,
            providerAddress,
            idCity,
            providerGuid);

    if(mysql_query(conn, insertIntoProvider)) {
        finish_with_err(conn);
    }

}