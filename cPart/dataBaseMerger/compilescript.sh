#!/bin/bash

gcc `pkg-config --cflags gtk+-3.0` `mysql_config --cflags --libs` -o bringmeC src/*.c `pkg-config --libs gtk+-3.0` -rdynamic
