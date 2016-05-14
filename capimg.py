#!/usr/bin/python3

import picamera
import subprocess
from subprocess import PIPE
import os
import RPi.GPIO as GPIO
import configparser

config = configparser.RawConfigParser()
filenames=['config.cfg','/media/drive/config.cfg']

config.read(filenames)

led_pin = config.getint('PIN_SETUP','led_pin')
#GPIO.setmode(GPIO.BOARD)
#GPIO.setup(led_pin,GPIO.OUT)
fps = config.getint('CAM_SETUP','framerate')
height = config.getint('CAM_SETUP','height')
width = config.getint('CAM_SETUP','width')
hflip = config.getint('CAM_SETUP','horizontal_flip')
vflip = config.getint('CAM_SETUP','vertical_flip')
print(hflip,vflip)
rec_time = config.getint('CAM_SETUP','rec_time')
resolution = (width,height)
cwd = os.getcwd()
print(cwd)
with picamera.PiCamera() as camera:
	camera.resolution = resolution
	camera.fps = fps
	camera.hflip = hflip
	camera.vflip = vflip
	print(camera.hflip,camera.vflip)
	try:
		camera.capture(cwd+'/img.jpg')
		print("img Captured")
		#GPIO.output(led_pin,0)

	except :
		print("Couldn't capture image")

#GPIO.cleanup()
