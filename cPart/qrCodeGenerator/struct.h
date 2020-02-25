//
// Created by hhk on 19/02/2020.
//

#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include <mysql/mysql.h>
#include <gtk-3.0/gtk/gtk.h>

MYSQL *conn;

struct providerEntry{
    GtkWidget *providerFirstName;
    GtkWidget *providerLastName;
    GtkWidget *providerBirthDay;
    GtkWidget *providerBirthMonth;
    GtkWidget *providerBirthYear;
    GtkWidget *providerPhone;
    GtkWidget *providerEmail;
    GtkWidget *providerAddress;
    GtkWidget *companyName;
    GtkWidget *cityName;
    GtkWidget *cityRegion;
    GtkWidget *cityDepartement;
    GtkWidget *qrCode;
    int *argc;
    char **argv;
};
struct providerEntry pEntry;

typedef struct provider{
    char providerFirstName[50];
    char providerLastName[50];
    char providerBirth[50];
    char providerPhone[30];
    char providerEmail[50];
    char providerAddress[150];
    char companyName[100];
    char cityName[50];
    char cityRegion[50];
    char cityDepartement[50];
} provider;
