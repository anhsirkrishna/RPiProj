#!/bin/bash

a="/media/drive/images/$1"
rm $a

images=$(ls /media/drive/images/)
cnt=0
for image in $images
do
	mv /media/drive/images/$image /media/drive/images/img_$cnt.jpg
	cnt=`expr $cnt + 1`
done
