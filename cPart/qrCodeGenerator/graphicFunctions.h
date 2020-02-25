//
// Created by hhk on 19/02/2020.
//

#include <gtk-3.0/gtk/gtk.h>
#include <mysql.h>


GtkWidget *mainWindow(int *argc, char ***argv);

void generateQrCode(char companyName, char providerFirstName, char providerLastName, int idProvider);

GtkWidget *confirmationWindow(int *argc, char ***argv);
