<?php

// header('Access-Control-Allow-Origin": http://localhost:5500');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, GET, POST");
include_once "./database.php";

function sendReply($code, $msg)
{
    http_response_code($code);
    echo $msg;
    exit();
}



if ($_SERVER['REQUEST_METHOD'] == "GET") {
	logout($pdo);
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['mode'] == "signUp")
signup($pdo);

if ($_SERVER['REQUEST_METHOD'] == "PATCH")
update($pdo);

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['mode'] == "logUser")
login($pdo);



function update($pdo) {}
function logout($pdo) {}
