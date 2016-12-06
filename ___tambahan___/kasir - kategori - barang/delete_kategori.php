<?php
$id = $_GET['id'];
//connect database
	require_once('db_login.php');
	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
	if($db->connect_errno){
		die("Could not connect to the database: <br />".$db->connect_error);
	}

// Assign the query
$query = " SELECT * FROM kategori WHERE idkategori='".$id."'";
// Execute the query
$result = $db->query( $query );
$row = $result->fetch_object();
	if (!$result){
		die ("Could not query the database: <br />". $db->error);
	}else{
		echo '<table border="0">';
			echo '<tr>';
				echo '<td>Name</td>';
				echo '<td> : '.$row->nama.'</td>';
			echo '</tr>';
		echo '</table>';
		echo '<br />';
		echo 'Apakah anda yakin ingin menghapus data ini? ';
		echo '<a href="del_kategori.php?id='.$row->idkategori.'">Iya</a> / ';
		echo '<a href="view_customer.php">Tidak</a>';
		$db->close();
	}
?>
