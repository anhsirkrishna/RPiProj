#!/bin/sh

a=$(ls /media/drive/videos | wc -l)
MP4Box -fps 25 -add vid.h264 /media/drive/videos/vid_$a.mp4
