<?php
$id = $_GET['id'];
//connect database
	require_once('db_login.php');
	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
	if($db->connect_errno){
		die("Could not connect to the database: <br />".$db->connect_error);
	}
//hapus
$query = "DELETE FROM kategori WHERE idkategori='".$id."'";
$result = $db->query( $query );
echo 'Data has been deleted <br />';
echo '<a href="kategori.php">Back to Kategori Data</a>';
$db->close();
?>