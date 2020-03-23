cmake_minimum_required(VERSION 3.15)
project(merger C)

set(CMAKE_C_STANDARD 99)

# Use the package PkgConfig to detect GTK+ headers/library files
FIND_PACKAGE(PkgConfig REQUIRED)
PKG_CHECK_MODULES(GTK3 REQUIRED gtk+-3.0)
PKG_CHECK_MODULES(LIBMYSQLCLIENT REQUIRED mysqlclient)

INCLUDE_DIRECTORIES(${LIBMYSQLCLIENT_INCLUDE_DIRS})
LINK_DIRECTORIES(${LIBMYSQLCLIENT_LIBRARY_DIRS})

add_executable(merger main.c database.h database.c)

TARGET_LINK_LIBRARIES(merger ${LIBMYSQLCLIENT_LIBRARIES})