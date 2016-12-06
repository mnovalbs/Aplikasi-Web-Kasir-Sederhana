
<!DOCTYPE html>
<?php
	
	//connect database
	require_once('db_login.php');
	$db=new mysqli($db_host, $db_username, $db_password, $db_database);
	$nama="";
	$harga="";
	$deskripsi="";
	$stok="";
	$valid_nama="";
	$idkategori ="";
	if($db->connect_errno){
		die("Could not connect to the database : <br/>". $db->connect_error);
	}
	function test_input($data){
		$data=trim($data);
		$data=stripslashes($data);
		$data=htmlspecialchars($data);
		return $data;
	}
	if (isset($_POST["submit"])){
		$nama=$_POST['nama'];
		$pm="([a-z0-9+!*(),;?&=\$_.-])";
		$nama=test_input($_POST['nama']);
		if($nama == ''){
			$error_nama= "Nama harus diisi";
			$valid_nama= FALSE;
		} elseif(!preg_match($pm,$nama)){
			$error_nama= "Hanya boleh huruf,angka,spasi tanda baca,.:/()";
			$valid_nama= FALSE;
		} else{
			$valid_nama= TRUE;
		}
	}
	
	//update data barang ke database
	if($valid_nama){
		//escape inputs data
		$nama=$db->real_escape_string($nama);
		//asign a query
		$query  = " INSERT INTO kategori (nama) 
				 VALUES ('$nama')"; //
		//execute query
		$result=$db->query($query);
		if(!$result){
			die("Could not connect to the database : <br/>". $db->connect_error);
		} else {
			echo'Data sudah diperbaharui.<br /><br />';
			echo'<a href="add_kategori.php"> Tambah data baru</a><br /><br />';
			
			echo'<a href="kategori.php"> Lihat table kategori</a><br />';
			$db->close();
			exit;
		}
	}
?>
<html>
	<head>
		<script src="js/jquery.js" type="text/javascript"></script>  
	</head>
	<script>
		$(document).ready(function() {
			$("#kategori").change(function(){
				var vname =$(this).val();
				$("#subkategori").load("sub_kategori.php",
				{
					id :vname
				},function(){
				});
			});
		});
	</script>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>Input Data Barang</title>
</head>
<body>
	<h2>User Input</h2>
	<form method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<table>
		<tr>
			<td valign="top">Nama</td>
			<td valign="top">:</td>
			<td valign="top"><input type="text" id="nama" name="nama" size="50" maxlength="100" 
			placeholder="Masukkan Nama (maximal 50 karakter)" required autofocus value="<?php echo $nama; ?>"></td>
			<td valign="top"><span class="error">*<?php if(!empty($error_nama)) echo $error_nama; ?></span></td>
		</tr>
		<tr>
			<td valign="top" colspan="3"> <br> <input type="submit" name="submit" value="Submit"></td>
		</tr>
	</table>
	</form>
</body>
</html>
<?php
	$db->close();
?>