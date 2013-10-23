#!/bin/bash

# You might have to install a new version of rsync for this to work.
# This is easily done by `brew install rsync` and restarting your terminal.

# Change these to match your settings
USER_NAME=''
HOST_NAME=''
LOCAL_PATH='./'
REMOTE_PATH=''

# The --iconv is for avoiding problems with case insensitive OSX-file systems
rsync -avzP --delete --iconv=UTF8-MAC,UTF-8 --exclude '.DS_Store' --exclude-from='donot-deploy.txt' -e ssh $LOCAL_PATH $USER_NAME@$HOST_NAME:$REMOTE_PATH
