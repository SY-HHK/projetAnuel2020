cmake_minimum_required(VERSION 3.15)
project(qrCodeGenerator C)

set(CMAKE_C_STANDARD 99)

# Use the package PkgConfig to detect GTK+ headers/library files
FIND_PACKAGE(PkgConfig REQUIRED)
PKG_CHECK_MODULES(GTK3 REQUIRED gtk+-3.0)
PKG_CHECK_MODULES(LIBMYSQLCLIENT REQUIRED mysqlclient)

# Setup CMake to use GTK+, tell the compiler where to look for headers
# and to the linker where to look for libraries
INCLUDE_DIRECTORIES(${GTK3_INCLUDE_DIRS})
LINK_DIRECTORIES(${GTK3_LIBRARY_DIRS})

INCLUDE_DIRECTORIES(${LIBMYSQLCLIENT_INCLUDE_DIRS})
LINK_DIRECTORIES(${LIBMYSQLCLIENT_LIBRARY_DIRS})

# Add other flags to the compiler
ADD_DEFINITIONS(${GTK3_CFLAGS_OTHER})

# Add an executable compiled from hello.c
add_executable(qrCodeGenerator main.c graphicFunctions.h graphicFunctions.c databaseFunctions.h databaseFunctions.c struct.h)

# Link the target to the GTK+ libraries
TARGET_LINK_LIBRARIES(qrCodeGenerator ${GTK3_LIBRARIES})

TARGET_LINK_LIBRARIES(qrCodeGenerator ${LIBMYSQLCLIENT_LIBRARIES})
