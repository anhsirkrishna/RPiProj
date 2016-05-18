#!/bin/sh

sudo umount /dev/sda1
sudo mount -o uid=pi,gid=pi,umask=000 /dev/sda1 /media/drive
