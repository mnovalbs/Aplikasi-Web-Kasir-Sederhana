<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>Tubes PWI</title>
</head>
<body>
	<h2>Tubes PWI</h2>
	<a href="add_kategori.php"> Add kategori </a><br><br>
	<table border="1">
	<tr>
			<th>No</th>
			<th>Nama Kategori</th>
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
	$query = "SELECT * FROM kategori ORDER BY idkategori";
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
			echo '<td><a href="edit_kategori.php?id='.$row->idkategori.'"> Edit </a></td>';
			echo '<td><a href="delete_kategori.php?id='.$row->idkategori.'"> Delete </a></td>';
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
	<br />
	<br />
	<a href="index.php"> Kembali Ke daftar barang </a><br><br>

	</body>
	</html>