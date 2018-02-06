<?php
session_start();
require 'app/functions.php';
require 'app/init.php';

if (!user_loged_in()){
	header('Location:index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$item = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
	if (!empty($item)) {
		add_todo_item($item);
		header('Location: todo.php');
	}
}

if (isset($_GET['remove_item_id'])){
	$item = $_GET['remove_item_id'];
	if (!empty($item)){
	delete_todo_item($item);
	header('Location: todo.php');
	}
}

if (isset($_GET['item'], $_GET['as'])){
	$as = $_GET['as'];
	$item = $_GET['item'];
	if (!empty($item) || !empty($as)){
		mark_done($item, $as);
		header('Location: todo.php');
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>to-do </title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light+Two" rel="stylesheet">
	<meta name="viewport" content="width=device-width" initial-scale=1.0>
</head>
<body>

 <div class="list">
 	<h1 class="header"><?php echo(user_info()['first_name'].' '.user_info()['last_name']); ?>'s To do. <a href="index.php?log_out=true">Log Out</a></h1>
 	<?php if(!empty(get_items_list())): ?>	
 	<ul class="items">
 		<?php foreach (get_items_list() as $item): ?>
 		<li>
 			<span class="item<?php echo $item['done'] ? ' done' : '' ?>"><?php echo $item["name"]; ?></span>
 			<?php if(!$item['done']): ?>
 			<a href="todo.php?as=done&item=<?php echo $item['id']; ?>" class="done-button">Mark as done</a>
 			<?php elseif($item['done']): ?>
 			<a href="todo.php?as=notdone&item=<?php echo $item['id']; ?>" class="done-button">Undo</a>
 			<?php endif; ?>
 			<a href="todo.php?remove_item_id=<?php echo $item['id']; ?>" class="done-button remove-button">X</a>
 		</li>
 	<?php endforeach; ?>
 	</ul>
 	<?php else: ?>
 		<p>Youe haven't  added any items yet.</p>
 	<?php endif; ?>

 	<form class="item-add" action="todo.php" method="post">
 		<input type="text" name="name" placeholder="Add new item here." class="input" autocomplete="off" required>
 		<input type="submit" value="Add" name="add" class="submit">
 	</form>
 </div>
</body>
</html>