#!/usr/bin/python3

import picamera
import subprocess
import RPi.GPIO as GPIO
import configparser

config = configparser.RawConfigParser()
filenames=['media/drive/config.cfg','config.cfg']

config.read(filenames)

led_pin = config.getint('PIN_SETUP','led_pin')

GPIO.setmode(GPIO.BOARD)
GPIO.setup(led_pin,GPIO.OUT)

fps = config.getint('CAM_SETUP','framerate')
height = config.getint('CAM_SETUP','height')
width = config.getint('CAM_SETUP','width')
resolution = (width,height)

with picamera.PiCamera() as camera:
	camera.resolution = resolution
	camera.fps = fps
	try:
		camera.start_recording('vid.h264')
		GPIO.output(led_pin,1)
		while True:
			camera.wait_recording(1)
	except KeyboardInterrupt:
		camera.stop_recording()
		GPIO.output(led_pin,0)

GPIO.cleanup()
