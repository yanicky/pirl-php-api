<?php
//created by phatblinkie to help with a simple query for scripts to access
error_reporting(0);

//pass some simple sanity checks

if ( $_REQUEST['wallet'] == "" ) {echo "url should be in format http://host/index.php?wallet=0xasdfjasdlkjasdflkj"; exit;}
if ( strlen($_REQUEST['wallet']) != "42" ) { echo "wallet should be 42 char, including the 0x beginning"; exit;}

//include ethereum php library
require 'ethereum-php/ethereum.php';
//create object
#$ethc = new Ethereum('198.23.249.179', 6588);
$ethc = new Ethereum('127.0.0.1', 6588);
//if passed, capture wallet id
$addr = $_REQUEST['wallet'];

//get balance
$dec = $ethc->eth_getBalance($addr, "latest");

//convert from hex to dev, then to human type numbers
// 10 decimal spots, with a period, no thousands separator  = 1119.8800567580

$pirl = number_format((hexdec($dec)/1000000000000000000), 10, ".", "");

//setup array for json encoding
$assocArray = array();
$assocArray['wallet'] = ''.$addr.'';
$assocArray['balance'] = ''.$pirl.'';

//print_r($assocArray);

//encode in json format
$jsondata = json_encode($assocArray);

//finally, echo result of the work.
echo $jsondata;
?>
