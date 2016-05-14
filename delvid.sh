#!/bin/bash

a="/media/drive/videos/$1"
rm $a

videos=$(ls /media/drive/videos/)
cnt=0
for video in $videos
do
	mv /media/drive/videos/$video /media/drive/videos/vid_$cnt.mp4
	cnt=`expr $cnt + 1`
done
