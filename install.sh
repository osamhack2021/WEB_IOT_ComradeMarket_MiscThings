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
