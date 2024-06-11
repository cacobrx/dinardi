#!/bin/bash
cadena1=`date +%y%m%d`
FICHERO=dinardi_$cadena1.sql.gz
HOST='190.184.228.30'
USUARIO='gus'
PASSWD='2325652605'
 
cd /home/gus/sistema/bkp
#cp $FICHERO $FICHERO2
ftp -p -n -v $HOST << SENTENCIASFTP
user $USUARIO $PASSWD
ascii
prompt
cd bkp
cd dinardi
put $FICHERO
bye
SENTENCIASFTP
