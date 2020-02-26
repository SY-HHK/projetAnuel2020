#include <stdio.h>
#include <stdlib.h>

int main() {

    if(system("mysql -u admin --password=test123 bringmeC < /home/hhk/Documents/projetAnuel2020/cPart/dataBaseMerger/scripts/script.sql")) {
        printf("Import échoué !");
    }
    else {
        printf("Import réussi !");
    }

}
