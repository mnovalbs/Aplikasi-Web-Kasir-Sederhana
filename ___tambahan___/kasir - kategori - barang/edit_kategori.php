<?php

$id = $_GET['id'];
$error_nama = '';
$error_deskripsi = '';
$error_harga = '';
$error_stok = '';
//connect database
require_once('db_login.php');
$db = new mysqli($db_host, $db_username, $db_password, $db_database);
if($db->connect_errno){
		die("Could not connect to the database: <br />".$db->connect_error);
	}
if(!isset($_POST["submit"])){
	$query = " SELECT * FROM kategori WHERE idkategori=".$id." ";
	// Execute the query
	$result = $db->query( $query );
	if (!$result){
		die ("Could not query the database: <br />". $db->error);
	}else{
		while ($row = $result->fetch_object()){
			$nama = $row->nama;
		}
	}
	
}else{
	$nama = test_input($_POST['nama']);
	if ($nama == ''){
		$error_nama = "Nama is required";
		$valid_nama = FALSE;
	}elseif (!preg_match("/^[a-zA-Z ]*$/",$nama)) {
       $error_nama = "Only letters and white space allowed";
	   $valid_nama = FALSE;
	}else{
		$valid_nama = TRUE;
	}

	
	//update data into database
	if ($valid_nama){
		//escape inputs data
		$nama = $db->real_escape_string($nama);
		//Asign a query
		$query = " UPDATE kategori SET nama='".$nama."' WHERE idkategori=".$id." ";
		// Execute the query
		$result = $db->query( $query );
		if (!$result){
		   die ("Could not query the database: <br />". $db->error);
		}else{
			echo 'Data has been updated.<br /><br />';
			echo '<a href="kategori.php">Back to kategori data</a>';
			$db->close();
			exit;
		}
	}
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>
<!DOCTYPE HTML>
<html>
<head>
<style>
	.error {color: #FF0000;}
</style>
</head>
<body>
	<h2>User Input</h2>
	<form method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'?id='.$id;?>">
		<table>
			<tr>
				<td valign="top">Name</td>
				<td valign="top">:</td>
				<td valign="top"><input type="text" name="nama" size="30" maxlength="50" placeholder="Name (max 50 characters)" autofocus value="<?php echo $nama;?>"></td>
				<td valign="top"><span class="error">* <?php echo $error_nama;?></span></td>
			</tr>
			<tr>
				<td valign="top" colspan="3"><br><input type="submit" name="submit" value="Submit">
			</tr>
		</table>
	</form>
</body>
</html>
<?php
$db->close();
?>
