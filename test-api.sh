#!/bin/bash
echo "Testing without parameters";
php index.php;
echo "***";
echo "Testing with bad wallet only parameters";
php index.php --wallet=0x256b2b26Fe8eCAd201103946F8C603b401cE16E;
echo "***";
echo "Testing with good wallet parameters with default parameter";
php index.php --wallet=0x256b2b26Fe8eCAd201103946F8C603b401cE16EC;
echo "***";
echo "Testing getBalance with Ethereum chain"; 
php index.php --wallet=0x256b2b26Fe8eCAd201103946F8C603b401cE16EC --chain=Ethereum;
echo "***";
echo "Testing getBalance with bad chain parameter";
php index.php --wallet=0x256b2b26Fe8eCAd201103946F8C603b401cE16EC --chain=Ethereu;
echo "***";
echo "Testing blockNumber with Pirl chain";
php index.php --chain=Pirl --CMD=blockNumber --id=1;
echo "***";
echo "Testing blockNumber with Ethereum chain";
php index.php --chain=Ethereum --CMD=blockNumber --id=2;
echo "***";
echo "Testing peerCount with default chain";
php index.php --CMD=peerCount --id=3;
echo "***";
echo "Testing peerCount with Ethereum chain";
php index.php --CMD=peerCount --chain=Ethereum --id=4;
echo "***";
echo "Testing net_version with default chain";
php index.php --CMD=net_version --chain=Pirl --id=5
echo "***";
echo "Testing net_version with Ethereum chain";
php index.php --CMD=net_version --chain=Ethereum --id=6
echo "***";
echo "Testing net_version with Default chain";
php index.php --CMD=web3_clientVersion --id=7
echo "***";
echo "Testing net_version with Ethereum chain";
php index.php --CMD=web3_clientVersion --chain=Ethereum --id=8
echo "***";
