<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$db = 'test';
	
	//Database creation
	function add_database() {
		global $server, $username, $password;
		
		$connect = mysqli_connect($server, $username, $password);
		
		if (!$connect) {
			die("ERROR: " . mysqli_connect_error());
		}

		$sql = "CREATE DATABASE test";
		
		if (mysqli_query($connect, $sql)) {
			echo "Database created successfully";
		} else {
			echo "Error creating database: " . mysqli_error($connect);
		}
		
		mysqli_close($connect);
		echo $message;
	}
	
	//Users and country tables creation
	function add_tables() {
		global $server, $username, $password, $db;

		$connect = mysqli_connect($server, $username, $password, $db);

		if (!$connect) {
			die("ERROR: " . mysqli_connect_error());
		}

		$sql = "CREATE TABLE users (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		user_name VARCHAR(30) NOT NULL,
		user_email VARCHAR(50) NOT NULL,
		user_country_id INT(6)
		);";
		$sql .= "CREATE TABLE country (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		country_name VARCHAR(30) NOT NULL
		);";
		
		if (mysqli_multi_query($connect, $sql)) {
			echo "Tables created successfully";
		} else {
			echo "Error creating table: " . mysqli_error($connect);
		}
		
		mysqli_close($connect);
		
	}

	function show_users() {
		global $server, $username, $password, $db;
		
		$connect = mysqli_connect($server, $username, $password, $db);
		
		if (!$connect) {
			$message = "Error:".$mysqli_connect_error();
		}
		
		$sql = "SELECT * FROM users";
		$users = [];
		
		if ($result = mysqli_query($connect, $sql)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$users[] = [
					"id" => $row['id'], 
					"user_name" => $row['user_name'], 
					"user_email" => $row['user_email'], 
					"user_country" => $row['user_country_id']
				];
			}
	
			mysqli_free_result($result);
		}
			
		mysqli_close($connect);
		
		header('Content-Type: application/json');
		echo json_encode($users);
	
	}
	
	function show_country() {
		global $server, $username, $password, $db;
		
		$connect = mysqli_connect($server, $username, $password, $db);
		
		if (!$connect) {
			$message = "Error:".$mysqli_connect_error();
		}
		
		$sql = "SELECT * FROM country";
		$country = [];
		
		if ($result = mysqli_query($connect, $sql)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$country[] = [
					"id" => $row['id'], 
					"country_name" => $row['country_name']
				];
			}
	
			mysqli_free_result($result);
		}
			
		mysqli_close($connect);
		
		header('Content-Type: application/json');
		echo json_encode($country);
	
	}


	function add_users() {
		global $server, $username, $password, $db;
		
		$connect = mysqli_connect($server, $username, $password, $db);
		
		if (!$connect) {
			$message = "Error:".$mysqli_connect_error();
		}
		
		$userName = $_REQUEST['user_name'];
		$userEmail = $_REQUEST['user_email'];
		$userCountry = $_REQUEST['user_country_id'];
		
		$sql = "INSERT INTO users (user_name, user_email, user_country_id) VALUES ('{$userName}', '{$userEmail}', '{$userCountry}');";
		
		if ($result = mysqli_query($connect, $sql)) {
			echo "User added!";
		} else {
			echo "Woops, something went wrong with users:" . mysqli_error($connect);
		}
			
		mysqli_close($connect);
	
	}
	
	
	function add_country() {
		global $server, $username, $password, $db;
		
		$connect = mysqli_connect($server, $username, $password, $db);
		
		if (!$connect) {
			$message = "Error:".$mysqli_connect_error();
		}
		
		$countryName = $_REQUEST['country_name'];
		
		$sql = "INSERT INTO country (country_name) VALUES ('{$countryName}');";
		
		if ($result = mysqli_query($connect, $sql)) {
			echo "Country added!";
		} else {
			echo "Woops, something went wrong with countries:" . mysqli_error($connect);
		}
			
		mysqli_close($connect);
	
	}
	
	function edit_users() {
		global $server, $username, $password, $db;
		
		$connect = mysqli_connect($server, $username, $password, $db);
		
		if (!$connect) {
			$message = "Error:".$mysqli_connect_error();
		}
		
		$userId = $_REQUEST['id'];
		
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		
			$sql = "SELECT * FROM users WHERE id=('{$userId}');";
			
			$users = [];
			
			if ($result = mysqli_query($connect, $sql)) {
				while ($row = mysqli_fetch_assoc($result)) {
					$users[] = [
						"id" => $row['id'],
						"user_name" => $row['user_name'],
						"user_email" => $row['user_email'],
						"user_country" => $row['user_country_id']
						];
				}
		
				mysqli_free_result($result);
			}
				
			mysqli_close($connect);
			
			header('Content-Type: application/json');
			echo json_encode($users);
			
		} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$userName = $_REQUEST['edit_user_name'];
			$userEmail = $_REQUEST['edit_user_email'];
			$userCountry = $_REQUEST['edit_user_country_id'];
			
			$sql = "UPDATE users SET user_name='{$userName}', user_email='{$userEmail}', user_country_id='{$userCountry}' WHERE id='{$userId}';";
			
			if ($result = mysqli_query($connect, $sql)) {
				echo "User updated!";
			} else {
				echo "Woops, something went wrong with users:" . mysqli_error($connect);
			}
				
			mysqli_close($connect);
			
		} else {
			echo "Wrong request method";
		}
	}
	
	function edit_country() {
		global $server, $username, $password, $db;
		
		$connect = mysqli_connect($server, $username, $password, $db);
		
		if (!$connect) {
			$message = "Error:".$mysqli_connect_error();
		}
		
		$countryId = $_REQUEST['id'];
		
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		
			$sql = "SELECT * FROM country WHERE id='{$countryId}';";
			
			$country = [];
			
			if ($result = mysqli_query($connect, $sql)) {
				while ($row = mysqli_fetch_assoc($result)) {
					$country[] = [
						"id" => $row['id'], 
						"country_name" => $row['country_name']
					];
				}
		
				mysqli_free_result($result);
			}
				
			mysqli_close($connect);
			
			header('Content-Type: application/json');
			echo json_encode($country);
			
		} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$countryName = $_REQUEST['edit_country_name'];
			
			$sql = "UPDATE country SET country_name='{$countryName}' WHERE id='{$countryId}';";
			
			if ($result = mysqli_query($connect, $sql)) {
				echo "Country updated!";
			} else {
				echo "Woops, something went wrong with country:" . mysqli_error($connect);
			}
				
			mysqli_close($connect);
			
		} else {
			echo "Wrong request method";
		}
	}
	
	function del_users() {
		global $server, $username, $password, $db;
		
		$connect = mysqli_connect($server, $username, $password, $db);
		
		if (!$connect) {
			$message = "Error:".$mysqli_connect_error();
		}
		
		$userId = $_REQUEST['id'];
		
		$sql = "DELETE FROM users WHERE id=('{$userId}');";
		
		if (mysqli_query($connect, $sql)) {
			echo "User deleted!";
		} else {
			echo "Woops, something went wrong with users:" . mysqli_error($connect);
		}
			
		mysqli_close($connect);
	
	}
	
	function del_country() {
		global $server, $username, $password, $db;
		
		$connect = mysqli_connect($server, $username, $password, $db);
		
		if (!$connect) {
			$message = "Error:".$mysqli_connect_error();
		}
		
		$countryId = $_REQUEST['id'];
		
		$sql = "DELETE FROM country WHERE id=('{$countryId}');";
		
		if (mysqli_query($connect, $sql)) {
			echo "Country deleted!";
		} else {
			echo "Woops, something went wrong with country:" . mysqli_error($connect);
		}
			
		mysqli_close($connect);
	
	}
	
	$getAction= $_REQUEST['action'];
	
	switch($getAction) {
		case "add_database": add_database();
		break;
		case "add_tables": add_tables();
		break;
		case "show_users": show_users();
		break;
		case "show_country": show_country();
		break;
		case "add_users": add_users();
		break;
		case "add_country": add_country();
		break;
		case "edit_users": edit_users();
		break;
		case "edit_country": edit_country();
		break;
		case "del_users": del_users();
		break;
		case "del_country": del_country();
		break;
		default: echo "Woops, wrong action!";
		break;
	}

?>