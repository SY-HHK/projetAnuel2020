//
// Created by hhk on 19/02/2020.
//
#include "general.h"

void finish_with_err(MYSQL *conn);

void db_connect(MYSQL *conn);

void closeConnection(MYSQL *conn);

void insertProvider(MYSQL *conn, provider p);
