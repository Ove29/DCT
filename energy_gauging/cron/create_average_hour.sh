#!/bin/bash
LOCKFILE=/var/lock/create_average_hour.txt
time_start=`date +"%s%N"`
now=`date +"%F %T"`
fact=10000000
echo "[$now]  create_average_hour started" >> /var/log/collecting
if [ -e ${LOCKFILE} ] && kill -0 `cat ${LOCKFILE}`; then
	 now=`date +"%F %T"`
    echo "[$now]  create_average_hour.sh failed, already running" >> /var/log/collecting
    exit
fi

trap "rm -f ${LOCKFILE}; exit" INT TERM EXIT
echo $$ > ${LOCKFILE}



now=`date +"%F %T"`
time_end=`date +"%s%N"`
time_run=` expr $time_end - $time_start `
time_run=` expr $time_run / $fact `
echo "[$now]  create_average_hour.sh finished sucesfully after $time_run microseconds" >> /var/log/collecting
rm -f ${LOCKFILE}