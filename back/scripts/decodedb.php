<?php

include_once '../core/init.php';

$dbSecret = $_POST['dbSecret'];

$dbDecoder = new DBDecoder();
if ($dbDecoder->decode($dbSecret)) {
    (new Response(['message' => 'OK'], 200))->display();
} else {
    (new Response(['message' => 'wrong secret'], 402))->display();
}
