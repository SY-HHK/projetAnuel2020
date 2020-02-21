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

void insertProvider(GtkButton *widget, struct providerEntry *pEntry) {

    printf("testdebut");
    //provider insert;

    const gchar *providerFirstName;
    providerFirstName = gtk_entry_get_text(GTK_ENTRY(pEntry->providerFirstName));

    /*strcpy(insert.companyName,companyName);
    strcpy(insert.providerFirstName,gtk_entry_get_text(GTK_ENTRY(p->providerFirstName)));
    strcpy(insert.providerLastName,gtk_entry_get_text(GTK_ENTRY(p->providerLastName)));
    strcpy(insert.providerBirth,gtk_entry_get_text(GTK_ENTRY(p->providerBirth)));
    strcpy(insert.providerEmail,gtk_entry_get_text(GTK_ENTRY(p->providerEmail)));
    strcpy(insert.providerPhone,gtk_entry_get_text(GTK_ENTRY(p->providerPhone)));
    strcpy(insert.cityRegion,gtk_entry_get_text(GTK_ENTRY(p->cityRegion)));
    strcpy(insert.cityDepartement,gtk_entry_get_text(GTK_ENTRY(p->cityDepartement)));
    strcpy(insert.cityName,gtk_entry_get_text(GTK_ENTRY(p->cityName)));
    strcpy(insert.providerAddress,gtk_entry_get_text(GTK_ENTRY(p->providerAddress)));

    mysql_query(conn, "INSERT INTO PROVIDER (companyName) VALUES ('companyTest')");*/

    printf("testfin");

}



