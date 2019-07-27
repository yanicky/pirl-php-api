# pirl-php-api
Cryptopools.info is providing this api for public us as desired at the following url
http://pirlbalance.cryptopools.info/index.php?wallet=0x16e2ef393bcccaa6a9448b6ed36a6d180c61092e

json output would be something like
{
"wallet":"0x4bc7b9d69d6454c5666ecad87e5699c1ec02d533",
"balance":"1119.8800567580"
}

just replace that wallet with your own.

feel free to add pull requests, or fork for your own usage

ideas this can help with for instance include
scripting daily balance reports
ok, other things :)
this would also work for nearly any ethash based coin, just change the port to the coins rpc port.

How to run this?
install php-cli and php-curl if needed. you can then run it with command line client using wallet argument.

$php index.php --wallet=yourwalletaddresshere

If you want to have it serve up by a webserver, put the files into the web servers root directory and try the format above

you can use https://wallrpc.pirl.io:443 for the rpc address or run a pirl node locally and set it to localhost:6588 for local rpc calls


:)
