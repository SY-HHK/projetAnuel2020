//
// Created by hhk on 19/02/2020.
//

#include "graphicFunctions.h"
#include "databaseFunctions.h"

GtkWidget *main_window(void *argc, void *argv) {

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
    //pEntry.companyName = GTK_WIDGET(gtk_builder_get_object (builder, "companyNameEntry"));
    GtkWidget *firstNameEntry = GTK_WIDGET(gtk_builder_get_object (builder, "firstNameEntry"));
    pEntry.providerFirstName = firstNameEntry;
    /*pEntry.providerLastName = GTK_WIDGET(gtk_builder_get_object (builder, "lastNameEntry"));
    pEntry.providerBirth = GTK_WIDGET(gtk_builder_get_object (builder, "birthEntry"));
    pEntry.providerEmail = GTK_WIDGET(gtk_builder_get_object (builder, "emailEntry"));
    pEntry.providerPhone = GTK_WIDGET(gtk_builder_get_object (builder, "phoneEntry"));
    pEntry.providerAddress = GTK_WIDGET(gtk_builder_get_object (builder, "addressEntry"));
    pEntry.cityRegion = GTK_WIDGET(gtk_builder_get_object (builder, "regionEntry"));
    pEntry.cityDepartement = GTK_WIDGET(gtk_builder_get_object (builder, "departmentEntry"));
    pEntry.cityName = GTK_WIDGET(gtk_builder_get_object (builder, "cityEntry"));*/
    GtkWidget *createbutton = GTK_WIDGET(gtk_builder_get_object (builder, "createButton"));


    g_signal_connect(G_OBJECT (createbutton), "clicked", (GCallback)insertProvider, NULL);

    /* Affichage de la fenêtre principale. */
    return window;

}

