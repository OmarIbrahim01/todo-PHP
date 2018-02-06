<?php

//--------Users Functions-----------

function user_loged_in(){
	if (!empty($_SESSION['user_id'])){
		return true;
	}else{
		return false;
	}
}

function current_user(){
	if (!empty($_SESSION['user_id'])){
		return $_SESSION['user_id'];
	}else {
		return false;
	}
}

function user_info(){
	require 'init.php';
	$query = $db->prepare("SELECT first_name, last_name, username, email FROM users WHERE user_id = 1");
	$query->execute();
	$results=$query->fetch(PDO::FETCH_ASSOC);
	return  $results;	
}

function log_in($username, $password){
	require 'init.php';
	$results = $db->prepare('SELECT user_id FROM users WHERE username = ? AND password = ?');
	$results->bindParam(1, $username, PDO::PARAM_STR);
	$results->bindParam(2, $password, PDO::PARAM_STR);
	$results->execute();
	$user = $results->fetchAll(PDO::FETCH_ASSOC);

	if (!empty($user)){
		 $_SESSION['user_id'] = $user[0]['user_id'];
		 return true;
	}else{
		return false;
	}
}

function log_out(){
	$_SESSION['user_id'] = null;
}


function register($first_name, $last_name=null, $username, $email, $password){
	require 'init.php';
	try {
		$query = $db->prepare('INSERT INTO users (first_name, last_name, username, email, password) VALUES (?, ?, ?, ?, ?)');
		$query->bindParam(1, $first_name, PDO::PARAM_STR);
		$query->bindParam(2, $last_name, PDO::PARAM_STR);
		$query->bindParam(3, $username, PDO::PARAM_STR);
		$query->bindParam(4, $email, PDO::PARAM_STR);
		$query->bindParam(5, $password, PDO::PARAM_STR);
		if ($query->execute()) {
			echo "User Created Succesfully";
			return true;
		}else{
			return false;
		}
	}catch(Exception $e){
		echo "Error: ".$e;
	}
}


//--------Todo Items Functions-----------

function get_items_list(){
	require 'init.php';
	$itemsQuery = $db->prepare("SELECT id,name,done
														FROM items 
														WHERE user_id = ? ");
	$itemsQuery->bindParam(1, $_SESSION['user_id'], PDO::PARAM_INT);
	$itemsQuery->execute();

	$items = $itemsQuery->fetchAll(PDO::FETCH_ASSOC);
	return $items;
}

function add_todo_item($item){
	require 'init.php';
	$addedQuery = $db->prepare("
			INSERT INTO items (name, user_id, done,created)
			VALUES (?, ?, 0, NOW())
	");
	$addedQuery->bindParam(1, $item, PDO::PARAM_STR);
	$addedQuery->bindParam(2, $_SESSION['user_id'], PDO::PARAM_INT);
	$addedQuery->execute();
}

function delete_todo_item($item_id){
	require 'init.php';
	$removeQuery = $db->prepare('DELETE FROM items WHERE id = ? AND user_id = ?');
	$removeQuery->bindParam(1, $item_id, PDO::PARAM_INT);
	$removeQuery->bindParam(2, $_SESSION['user_id'], PDO::PARAM_INT);
	$removeQuery->execute();
}

function mark_done($item, $as){
	require 'init.php';
	switch ($as) {
		case 'done':
			$doneQuery = $db->prepare('UPDATE items SET done = 1 WHERE id = ? AND user_id = ?');
			$doneQuery->bindParam(1, $item, PDO::PARAM_INT);
			$doneQuery->bindParam(2, $_SESSION['user_id'], PDO::PARAM_INT);
			$doneQuery->execute();
			break;
		case 'notdone':
			$doneQuery = $db->prepare('UPDATE items SET done = 0 WHERE id = ? AND user_id = ?');
			$doneQuery->bindParam(1, $item, PDO::PARAM_INT);
			$doneQuery->bindParam(2, $_SESSION['user_id'], PDO::PARAM_INT);
			$doneQuery->execute();
			break;
	}
}