<?php

header('Access-Control-Allow-Origin: http://localhost:5500');
header('Access-Control-Allow-Credentials: true');

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