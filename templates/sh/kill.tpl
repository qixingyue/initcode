#!/bin/sh

ps aux | grep <{$service_name}> | grep -v "grep" | awk '{print $2}' | xargs kill -9 
