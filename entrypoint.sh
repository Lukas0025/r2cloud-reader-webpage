#!/bin/bash
echo "[INFO] starting web server"

/usr/sbin/apache2ctl -D FOREGROUND
