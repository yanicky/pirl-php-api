<?php
// Library by phatblinkie to help with a simple query for scripts to access
// 

// Set Error Level
error_reporting(0);

// To be used with php-cli in console php index.php --wallet=yourwalletaddresshere
foreach( $argv as $argument ) {
        if( $argument == $argv[ 0 ] ) continue;

        $pair = explode( "=", $argument );
        $variableName = substr( $pair[ 0 ], 2 );
        $variableValue = $pair[ 1 ];
        //echo $variableName . " = " . $variableValue . "\n";
        // Optionally store the variable in $_REQUEST
        $_REQUEST[ $variableName ] = $variableValue;
}
// Create NewLine variable based on usage
if ($argc > 0) {$NL = "\n";} else {$NL = "</br>";}

//if passed, capture variables
$addr = $_REQUEST['wallet'];
$CMD = $_REQUEST['CMD'];
$CHAIN = $_REQUEST['chain'];

//pass some simple sanity checks
if (!$CMD){ $CMD = "getBalance";}
if(!$CHAIN){ $CHAIN = "Pirl";}


//include ethereum php library and create object
require 'ethereum-php/ethereum.php';

switch($CHAIN){
 case "Pirl":
	//pirls official rpc server, made for things like this
	$ethc = new Ethereum('https://wallrpc.pirl.io/', '443');
	break;

 case "Ethereum":
	//use --chain=Ethereum to connect to the cloudFlare Ethereum RPC Gateway
	$ethc = new Ethereum('https://cloudflare-eth.com', '443');
	break;
 case "localhost":
	//use this if your running a local pirl node (be sure to start it up with --rpc after the command)
	$ethc = new Ethereum('127.0.0.1', '6588');
	break;

default:
	$ethc = new Ethereum('https://wallrpc.pirl.io/', '443');
	$CHAIN="Pirl";
        break;
}

switch($CMD)
	{
	case "blockNumber":
	// get_blockNumber
	$res = $ethc->eth_blockNumber();
	$blocknum = hexdec($res);
	//setup array for json encoding
	$assocArray = array();
	$assocArray['jsonrpc'] = '2.0';
	$assocArray['id'] = '1';
	$assocArray['result'] = ''.hexdec($res).'';
	//encode in json format
	$jsondata = json_encode($assocArray);
	break;
	
	case "getBalance":
	if ( $addr == "" ) {echo "url should be in format 'http://host/index.php?wallet=0xasdfjasdlkjasdflkj' or using --wallet=yourwallethere from php-cli" . $NL; exit;}
	if ( strlen($addr) != "42" ) { echo "wallet should be 42 char, including the 0x beginning" . $NL; exit;}

	//get balance
	$dec = $ethc->eth_getBalance($addr, "latest");
	//convert from hex to decimal, then to human type numbers
	// 10 decimal spots, with a period, no thousands separator  = 1119.8800567580
	$pirl = number_format((hexdec($dec)/1000000000000000000), 10, ".", "");
	//setup array for json encoding
	$assocArray = array();
	$assocArray['wallet'] = ''.$addr.'';
	$assocArray['balance'] = ''.$pirl.'';
	//encode in json format
	$jsondata = json_encode($assocArray);
	break;
	
	case "help":
	echo "********************" . $NL;
	echo "Printing Help" . $NL. $NL;
	echo "options are CMD=[getBalance, blockNumber] chain=[Pirl, Ethereum, localhost]" . $NL;
	echo "ie: php index.php --CMD=blockNumber --chain=Pirl" . $NL;
	echo "url syntax when using a web server: http://host/index.php?wallet=0xasdfjasdlkjasdflkj&chain=Pirl&CMD=blockNumber" . $NL;
	break;
	
	default: 
	echo "This should not happen" . $NL;
	echo "please use --CMD=help for more details" . $NL;
	break;
}
//finally, echo result of the work.
echo $jsondata;
?>
