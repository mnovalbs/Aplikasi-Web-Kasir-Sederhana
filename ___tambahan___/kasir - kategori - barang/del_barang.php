<?php
$id = $_GET['id'];
//connect database
	require_once('db_login.php');
	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
	if($db->connect_errno){
		die("Could not connect to the database: <br />".$db->connect_error);
	}
//hapus
$query = "DELETE FROM barang WHERE idbarang='".$id."'";
$result = $db->query( $query );
echo 'Data has been deleted <br />';
echo '<a href="index.php">Back to Customers Data</a>';
$db->close();
?>