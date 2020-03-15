#include "database.h"

int main() {

    int nb_error = 0;
    int nb_line = 0;
    //char tab_error[10][37];
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
        selectNextLine(line,ptr);
        //trouver le guid
        virgule = 0;
        while(strchr(line+virgule, ',') != NULL) {
            virgule++;
        }
        strcpy(guid, line+virgule); //on met le guid dans une string
        guid[strlen(guid)-1] = '\0';

        if (alreadyExist(conn, "companyName", "PROVIDER", "providerGuid", guid)) {
            nb_error++;
            nb_line++;
            //tab_error[nb_error][0] = guid;
        }
        else {
            nb_line++;
            insertProvider(conn, line);
        }
    }

    printf("%d prestataire à ajouté... \n", nb_line);
    printf("%d prestataires n'ont pas étaient ajoutés car ils existaient déja ! \n", nb_error);

    closeConnection(conn);
    fclose(ptr);

return 0;
}


//SELECT * FROM PROVIDER INTO OUTFILE '/var/www/html/backup.mdb' FIELDS TERMINATED BY ',';

//SELECT companyName, providerFirstName, providerLastName, providerBirth, providerEmail, providerPhone, providerAddress, cityName, cityDepartment, cityRegion, providerGuid FROM PROVIDER INNER JOIN CITY ON PROVIDER.idCity = CITY.idCity INTO OUTFILE '/var/www/html/backupALL.mdb' FIELDS TERMINATED BY ',';