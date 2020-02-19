//
// Created by hhk on 19/02/2020.
//

#include "graphicFunctions.h"

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

    /* Récupération du pointeur de la fenêtre principale */
    GtkWidget *window = GTK_WIDGET(gtk_builder_get_object (builder, "mainWindow"));

    /* Affectation du signal "destroy" à la fonction gtk_main_quit(); pour la */
    /* fermeture de la fenêtre. */
    //g_signal_connect (G_OBJECT (cancel_button), "clicked", (GCallback)gtk_main_quit, NULL);

    /* Affichage de la fenêtre principale. */
    return window;

}

