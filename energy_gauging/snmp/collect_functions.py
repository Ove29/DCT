#!/usr/bin/python
#
import os
import sys
import netsnmp
import MySQLdb

boid = ".1.3.6.1.4.1.31034"
db_host = ""
db_user = ""
db_pass = ""
db_base = ""

def get_gw(gw_id):
	db = MySQLdb.connect(db_host,db_user,db_pass,db_base)
	get_gw = db.cursor()
	get_gw.execute("SELECT * FROM gateway WHERE gw_id=%s", (gw_id))
	rows = get_gw.fetchone()
	gw = []
	gw.append(rows[0])
	gw.append(rows[2])
	gw.append(rows[3])
	gw.append(rows[4])
	return gw
	get_gw.close()
	db.close()

def get_dp_meter(dp_meter_id):
	db = MySQLdb.connect(db_host,db_user,db_pass,db_base)
	get_dp_meter = db.cursor()
	get_dp_meter.execute("SELECT * FROM dp_meter WHERE dp_meter_id=%s", (dp_meter_id))
	rows = get_dp_meter.fetchone()
	dp_meter = []
	dp_meter.append(rows[0])
	dp_meter.append(rows[2])
	gw = get_gw(dp_meter[1])
	dp_meter.append(gw[0])
	dp_meter.append(gw[1])
	dp_meter.append(gw[2])
	dp_meter.append(gw[3])
	return dp_meter
	get_dp_meter.close()
	db.close()

def get_output(out_id):
	db = MySQLdb.connect(db_host,db_user,db_pass,db_base)
	get_out = db.cursor()
	get_out.execute("SELECT * FROM output WHERE id=%s", (out_id))
	rows = get_out.fetchone()
	out = []
	out.append(rows[0])
	out.append(rows[1])
	out.append(rows[2])
	dp_meter = get_dp_meter(out[1])
	out.append(dp_meter[0])
	out.append(dp_meter[1])
	out.append(dp_meter[2])
	out.append(dp_meter[3])
	out.append(dp_meter[4])
	out.append(dp_meter[5])
	return out
	get_out.close()
	db.close()

def get_desc(out_id):
	out = get_output(out_id)
	out_id = out[0]
	dp_meter_id = out[1]
	out_port = out[2]
	gw_ip = out[6]
	gw_snmp_ver = out[7]
	gw_snmp_com = out[8]
	oid = str(boid)+'.1.1.4.1.18.'+str(dp_meter_id)+'.'+str(out_port)
	result = netsnmp.snmpget(oid,Version=1,DestHost=gw_ip,Community=gw_snmp_com)
	return result

def get_total(out_id):
	out = get_output(out_id)
	out_id = out[0]
	dp_meter_id = out[1]
	out_port = out[2]
	gw_ip = out[6]
	gw_snmp_ver = out[7]
	gw_snmp_com = out[8]
	oid = str(boid)+'.1.1.7.1.3.'+str(dp_meter_id)+'.'+str(out_port)
	temp = netsnmp.snmpget(oid,Version=1,DestHost=gw_ip,Community=gw_snmp_com)
	temp = temp[0]
	result = int(temp)
	return result

def get_sub(out_id):
	out = get_output(out_id)
	out_id = out[0]
	dp_meter_id = out[1]
	out_port = out[2]
	gw_ip = out[6]
	gw_snmp_ver = out[7]
	gw_snmp_com = out[8]
	oid = str(boid)+'.1.1.7.1.4.'+str(dp_meter_id)+'.'+str(out_port)
	temp = netsnmp.snmpget(oid,Version=1,DestHost=gw_ip,Community=gw_snmp_com)
	temp = temp[0]
	result = int(temp)
	return result

def get_factor(out_id):
	out = get_output(out_id)
	out_id = out[0]
	dp_meter_id = out[1]
	out_port = out[2]
	gw_ip = out[6]
	gw_snmp_ver = out[7]
	gw_snmp_com = out[8]
	oid = str(boid)+'.1.1.7.1.5.'+str(dp_meter_id)+'.'+str(out_port)
	temp = netsnmp.snmpget(oid,Version=1,DestHost=gw_ip,Community=gw_snmp_com)
	temp = temp[0]
	result = float(temp)/100.0
	return result

def get_curr(out_id):
	out = get_output(out_id)
	out_id = out[0]
	dp_meter_id = out[1]
	out_port = out[2]
	gw_ip = out[6]
	gw_snmp_ver = out[7]
	gw_snmp_com = out[8]
	oid = str(boid)+'.1.1.7.1.6.'+str(dp_meter_id)+'.'+str(out_port)
	result = netsnmp.snmpget(oid,Version=1,DestHost=gw_ip,Community=gw_snmp_com)
	result = float(result[0])/100.0
	return result

def get_peak(out_id):
	out = get_output(out_id)
	out_id = out[0]
	dp_meter_id = out[1]
	out_port = out[2]
	gw_ip = out[6]
	gw_snmp_ver = out[7]
	gw_snmp_com = out[8]
	oid = str(boid)+'.1.1.7.1.7.'+str(dp_meter_id)+'.'+str(out_port)
	result = netsnmp.snmpget(oid,Version=1,DestHost=gw_ip,Community=gw_snmp_com)
	result = float(result[0])/100.0
	return result

def get_volt(out_id):
	out = get_output(out_id)
	out_id = out[0]
	dp_meter_id = out[1]
	out_port = out[2]
	gw_ip = out[6]
	gw_snmp_ver = out[7]
	gw_snmp_com = out[8]
	oid = str(boid)+'.1.1.7.1.8.'+str(dp_meter_id)+'.'+str(out_port)
	result = netsnmp.snmpget(oid,Version=1,DestHost=gw_ip,Community=gw_snmp_com)
	result = float(result[0])/100.0
	return result

def all_outputs():
	db = MySQLdb.connect(db_host,db_user,db_pass,db_base)
	all_outputs = db.cursor()
	all_outputs.execute("SELECT id FROM output")
	all_out = []
	
	for row in all_outputs:
		all_out.append(row[0])
		
	return all_out
	all_outputs.close()
	db.close()
	
def get_output_full(out_id):
	db = MySQLdb.connect(db_host,db_user,db_pass,db_base)
	get_full = db.cursor()
	get_full.execute("SELECT * FROM output WHERE id=%s", (out_id))
	rows = get_full.fetchone()
	full = []
	full.append(rows[0])
	full.append(rows[1])
	full.append(rows[2])
	full.append(rows[3])
	full.append(rows[4])
	return full
	get_full.close()
	db.close()
