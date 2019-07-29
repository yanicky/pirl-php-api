# pirl-php-api
Cryptopools.info is providing the orginal API for public use on Pirl Network at the following url
http://pirlbalance.cryptopools.info/index.php?wallet=0x256b2b26Fe8eCAd201103946F8C603b401cE16EC

json output would be something like:
{"wallet":"0x256b2b26Fe8eCAd201103946F8C603b401cE16EC","balance":"15720000.0000000000"}

just replace that wallet with your own.

this would also work for nearly any ethash based coin, just change the port to the coins rpc port.

How to run this version?
install php-cli and php-curl if needed. you can then run it with command line client using wallet argument.

$php index.php --wallet=yourwalletaddresshere [--chain=Pirl, Ethereum, local] [--CMD=getBalance, blockNumber, help]

You can also run the test-api.sh like this.
  
  /bin/sh test-api.sh;
  
or 

  chmod +x test-api.sh;
  
  ./test-api.sh;

This version Default on the Pirl(https://wallrpc.pirl.io:443) but Cloudflare's Ethereum Gateway(https://cloudflare-eth.com:443) can be used using --chain=[Pirl, Ethereum, local] optional parameter.

If you want to have it served by a webserver, put the files into the web root directory and try a url syntax like these: 

  http(s)://hostname/path/to/index.php?chain=Pirl&CMD=blockNumber

  http(s)://hostname/path/to/index.php?wallet=youraddresshere
  
  http(s)://hostname/path/to/index.php?CMD=help  

Feel free to add pull requests or fork it for your own usage.

The library under the hood has been forked @PhatBlinkie (https://github.com/phatblinkie/pirl-php-api), Thanks.
