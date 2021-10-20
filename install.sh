#!/bin/sh

lists=$(ls WEB(FE))
for item in ${lists}
do
    if [ $item != "install.sh" ]
    then
        cp -r ./WEB(FE)/$item ./
        echo "done : " $item
    fi
done

lists=$(ls WEB(BE))
for item in ${lists}
do
    if [ $item != "install.sh" ]
    then
        cp -r ./WEB(BE)/$item ./
        echo "done : " $item
    fi
done

query="ALTER USER 'root'@'localhost' IDENTIFIED BY 'P@ssW0rd2316';";
mysql -uroot -D mysql -e "${query}";

query2="create database osam;";
mysql -uroot -pP@ssW0rd2316 -e "${query}";
mysql -uroot -pP@ssW0rd2316 osam < osam.sql
