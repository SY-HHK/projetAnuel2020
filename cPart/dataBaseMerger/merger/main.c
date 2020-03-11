#include <stdio.h>
#include <stdlib.h>
#include "database.h"

int main() {

    if(system("mysql -u admin --password=test123 bringmeC < /home/hhk/Documents/projetAnuel2020/cPart/dataBaseMerger/scripts/script.sql")) {
        printf("Import échoué !");
    }
    else {
        printf("Import réussi !");
    }

return 0;
}


//SELECT * FROM PROVIDER INTO OUTFILE '/var/www/html/Backup.mdb' FIELDS TERMINATED BY ',';