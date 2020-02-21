#include "graphicFunctions.h"
#include "databaseFunctions.h"

int main(int argc,char **argv)
{
    conn = mysql_init(NULL);
    if (db_connect(conn) == 1) {
        gtk_widget_show_all(main_window(&argc, &argv));
        gtk_main();

        closeConnection(conn);

    }

    return 0;

}
