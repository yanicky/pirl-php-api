<?php
// Library forked from phatblinkie and modded to help with simple query on Pirl.io and Ethereum type node.
// Tested with php-cli and php-fpm
//
// require php-curl to be installed/enabled.
// require 'ethereum-php/ethereum.php';

// Set Error Level
error_reporting(0);

// To be used with php-cli in console (ie: php index.php --wallet=yourwalletaddresshere)
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

//if requested, setup variables
$ID = $_REQUEST['id'];
$addr = $_REQUEST['wallet'];
$CMD = $_REQUEST['CMD'];
$CHAIN = $_REQUEST['chain'];
$RPCHOST = $_REQUEST['rpchost'];
$RPCPORT = $_REQUEST['rpcport'];
$BLOCK = $_REQUEST['block'];

// If Required uncomment/force some parameters here
//$addr = "yourwallethere";
//$CMD = "getBalance";
//$CHAIN = "local";
// The RPCHOST and RPCPORT only override settings if($CHAIN == "local").
//$RPCHOST = "localhost";
//$RPCPORT = 6588;

//pass some simple sanity checks
if (!$CMD){ $CMD = "getBalance";}
if (!$ID){ $ID = 1;}
//include ethereum-php library, select chain and create object
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
 case "local":
	//use this if your running a local pirl node (be sure to start it up with --rpc after the command)
	if(!$RPCHOST){ $RPCHOST = "localhost";}
	if(!$RPCPORT){ $RPCPORT = "6588";}	
	$ethc = new Ethereum($RPCHOST, $RPCPORT);
	break;

default:
	$ethc = new Ethereum('https://wallrpc.pirl.io/', '443');
	$CHAIN="Pirl";
        break;
}

switch($CMD)
	{
	case "web3_clientVersion":
        // web3_clientVersion
        $res = $ethc->web3_clientVersion();
        $web3_clientVersion = $res;
        //setup array for json encoding
        $assocArray = array();
        $assocArray['jsonrpc'] = '2.0';
        $assocArray['id'] = intval($ID);
        $assocArray['result'] = ''.$web3_clientVersion.'';
        //encode in json format
        $jsondata = json_encode($assocArray);
        break;
		
	case "net_version":
        // net_version
        $res = $ethc->net_version();
        $netversion = $res;
        //setup array for json encoding
        $assocArray = array();
        $assocArray['jsonrpc'] = '2.0';
        $assocArray['id'] = intval($ID);
        $assocArray['result'] = ''.$netversion.'';
        //encode in json format
        $jsondata = json_encode($assocArray);
        break;
	
	case "blockNumber":
	// get_blockNumber
	$res = $ethc->eth_blockNumber();
	$blocknum = hexdec($res);
	//setup array for json encoding
	$assocArray = array();
	$assocArray['jsonrpc'] = '2.0';
	$assocArray['id'] = intval($ID);
	$assocArray['result'] = ''.hexdec($res).'';
	//encode in json format
	$jsondata = json_encode($assocArray);
	break;
		
		
	case "peerCount":
        // net_peerCount
        $res = $ethc->net_peerCount();
        $peercount = hexdec($res);
        //setup array for json encoding
        $assocArray = array();
        $assocArray['jsonrpc'] = '2.0';
        $assocArray['id'] = intval($ID);
        $assocArray['result'] = ''.hexdec($res).'';
        //encode in json format
        $jsondata = json_encode($assocArray);
        break;
		
	case "getBalance":
	// verify validity of the required variables
	if ( $addr == "" ) {echo "url should be in format 'http(s)://hostname/path/to/index.php?wallet=youraddresshere' or using --wallet=yourwallethere from php-cli" . $NL; exit;}
	if ( strlen($addr) != "42" ) { echo "wallet should be 42 char, including the 0x beginning" . $NL; exit;}
	// Get the Data
	$res = $ethc->eth_getBalance($addr, "latest");
	//convert result from hex to decimal, then to human type numbers
	// 10 decimal spots, with a period, no thousands separator  = 1119.8800567580
	$pirl = number_format((hexdec($res)/1000000000000000000), 10, ".", "");
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
	echo "options are CMD=[net_version, getBalance, blockNumber, peerCount], chain=[Pirl, Ethereum, local], [rpchost=IP, Hostname] and [rpcport=PortNum]" . $NL;
	echo "ie: php index.php --CMD=blockNumber --chain=Pirl" . $NL;
	echo "url syntax examples when using a web server:" . $NL;
	echo "http(s)://hostname/path/to/index.php?chain=Pirl&CMD=blockNumber" . $NL;
	echo "http(s)://hostname/path/to/index.php?wallet=youraddresshere" . $NL;
	echo "http(s)://hostname/path/to/index.php?wallet=youraddresshere&chain=local&rpchost=localhost&rpcport=6588" . $NL;
	echo "http(s)://hostname/path/to/index.php?CMD=help" . $NL;
	break;
	
	default: 
	echo "********************" . $NL;
	echo "Error: CMD value is invalid." . $NL; 
	echo "please use --CMD=help for more details" . $NL;
	break;
}
//finally, echo result of the work.
if($jsondata!=""){echo $jsondata;}

?>
