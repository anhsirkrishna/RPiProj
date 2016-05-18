#!/bin/sh

a=$(df -h /dev/sda1)
set -- $a
size=$12
if [ "$size" = 100% ]
then
echo FULL
else
echo $size
fi





