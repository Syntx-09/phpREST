<?php
include './model.php';

function signup($pdo)
{
    $name = htmlspecialchars($_POST['name']);
	$email = strtolower($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $verifyPass = htmlspecialchars($_POST['verifyPassword']);
    $phone = htmlspecialchars($_POST['phone']);
    $occupation = htmlspecialchars($_POST['occupation']);
    $state = htmlspecialchars($_POST['state']);
	$lga = htmlspecialchars($_POST['lga']);
	$language = htmlspecialchars($_POST['language']);
    $track = htmlspecialchars($_POST['track']);


    $blank = "field is empty.";

	if (empty($name)) {
		$errMsg['name'] = "Name " . $blank;
	}
	if (empty($email)) {
		$errMsg['email'] = "Email " . $blank;
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errMsg['email'] = "Invalid Email";
    }
	if (empty($password)) {
		$errMsg['password'] = "Password " . $blank;
	} elseif (strlen($password) < 4) {
    	$errMsg['password'] = "Passwords min 4 characters.";
    }
    if ($verifyPass != $password) {
           $errMsg['password'] = "Passwords do not match";
    }

	if (empty($phone)) {
		$errMsg['phone'] = "Phone " . $blank;
	}
	if (empty($occupation)) {
		$errMsg['occupation'] = "Occupation " . $blank;
	}
	if (empty($state)) {
		$errMsg['state'] = "State " . $blank;
	}
	if (empty($lga)) {
		$errMsg['lga'] = "Local Government " . $blank;
	}
	if (empty($language)) {
		$errMsg['language'] = "Language " . $blank;
	}

	if (empty($errMsg)) {
		try {
			$sql = "SELECT * FROM users WHERE email = :email OR phone = :phone";
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(':email', $email);
			$stmt->bindValue(':phone', $phone);

			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($stmt->rowCount() > 0) {
				if ($result['email'] == $email) {
					$errMsg['email'] = "Email already exist. Try another.";
				}
				if ($result['phone'] == $phone) {
					$errMsg['phone'] = "Phone number aleady in use.";
				}
			} else {
				$hashPass = password_hash($password, PASSWORD_BCRYPT);
				//Generate unique id for registered users
				$bytes = random_bytes(1);
				$bytes2 = random_bytes(2);
				$uid = bin2hex($bytes.$bytes2);

				$sql = "INSERT INTO users (name, email, password, occupation, state, lga, phone, language, uid, track) VALUES (:name, :email, :password, :occupation, :state, :lga, :phone, :language, :uid, :track)";
				$insert =$pdo->prepare($sql);
				$insert->bindValue(':name', $name);
                $insert->bindValue(':email', $email);
                $insert->bindValue(':password', $hashPass);
                $insert->bindValue(':occupation', $occupation);
                $insert->bindValue(':state', $state);
                $insert->bindValue(':lga', $lga);
                $insert->bindValue(':phone', $phone);
                $insert->bindValue(':language', $language);
                $insert->bindValue(':uid', $uid);
                $insert->bindValue(':track', $track);


                $insert->execute();

                if ($insert->rowCount()) {
                    sendReply(200, "Registration Success!!");
                }

			}
		} catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	} else {
		// echo "<script>
		// alert(' Failed'); window.location='../register.html'
		// </script>";
		// header('location: ../register.html.php');
	}

	if (isset($errMsg)) {
		foreach ($errMsg as $err) {
            sendReply(400, $err);
			}
	}
}