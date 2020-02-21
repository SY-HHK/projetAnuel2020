//
// Created by hhk on 19/02/2020.
//

#include "databaseFunctions.h"

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

    printf("testdebut");
    //provider insert;

    const gchar *companyName = companyName = gtk_entry_get_text(GTK_ENTRY(pEntry.companyName));
    const gchar *providerFirstName = gtk_entry_get_text(GTK_ENTRY(pEntry.providerFirstName));
    const gchar *providerLastName = gtk_entry_get_text(GTK_ENTRY(pEntry.providerLastName));
    const gchar *providerBirth = gtk_entry_get_text(GTK_ENTRY(pEntry.providerBirth));
    const gchar *providerEmail = gtk_entry_get_text(GTK_ENTRY(pEntry.providerEmail));
    const gchar *providerPhone = gtk_entry_get_text(GTK_ENTRY(pEntry.providerPhone));
    const gchar *cityRegion = gtk_entry_get_text(GTK_ENTRY(pEntry.cityRegion));
    const gchar *cityDepartment = gtk_entry_get_text(GTK_ENTRY(pEntry.cityDepartement));
    const gchar *cityName = gtk_entry_get_text(GTK_ENTRY(pEntry.cityName));
    const gchar *providerAddress = gtk_entry_get_text(GTK_ENTRY(pEntry.providerAddress));

    if(mysql_query(conn, "INSERT INTO PROVIDER (companyName) VALUES ('companyTest')"))
        finish_with_err(conn);

    printf("testfin");

}



