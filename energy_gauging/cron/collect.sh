#!/bin/bash
LOCKFILE=/var/lock/collect.txt
time_start=`date +"%s%N"`
now=`date +"%F %T"`
fact=10000000
echo "[$now]  collect.sh started" >> /var/log/collecting
if [ -e ${LOCKFILE} ] && kill -0 `cat ${LOCKFILE}`; then
	 now=`date +"%F %T"`
    echo "[$now]  collect.sh failed, already running" >> /var/log/collecting
    exit
fi

trap "rm -f ${LOCKFILE}; exit" INT TERM EXIT
echo $$ > ${LOCKFILE}

python /opt/snmpcollect/collect_all.py
now=`date +"%F %T"`
time_end=`date +"%s%N"`
time_run=` expr $time_end - $time_start `
time_run=` expr $time_run / $fact `
echo "[$now]  collect.sh finished sucesfully after $time_run microseconds" >> /var/log/collecting
rm -f ${LOCKFILE}