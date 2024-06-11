mysqldump -u gus -p17034049 dinardi -C --default-character-set=latin1 --opt | gzip -9 > /var/www/html/sistema/bkp/dinardi_$(date +%y%m%d).sql.gz
