# pirl-php-api
Cryptopools.info is providing the orginal API for public use on Pirl Network at the following url
http://pirlbalance.cryptopools.info/index.php?wallet=0x16e2ef393bcccaa6a9448b6ed36a6d180c61092e

json output would be something like
{
"wallet":"0x4bc7b9d69d6454c5666ecad87e5699c1ec02d533",
"balance":"1119.8800567580"
}

just replace that wallet with your own.

this would also work for nearly any ethash based coin, just change the port to the coins rpc port.

How to run this version?
install php-cli and php-curl if needed. you can then run it with command line client using wallet argument.

$php index.php --wallet=yourwalletaddresshere [--chain=Pirl, Ethereum] [--CMD=getBalance, blockNumber, help]

This version Default on the Pirl(https://wallrpc.pirl.io:443) but Cloudflare's Ethereum Gateway(https://cloudflare-eth.com:443) can be used using --chain=[Pirl, Ethereum, localhost] optional parameter.

If you want to have it serve up by a webserver, put the files into the web root directory and try a url syntax like: 

http://host/index.php?chain=Pirl&CMD=blockNumber

Feel free to add pull requests or fork it for your own usage.

The library under the hood has been forked from PhatBlinkie(https://github.com/phatblinkie/pirl-php-api), Thanks.
