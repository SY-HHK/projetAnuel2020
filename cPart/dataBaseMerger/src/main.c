
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <gtk/gtk.h>
#include <mysql/mysql.h>
#include "../include/database.h"

int main(int argc, char *argv[]) {

  MYSQL *conn = mysql_init(NULL);

  db_connect(conn);

  closeConnection(conn);

}
