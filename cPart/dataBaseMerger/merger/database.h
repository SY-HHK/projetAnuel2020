//
// Created by hhk on 11/03/2020.
//

#ifndef MERGER_DATABASE_H
#define MERGER_DATABASE_H

#endif //MERGER_DATABASE_H

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <mysql/mysql.h>

void finish_with_err(MYSQL *conn);

int db_connect(MYSQL *conn);

void closeConnection(MYSQL *conn);

void selectNextLine(char line[], FILE *ptr);

int alreadyExist(MYSQL *conn, char guid[]);

void insertProvider(MYSQL *conn, char line[]);
