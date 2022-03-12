<?php

include_once '../core/init.php';

$dbDecoder = new DBDecoder();

$dbDecoder->encode();
$dbDecoder->destroyDecoded();
