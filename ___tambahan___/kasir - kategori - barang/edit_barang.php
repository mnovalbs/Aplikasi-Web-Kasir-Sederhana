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
	$query = " SELECT * FROM barang WHERE idbarang=".$id." ";
	// Execute the query
	$result = $db->query( $query );
	if (!$result){
		die ("Could not query the database: <br />". $db->error);
	}else{
		while ($row = $result->fetch_object()){
			$nama = $row->nama;
			$deskripsi = $row->deskripsi;
			$harga = $row->harga;
			$stok = $row->stok;
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

	$deskripsi = test_input($_POST['deskripsi']);
	if($deskripsi == ''){
		$error_deskripsi= "Deskripsi harus diisi";
		$valid_deskripsi= FALSE;
	}else{
		$valid_deskripsi= TRUE;
	}

	$kategori = test_input($_POST['kategori']);
	if($kategori == '' || $kategori == "none"){
		$error_kategori= "Kategori harus diisi";
		$valid_kategori= FALSE;
	} else{
		$valid_kategori= TRUE;
	}

	$harga = test_input($_POST['harga']);
	if($harga == ''){
		$error_harga= "Harga harus diisi";
		$valid_harga= FALSE;
	}else{
		$valid_harga= TRUE;
	}
	
	$stok = test_input($_POST['stok']);
	if($stok == ''){
		$error_stok= "Stok harus diisi";
		$valid_stok= FALSE;
	} else{
		$valid_stok= TRUE;
	}

	
	//update data into database
	if ($valid_nama && $valid_deskripsi && $valid_kategori && $valid_harga && $valid_stok){
		//escape inputs data
		$nama = $db->real_escape_string($nama);
		$deskripsi = $db->real_escape_string($deskripsi);
		$kategori=$db->real_escape_string($kategori);
		$harga = $db->real_escape_string($harga);
		$stok = $db->real_escape_string($stok);
		//Asign a query
		$query = " UPDATE barang SET nama='".$nama."', deskripsi='".$deskripsi."', idkategori='".$kategori."', harga='".$harga."', stok='".$stok."' WHERE idbarang=".$id." ";
		// Execute the query
		$result = $db->query( $query );
		if (!$result){
		   die ("Could not query the database: <br />". $db->error);
		}else{
			echo 'Data has been updated.<br /><br />';
			echo '<a href="index.php">Back to Barang data</a>';
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
				<td valign="top">Deskripsi</td>
				<td valign="top">:</td>
				<td valign="top"><textarea name="deskripsi" rows="5" cols="30" placeholder="Stok (max 100 characters)"><?php echo $deskripsi;?></textarea></td>
				<td valign="top"><span class="error">* <?php echo $error_deskripsi;?></span></td>
			</tr>
			<tr>
				<td valign="top">Kategori</td>
				<td valign="top">:</td>
				<td valign="top"><select id="kategori" name="kategori" required>
					<option value="none">Pilih Kategori</option>
					<?php
						$querykat = "select * from kategori";
						$resultkat = $db->query($querykat);
						if(!$resultkat){
							die("Could not connect to the database : <br/>". $db->connect_error);
						}
						while ($row = $resultkat->fetch_object()){ 
							$kid = $row->idkategori; 
							$kname = $row->nama; 
							echo '<option value='.$kid.' '; 
							if(isset($kategori) && $kategori==$kid)
							echo 'selected="true"';
							echo '>'.$kname.'<br/></option>';
						} 
					?></select>
				</td>
				<td valign="top"><span class="error">* <?php if(!empty($error_kategori)) echo $error_kategori; ?></span></td>
			</tr>
			<tr>
				<td valign="top">Harga</td>
				<td valign="top">:</td>
				<td valign="top"><textarea name="harga" rows="5" cols="30" placeholder="Stok (max 100 characters)"><?php echo $harga;?></textarea></td>
				<td valign="top"><span class="error">* <?php echo $error_harga;?></span></td>
			</tr>
			<tr>
				<td valign="top">Stok</td>
				<td valign="top">:</td>
				<td valign="top"><textarea name="stok" rows="5" cols="30" placeholder="Stok (max 100 characters)"><?php echo $stok;?></textarea></td>
				<td valign="top"><span class="error">* <?php echo $error_stok;?></span></td>
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
