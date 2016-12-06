<?php
$id = $_GET['id'];
//connect database
	require_once('db_login.php');
	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
	if($db->connect_errno){
		die("Could not connect to the database: <br />".$db->connect_error);
	}

// Assign the query
$query = " SELECT * FROM barang WHERE idbarang='".$id."'";
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
			echo '<tr>';
				echo '<td>Deskripsi</td>';
				echo '<td> : '.$row->deskripsi.'</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Stok</td>';
				echo '<td> : '.$row->stok.'</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Harga</td>';
				echo '<td> : '.$row->harga.'</td>';
			echo '</tr>';
		echo '</table>';
		echo '<br />';
		echo 'Apakah anda yakin ingin menghapus data ini? ';
		echo '<a href="del_barang.php?id='.$row->idbarang.'">Iya</a> / ';
		echo '<a href="index.php">Tidak</a>';
		$db->close();
	}
?>
