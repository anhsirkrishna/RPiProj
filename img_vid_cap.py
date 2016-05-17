#!/usr/bin/python3

import io
import os
import subprocess
import picamera
from tkinter import *
import time
from tkinter import ttk
from tkinter import filedialog
import RPi.GPIO as GPIO

cwd = os.getcwd()

GPIO.setmode(GPIO.BOARD)
GPIO.setup(11,GPIO.OUT)
GPIO.setup(13,GPIO.IN)

root=Tk()
root.title("Image and Video Capture")

camera = picamera.PiCamera()
camera.framerate = 30
camera.resolution=(1920,1080)
camera.hflip = camera.vflip = True
camera.start_preview(fullscreen=0, window=(1280,640,640,480))
flag = 0

mainframe = ttk.Frame(root, padding="5 5 15 15")
mainframe.grid(column=0, row=0, sticky=(N, W, E, S))
mainframe.columnconfigure(0, weight=1)
mainframe.rowconfigure(0, weight=1)

label=ttk.Label(mainframe)
label.grid(column=1,row=1,sticky=W)
contents = StringVar()
label['textvariable'] = contents

def start():
	camera.start_recording('vid.h264')
	flag = 1
	contents.set('Recording')

def capture():
	camera.capture('img.jpg', use_video_port=True)
	subprocess.Popen(cwd + '/saveimg.sh', shell=True)

def stop():
	camera.stop_recording()
	subprocess.Popen(cwd + '/savevid.sh', shell=True)
	time.sleep(5)
	contents.set('Stopped')
	flag = 0
	
def close():
	if flag == 1:
		camera.stop_recording()
		subprocess.Popen(cwd + '/savevid.sh', shell=True)

	camera.stop_preview()
	camera.close()
	GPIO.cleanup()
	root.destroy()

def motion():
	i = GPIO.input(13)
	if i == 1:
		GPIO.output(11,1)
		capture()
		time.sleep(0.2)
		GPIO.output(11,0)
	root.after(2000,motion)

ttk.Button(mainframe, text="Start Rec", command=start).grid(column=1, row=2, sticky = (W, E))
ttk.Button(mainframe, text="Stop Rec", command=stop).grid(column=1, row=3, sticky = (W, E))
ttk.Button(mainframe, text="Capture Img", command=capture).grid(column=1, row=4, sticky = (W, E))
ttk.Button(mainframe, text="Close", command=close).grid(column=1, row=5, sticky = (W, E))
contents.set('Press Start rec to start recording')

for child in mainframe.winfo_children(): child.grid_configure(padx=10, pady=10)

root.after(2000,motion)
root.mainloop()
