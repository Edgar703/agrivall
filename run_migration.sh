#!/bin/bash
cd /home/edgar/agrivall
timeout 60 php artisan migrate 2>&1
sleep 2
timeout 60 php artisan db:seed 2>&1
