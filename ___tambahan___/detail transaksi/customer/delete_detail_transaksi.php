<?php

	$id = $_GET['id'];
	// Connect database
	require_once('../db_login.php');
	$db =  new mysqli($db_host,$db_username,$db_password,$db_database);
	if($db->connect_errno){
		die("Could not connect to the database: <br />".$db->connect_error);
	}

	//Asign a query
	$query = " DELETE FROM detail_transaksi WHERE idtransaksi=".$id." ";

	// Execute the query
	$result = $db->query( $query );
	if(!$result){
		die("Could  not query the database : <br />".$db->error);
	}else{
		echo 'data terhapus <br />';
		echo '<br /><a href="view_detail_transaksi.php">Back</a>';
		$db->close();
		exit;
	}
?>
