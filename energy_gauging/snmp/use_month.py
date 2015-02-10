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
	full_output = get_output_full(output)
	customer = int(full_output[3])
	rack = full_output[4]
	total = get_total(output)
	sub = get_sub(output)
	db = MySQLdb.connect(db_host,db_user,db_pass,db_base)
	use = db.cursor()
	use.execute("INSERT INTO use_month (output_id, rack_id, customer_id, total, subtotal) VALUES (%s, %s, %s, %s, %s)", (output, rack, customer, total, sub))
	db.commit()
	use.close()
	db.close()