#!/usr/bin/python
# -*- coding: utf-8 -*-
import os,MySQLdb,time,random,urllib.request,urllib
from shutil import copyfile
from phpserialize import *
from datetime import datetime
import aibots
aibots=aibots.aibots
def chat(userid):
	link='https://fullhood.com/AI/AIGRChat.php'
	query={'id':userid , 'pass': 'AI@@@///!!!' }
	data=urllib.parse.urlencode(query).encode("utf-8")
	request=urllib.request.Request(link,data)
	checkpass=urllib.request.urlopen(request)
def enchat(userid):
	link='https://fullhood.com/AI/AIENChat.php'
	query={'id':userid , 'pass': 'AI@@@///!!!' }
	data=urllib.parse.urlencode(query).encode("utf-8")
	request=urllib.request.Request(link,data)
	checkpass=urllib.request.urlopen(request)
while True:
	st=int(str(datetime.today().strftime('%H')))
	if st>=8 or st<=1:
		random.shuffle(aibots)
		for bot in aibots:
			bid=bot[0]
			bfolder=bot[1]
			blang=bot[2]
			bgen=bot[3]
			if blang=="gr":
				chat(bid)
			#if blang=="en":
				#enchat(bid)
			time.sleep(10)
	time.sleep(random.randint(300,600))