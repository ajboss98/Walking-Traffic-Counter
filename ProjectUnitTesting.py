## Unit testing for our python code - we test connection to the db and sensors here


import unittest
from pyfirmata import Arduino, util, pyfirmata
import mysql.connector
board = connectArdunio('COM16')
sensor1 = board.get_pin('d:2:i')
sensor2 = board.get_pin('d:3:i')


class TestArduinoPython(unittest.TestCase):

	def test_sql_connection(self):
        self.assertIsNot(pymssql.connect(server = 'database.cs.tamu.edu',user = 'runner123g',password = 'gramcaki', database = 'runner123g'), 
        	pymssql.connect(server = 'fakeserver',user = 'fakeuser',password = 'fakepassword', database = 'fakedb'))
	## Make sure connect does not fail by comparing it to a failed attempt

	def test_sensor_one(self):
		self.assertTrue(sensor1.read() == 0 || 1, "Unreasonable value from sensor 1")
	## Sensor should return 0 or 1, nothing else

	def test_sensor_two(self):
		self.assertTrue(sensor2.read() == 0 || 1, "Unreasonable value from sensor 2")
	## Same as before, the sensor should return 0 or 1

if __name__ == '__main__':
    unittest.main()