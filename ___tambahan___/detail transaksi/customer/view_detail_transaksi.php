<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>View Customers</title>
</head>
<body>
<h2>Detail Transaksi</h2>

<table border = "1">
    <tr>
	<th>No</th>
	<th>IDtransaksi</th>
    <th>IDbarang</th>
	<th>jumlah</th>
	<th>Harga</th>
    </tr>
<?php

// connect database
require_once('../db_login.php');
$db = new mysqli($db_host,$db_username,$db_password,$db_database);
if ($db->connect_errno){
    die ("Could not connect to the database: <br />". $db->connect_error);
}
//Asign a query
$query = " SELECT * FROM detail_transaksi ORDER BY idtransaksi ";
// Execute the query
$result = $db->query( $query );
if (!$result){
   die ("Could not query the database: <br />". $db->error);
}
// Fetch and display the results
$i = 1;
while ($row = $result->fetch_object()){
	echo '<tr>';
    	echo '<td>'.$i.'</td>';
    	echo '<td>'.$row->idtransaksi.'</td> ';
		echo '<td>'.$row->idbarang.'</td> ';
		echo '<td>'.$row->jumlah.'</td>';
		echo '<td>'.$row->harga.'</td>';
		echo '<td>';
		echo '<a href="edit_detail_transaksi.php?id='.$row->idtransaksi.'"> Edit </a>';
		echo '<a href="delete_detail_transaksi.php?id='.$row->idtransaksi.'"> Delete </a>';
		echo '</td>';
	echo '</tr>';
	$i++;
}
echo '</table>';
echo '<br />';
echo '<a href="add_detail_transaksi.php">Tambah detail transaksi</a><br />';
$result->free();
$db->close();
?>
</body>
</html>
