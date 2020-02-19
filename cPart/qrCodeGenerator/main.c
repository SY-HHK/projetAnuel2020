#include "graphicFunctions.h"
#include "databaseFunctions.h"

int main(int argc,char **argv)
{

    //gtk_widget_show_all (main_window(&argc, &argv));
    //gtk_main();

    MYSQL *conn = mysql_init(NULL);

    db_connect(conn);

    provider p;
    insertProvider(conn, p);

    //listProvider(conn);

    closeConnection(conn);

    return 0;

}
