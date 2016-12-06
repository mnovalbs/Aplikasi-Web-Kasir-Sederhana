<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>Tubes PWI</title>
</head>
<body>
	<h2>Tubes PWI</h2>
	<a href="kategori.php"> Kategori </a><br><br>
	<a href="add_barang.php"> Add Barang </a><br><br>
	<table border="1">
	<tr>
			<th>No</th>
			<th>Nama</th>
			<th>Deskripsi</th>
			<th>Kategori</th>
			<th>Stok</th>
			<th>Harga</th>
			<th>Last Update</th>
			<th>Petugas</th>
			<th colspan="3">Action</th>
	</tr>
	<?php
	//connect database
	require_once('db_login.php');
	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
	if($db->connect_errno){
		die("Could not connect to the database: <br />".$db->connect_error);
	}
	//Assign a query
	$query = "SELECT * FROM barang ORDER BY idbarang";
	//Execute the query
	$result = $db->query($query);
	if (!$result){
		die ("Could not query the database: <br />". $db->error);
	}
	//Fetch and Display the results
	$i=1;
	while($row = $result->fetch_object()){
		echo '<tr>';
			echo '<td>'.$i.'</td>';
			echo '<td>'.$row->nama.'</td>';
			echo '<td>'.$row->deskripsi.'</td>';
			echo '<td>'.$row->idkategori.'</td>';
			echo '<td>'.$row->stok.'</td>';
			echo '<td>'.$row->harga.'</td>';
			echo '<td>'.$row->last_update.'</td>';
			echo '<td>'.$row->idpetugas.'</td>';
			echo '<td><a href="detail_barang.php?id='.$row->idbarang.'"> Detail </a></td>';
			echo '<td><a href="edit_barang.php?id='.$row->idbarang.'"> Edit </a></td>';
			echo '<td><a href="delete_barang.php?id='.$row->idbarang.'"> Delete </a></td>';
			echo '<tr>';
			$i++;
	}
	echo '</table>';
	echo '<br />';
	echo 'Total Rows = '.$result->num_rows;
	$result->free();
	$db->close();
	?>
	</table>
</body>
</html>