#!/bin/sh

if[-f "/tmp/restart"]
then
	rm -f /tmp/restart
	/sbin/reboot
fi

