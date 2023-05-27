<?php

include './model.php';

function login($pdo)
{
	$loginId = htmlspecialchars(strtolower($_POST['loginId']));
    $password = htmlspecialchars($_POST['password']);

    if (empty($loginId)) {
        $errMsg['login'] = "Input your email or phone number.";
    } elseif (empty($password)) {
        $errMsg['login'] = "Please enter your password";
    } else {
        try {
            $sql = "SELECT * FROM users WHERE email = :loginId OR phone = :loginId";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':loginId', $loginId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                if (password_verify($password, $result['password'])) {
                    session_start();

                    $_SESSION['user'] = $result['uid'];
                    $_SESSION['name'] = $result['name'];
                    $_SESSION['email'] = $result['email'];
                    $_SESSION['occupation'] = $result['occupation'];
                    $_SESSION['state'] = $result['state'];
                    $_SESSION['lga'] = $result['lga'];
                    $_SESSION['phone'] = $result['phone'];
                    $_SESSION['language'] = $result['language'];
                    $_SESSION['track'] = $result['track'];

					sendReply(200, "login Success");

                    // header('location: ../info/profile.html.php');
                } else {
                    $errMsg['login'] = "Invalid login details.";
                }
            } else {
                $errMsg['login'] = "Invalid login details.";
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    if (isset($errMsg)) {
		foreach ($errMsg as $err) {
        sendReply(400, $err);
        }
    }
}
