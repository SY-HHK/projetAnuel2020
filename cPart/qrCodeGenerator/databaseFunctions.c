//
// Created by hhk on 19/02/2020.
//

#include "databaseFunctions.h"
#include "graphicFunctions.h"

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

void insertProvider(GtkButton *widget) {

    provider insert;

    strcpy(insert.companyName, toLowerCase(gtk_entry_get_text(GTK_ENTRY(pEntry.companyName))));
    strcpy(insert.providerFirstName, toLowerCase(gtk_entry_get_text(GTK_ENTRY(pEntry.providerFirstName))));
    strcpy(insert.providerLastName, toLowerCase(gtk_entry_get_text(GTK_ENTRY(pEntry.providerLastName))));
    sprintf(insert.providerBirth,"%s/%s/%s",
            gtk_entry_get_text(GTK_ENTRY(pEntry.providerBirthYear)),
            gtk_entry_get_text(GTK_ENTRY(pEntry.providerBirthMonth)),
            gtk_entry_get_text(GTK_ENTRY(pEntry.providerBirthDay)));
    strcpy(insert.providerEmail, toLowerCase(gtk_entry_get_text(GTK_ENTRY(pEntry.providerEmail))));
    strcpy(insert.providerPhone, gtk_entry_get_text(GTK_ENTRY(pEntry.providerPhone)));
    strcpy(insert.cityRegion, toLowerCase(gtk_entry_get_text(GTK_ENTRY(pEntry.cityRegion))));
    strcpy(insert.cityDepartement, gtk_entry_get_text(GTK_ENTRY(pEntry.cityDepartement)));
    strcpy(insert.cityName, toLowerCase(gtk_entry_get_text(GTK_ENTRY(pEntry.cityName))));
    strcpy(insert.providerAddress, toLowerCase(gtk_entry_get_text(GTK_ENTRY(pEntry.providerAddress))));

    char insertIntoProvider[500];
    char insertIntoCity[150];
    char selectCity[100];
    char selectProvider[100];
    int idCity;
    int idProvider;
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

    sprintf(insertIntoProvider,
            "INSERT INTO PROVIDER (companyName, providerFirstName, providerLastName, providerBirth, providerEmail, providerPhone, providerAddress, idCity) "
            "VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', %d)",
            insert.companyName,
            insert.providerFirstName,
            insert.providerLastName,
            insert.providerBirth,
            insert.providerEmail,
            insert.providerPhone,
            insert.providerAddress,
            idCity);

    if(mysql_query(conn, insertIntoProvider))
        finish_with_err(conn);


    sprintf(selectProvider, "SELECT idProvider FROM PROVIDER WHERE companyName = '%s'",insert.companyName);

    if(mysql_query(conn, selectProvider))
        finish_with_err(conn);
    result = mysql_store_result(conn);

    row = mysql_fetch_row(result);
    sscanf(row[0],"%d",&idProvider);

    gtk_widget_show_all(confirmationWindow(&pEntry.argc, &pEntry.argv));

    generateQrCode(insert.companyName[0], insert.providerFirstName[0], insert.providerLastName[0], idProvider);

}

const char *toLowerCase(char *str) {

    int i;
    for (i = 0; str[i] != '\0'; i++) {
        if (str[i] >= 'A' && str[i] <= 'Z') {
            str[i] = str[i] + 32;
        }
    }
    return str;

}

void deleteProvider(GtkWidget *window) {

    if(mysql_query(conn, "DELETE FROM PROVIDER ORDER BY idProvider DESC LIMIT 1 "))
        finish_with_err(conn);
    gtk_window_close(window);

}





