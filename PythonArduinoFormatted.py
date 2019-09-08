## File: PythonArduinoFormatted.py
## Project: CSCE 315 Project 1
## Date: 3/31/2018
## Section: 502
##
## This file contains the functions needed to read data from the 
## motion sensors and to send the data to the database.
## It also tests and makes sure that we can connect to the Arduino
## and the database


from pyfirmata import Arduino, util, pyfirmata ##connection to ardunio
import mysql.connector as mc ##connect to database
from time import sleep

##insertdata
##Inserts data into database: inserts when someone Walks In
def insertData() :
     format_str = """INSERT INTO RecTable (state)
     VALUES ({state});"""
	 
     try:
          sql_command = format_str.format(state = 1)
          cursor.execute(sql_command)		  
	## If we fail to insert data into the db we exith the program	  
     except mc.Error as e:
         print("Error %d: %s" % (e.args[0], e.args[1]))
         sys.exit(1)
     connection.commit()

##connectDatabase
##Attempts to connect to the database and returns the connection if successful
def connectDatabase(host1,user1,passwd1,db1):
     try:
         connection = mc.connect(host = host1,user = user1,passwd = passwd1,db = db1)
		## If the we fail to connect to the db we exit the program
     except mc.Error as e:
         print("Error %d: %s" % (e.args[0], e.args[1]))
         sys.exit(1)
     return connection

##connectArduino
##Attempts to connect to the arduino, returns the board if successful
def connectArdunio(port):
     try:
          board = Arduino(port)	
	## If we fail to connect to the Arduino we exit the program
     except:
          print("Unable to connect to Ardunio")
          sys.exit(1)
     it = util.Iterator(board)
     it.start()
     return board

##onLED
##Used to switch LEDS on
def onLED(pin):
     board.digital[pin].write(1)
	 
##offLED 
##Used to switch LEDS off  
def offLED(pin):
     board.digital[pin].write(0)



state1 = 0                      ##State of the sensor1
state2 = 0                      ##State of the sensor2
trip = 0                        ##Used to track which sensor is tripped first
value = 1                       ##Acts as a flag to make sure sensors rest when both are low

##Set board connection
board = connectArdunio('COM16') 

##Set sensor digital pin connections
sensor1 = board.get_pin('d:2:i')
sensor2 = board.get_pin('d:3:i')

##Set db connections
connection = connectDatabase('database.cs.tamu.edu', 
                             'runner123g','XXXXXXX',
                             'runner123g') 
cursor = connection.cursor()

while True:

     ##Continously checks if sensor 1 is detecting someone
     if  sensor1.read() == True :
                ##sets state and trip depending on sensor triped 
                state1 = 1
                if flag == 0 :
                    trip = 1
                    flag = 1
                sleep(0.2)
		
	##Continously checks if sensor 1 is detecting someone
     if  sensor2.read() == True :
                state2 = 1
                if flag == 0 :
                    trip = 2
                    flag = 1
                sleep(0.5)
                
     ##Reset case
     if sensor1.read() == False and sensor2.read() == False:
                state1 = 0
                state2 = 0
                flag = 0
                trip = 0
                sleep(0.2)
                
     ##Checks if some has walked in
     if trip == 1 :
         ##then checks if sensor2 is high
         if sensor2.read() == True :
             ##insert Data into db
             insertData()
             offLED(11)
             onLED(13)
             
			 ##loop used to wait till both sensors are low
             while value :
                  ##wait till both sensors low
                 if sensor1.read() == False and sensor2.read() == False:
                     value = 0
             value = 1
             sleep(0.2)
             offLED(13)
       
	   
     ##Checks if some has walked in
     if trip == 2 : 
		 ##Checks if sensor1 is high
         if sensor1.read() == True :
             ## not insert Data into db because only care about people walking in
             ##But may need this based on placment of box
             offLED(11)
             onLED(12)
			 
			 ##loop used to wait till both sensors are low
             while value :
                 if sensor1.read() == False and sensor2.read() == False:
                     value = 0
             value = 1
             sleep(0.2)
             offLED(12)
			 
      ##Green light on when nothing happens       
     if trip == 0 :
         onLED(11)
         
     
     
##close all connections
cursor.close()
connection.close()
