#include "database.h"

int main() {

    int nb_error = 0;
    int nb_line = 0;
    char tab_error[10][37];
    int virgule;
    FILE *ptr;
    char line[800];
    char guid[37];
    ptr = fopen("backup.mdb","r+");
    if (ptr == NULL) {
        printf("impossible d'ouvrir le fichier");
        return 0;
    }
    MYSQL *conn = mysql_init(NULL);
    if (db_connect(conn) != 1) {
        printf("impossible de se connecter à la bdd");
        return 0;
    }


    while (!feof(ptr)) {
        nb_line++;
        selectNextLine(line,ptr);
        //trouver le guid
        virgule = 0;
        while(strchr(line+virgule, ',') != NULL) {
            virgule++;
        }
        strcpy(guid, line+virgule); //on met le guid dans une string
        printf("guid = %s", guid);

        if (alreadyExist(conn, guid)) {
            nb_error++;
            tab_error[nb_error][0] = guid;
        }
        else {
            insertProvider(conn, line);
        }
    }

    closeConnection(conn);
    fclose(ptr);

    /*if(system("mysql -u admin --password=test123 bringmeC < /home/hhk/Documents/projetAnuel2020/cPart/dataBaseMerger/scripts/script.sql")) {
        printf("Import échoué !");
    }
    else {
        printf("Import réussi !");
    }*/

return 0;
}


//SELECT * FROM PROVIDER INTO OUTFILE '/var/www/html/backup.mdb' FIELDS TERMINATED BY ',';