#!/bin/sh

a=$(ls /media/drive/videos | wc -l)
echo $a
MP4Box -fps 20 -add vid.h264 /media/drive/videos/vid_$a.mp4
