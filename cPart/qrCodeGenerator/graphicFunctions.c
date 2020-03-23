//
// Created by hhk on 19/02/2020.
//
#include "qrcode.h"
#include "graphicFunctions.h"
#include "databaseFunctions.h"

GtkWidget *mainWindow(int *argc, char ***argv) {

    GtkBuilder *builder = NULL;
    GError *error = NULL;
    gchar *filename = NULL;
    /* Initialisation de la librairie Gtk. */
    gtk_init(argc, argv);

    /* Ouverture du fichier Glade de la fenêtre principale */
    builder = gtk_builder_new();

    /* Création du chemin complet pour accéder au fichier test.glade. */
    /* g_build_filename(); construit le chemin complet en fonction du système */
    /* d'exploitation. ( / pour Linux et \ pour Windows) */
    filename =  g_build_filename ("../mainWindow.glade", NULL);

    /* Chargement du fichier test.glade. */
    gtk_builder_add_from_file (builder, filename, &error);
    g_free (filename);
    if (error)
    {
        gint code = error->code;
        g_printerr("%s\n", error->message);
        g_error_free (error);
        //return code;
    }

    /* Récupération des pointeurs de la fenêtre */
    GtkWidget *window = GTK_WIDGET(gtk_builder_get_object (builder, "mainWindow"));
    pEntry.companyName = GTK_WIDGET(gtk_builder_get_object (builder, "companyNameEntry"));
    GtkWidget *firstNameEntry = GTK_WIDGET(gtk_builder_get_object (builder, "firstNameEntry"));
    pEntry.providerFirstName = firstNameEntry;
    pEntry.providerLastName = GTK_WIDGET(gtk_builder_get_object (builder, "lastNameEntry"));
    pEntry.providerBirthDay = GTK_WIDGET(gtk_builder_get_object (builder, "providerBirthDay"));
    pEntry.providerBirthMonth = GTK_WIDGET(gtk_builder_get_object (builder, "providerBirthMonth"));
    pEntry.providerBirthYear = GTK_WIDGET(gtk_builder_get_object (builder, "providerBirthYear"));
    pEntry.providerEmail = GTK_WIDGET(gtk_builder_get_object (builder, "emailEntry"));
    pEntry.providerPhone = GTK_WIDGET(gtk_builder_get_object (builder, "phoneEntry"));
    pEntry.providerAddress = GTK_WIDGET(gtk_builder_get_object (builder, "addressEntry"));
    pEntry.cityRegion = GTK_WIDGET(gtk_builder_get_object (builder, "regionEntry"));
    pEntry.cityDepartement = GTK_WIDGET(gtk_builder_get_object (builder, "departmentEntry"));
    pEntry.cityName = GTK_WIDGET(gtk_builder_get_object (builder, "cityEntry"));
    GtkWidget *createButton = GTK_WIDGET(gtk_builder_get_object (builder, "createButton"));

    g_signal_connect(G_OBJECT (createButton), "clicked", (GCallback)insertProvider, NULL);

    /* Affichage de la fenêtre principale. */
    return window;

}



void generateQrCode(char guid[], int idProvider) {

    char webIdProvider[105];
    char file[30];

    sprintf(file, "qrCode%d.pgm",idProvider);

    sprintf(webIdProvider, "localhost/projetAnuel2020/webPart/provider.php?id=%s", guid);

    QRCode qrcode;
    uint8_t qrcodeData[qrcode_getBufferSize(6)];
    uint8_t x,y;

    qrcode_initText(&qrcode, qrcodeData, 6, ECC_MEDIUM, webIdProvider);

    for (y = 0; y < qrcode.size; y++) {
        for (x = 0; x < qrcode.size; x++) {
        }
    }

    FILE* pgmimg;
    pgmimg = fopen(file, "wb");

    // Writing Magic Number to the File
    fprintf(pgmimg, "P1\n");

    // Writing Width and Height
    fprintf(pgmimg, "%d %d\n", x*3, y*3);

    for (x = 0; x < qrcode.size; x++) {

        for (y = 0; y < qrcode.size; y++) {

            if (qrcode_getModule(&qrcode, x, y))
                fprintf(pgmimg, "%d%d%d", 1,1,1);
            else
                fprintf(pgmimg, "%d%d%d", 0,0,0);

        }

        for (y = 0; y < qrcode.size; y++) {

            if (qrcode_getModule(&qrcode, x, y))
                fprintf(pgmimg, "%d%d%d", 1,1,1);
            else
                fprintf(pgmimg, "%d%d%d", 0,0,0);

        }

        for (y = 0; y < qrcode.size; y++) {

            if (qrcode_getModule(&qrcode, x, y))
                fprintf(pgmimg, "%d%d%d", 1,1,1);
            else
                fprintf(pgmimg, "%d%d%d", 0,0,0);

        }

    }
    fclose(pgmimg);

    gtk_image_set_from_file(pEntry.qrCode,file);

}


GtkWidget *confirmationWindow(int *argc, char ***argv) {

    GtkBuilder *builder = NULL;
    GError *error = NULL;
    gchar *filename = NULL;
    /* Initialisation de la librairie Gtk. */
    gtk_init(argc, argv);

    /* Ouverture du fichier Glade de la fenêtre principale */
    builder = gtk_builder_new();

    /* Création du chemin complet pour accéder au fichier test.glade. */
    /* g_build_filename(); construit le chemin complet en fonction du système */
    /* d'exploitation. ( / pour Linux et \ pour Windows) */
    filename =  g_build_filename ("../confirmationWindow.glade", NULL);

    /* Chargement du fichier test.glade. */
    gtk_builder_add_from_file (builder, filename, &error);
    g_free (filename);
    if (error)
    {
        gint code = error->code;
        g_printerr("%s\n", error->message);
        g_error_free (error);
        //return code;
    }

    /* Récupération des pointeurs de la fenêtre */
    GtkWidget *window = GTK_WIDGET(gtk_builder_get_object (builder, "confirmationWindow"));
    pEntry.qrCode = GTK_WIDGET(gtk_builder_get_object (builder, "qrCodeImage"));
    GtkWidget *cancelButton = GTK_WIDGET(gtk_builder_get_object (builder, "cancelButton"));
    GtkWidget *confirmButton = GTK_WIDGET(gtk_builder_get_object (builder, "confirmButton"));

    g_signal_connect(G_OBJECT (cancelButton), "clicked", (GCallback)deleteProvider, &window);
    g_signal_connect(G_OBJECT (confirmButton), "clicked", (GCallback)gtk_window_close, &window);


    /* Affichage de la fenêtre principale. */
    return window;

}


