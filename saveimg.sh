#!/bin/sh

a=$(ls /media/drive/images | wc -l)
cp img.jpg /media/drive/images/img_$a.jpg
