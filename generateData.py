from __future__ import print_function
import random
import sys
import pandas as pd
import numpy as np
import sqlalchemy
import pyodbc
import random
import time

platform = ["facebook", "kik", "slack"] 
bot_id = ["SG1", "SG2"] #company names like kohl's
user_action = ["text", "clicked_on_carousel", "clicked_on_quick_reply", "voice", "image", "quit"]
expected_action = ["text", "clicked_on_carousel", "clicked_on_quick_reply", "voice", "image", "quit"]

#Table of user data -- generating this
t = [['Date_Field', 'User_ID', 'Platform', 'Bot_ID', 'UserAction', 'ExpectedAction', 'Sentiment_Bool']] #Header

#Generate table
for p in platform:
	for b in bot_id:
		#for i in xrange(0,1500000):
		for u in xrange(0,1000): #user id
			for i in xrange(0,random.randint(1,100)): #random number between 1 and 100
				ua = random.choice(user_action) #user action
				ea = random.choice(expected_action) #expected action
				d = randomDate("2016-12-20 1:30:00", "2016-6-19 4:50:00", random.random())			
				if ua == ea: 
					s = 1 #if useraction == expectedaction
				else: 
					s = 0 #if useraction != expectedaction
				t.append([d,u,p,b,ua,ea,s])


#Store table as panda dataframe (easier to convert to sql db)
headers = t.pop(0)
df = pd.DataFrame(t, columns=headers)
df = df.sample(frac=1) #shuffle

#Establish SQL connection
engine = sqlalchemy.create_engine('mysql+mysqlconnector://shobhit:jkjk@localhost/userdata')

# write the DataFrame to sql database
df.to_sql("userdata", engine, if_exists = 'replace')

#####################
#
# Helper functions
#
#####################
def strTimeProp(start, end, format, prop):
    stime = time.mktime(time.strptime(start, format))
    etime = time.mktime(time.strptime(end, format))
    ptime = stime + prop * (etime - stime)
    return time.strftime(format, time.localtime(ptime))


def randomDate(start, end, prop):
	return strTimeProp(start, end, '%Y-%m-%d %H:%M:%S', prop)
