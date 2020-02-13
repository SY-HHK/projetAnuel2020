#ifndef DATABASE_HEADER
#define DATABASE_HEADER

void get_conf_file(char host[], char dbuser[], char dbpass[], char dbname[]);
void finish_with_err(MYSQL *conn);
void db_connect(MYSQL *conn);
void closeConnection(MYSQL *conn);

#endif
