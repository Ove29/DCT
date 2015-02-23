#!/usr/bin/python
#
import MySQLdb

from collect_functions import *

db_host = ""
db_user = ""
db_pass = ""
db_base = ""

all_outputs = all_outputs()
maxcount = len(all_outputs)

for x in range(0, maxcount):
	output = all_outputs[x]
	factor = get_factor(output)
	current = get_curr(output)
	peak = get_peak(output)
	voltage = get_volt(output)
	db = MySQLdb.connect(db_host,db_user,db_pass,db_base)
	use = db.cursor()
	use.execute("INSERT INTO collect_in (output_id, factor, current, peak, voltage) VALUES (%s, %s, %s, %s, %s)", (output, factor, current, peak, voltage))
	db.commit()
	use.close()
	db.close()