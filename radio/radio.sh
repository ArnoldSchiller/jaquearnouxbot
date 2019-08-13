#!/bin/bash
# sleep $(( RANDOM % 14400 ));
PATH=`pwd $0`
cd $PATH
export MY_SCREEN_NAME=
export MY_LANGUAGE=DE
export CONSUMER_KEY=''
export CONSUMER_SECRET=''
export ACCESS_TOKEN=''
export ACCESS_TOKEN_SECRET=''
export ICESLOG='ices.log.example'
export HOST='host.example'
export SED1=`echo -n 's/\/musik\/ogg\//https:\/\/'$HOST'\/musik\//g'`
export SED2=`echo -n 's/Currently playing/spielte https:\/\/'$HOST'\/radio/g'`
echo "/bin/grep INFO $ICESLOG | /bin/grep playlist | /bin/sed $SED1 | sed 's/ogg/ogg.html/g' | /bin/sed 's/INFO playlist-builtin\/playlist_read//g' | /bin/sed $SED2 | /bin/sed 's/\[/Am /g' | /bin/sed 's/\]/ Uhr/g' | tail -n1 |  $PATH/tweet.sh/tweet.sh post"
echo "You have to edit this file $0  this is an example."

