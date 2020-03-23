#include "graphicFunctions.h"
#include "databaseFunctions.h"
#include <uuid/uuid.h>

int main(int argc,char **argv)
{
    pEntry.argc = &argc;
    pEntry.argv = &argv;
    conn = mysql_init(NULL);
    if (db_connect(conn) == 1) {
        gtk_widget_show_all(mainWindow(&argc, &argv));
        gtk_main();

        closeConnection(conn);

    }

    return 0;

}
