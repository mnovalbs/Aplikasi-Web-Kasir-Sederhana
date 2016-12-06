
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
		$deskripsi=$_POST['deskripsi'];
		$kategori=$_POST['kategori'];
		$harga=$_POST['harga'];		
		$stok=$_POST['stok'];
		$pm="([a-z0-9+!*(),;?&=\$_.-])";
		$hg="([0-9])";
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
		$deskripsi= test_input($_POST['deskripsi']);
		if($deskripsi == ''){
			$error_deskripsi= "Deskripsi harus diisi";
			$valid_deskripsi= FALSE;
		} else{
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
		}
		elseif(!preg_match($hg, $harga)){
			$error_harga= "Hanya boleh angka";
			$valid_harga= FALSE;
		} else{
			$valid_harga= TRUE;
		}
		$stok = test_input($_POST['stok']);
		if($stok == ''){
			$error_stok= "Stok harus diisi";
			$valid_stok= FALSE;
		} else{
			$valid_stok= TRUE;
		}
	}
	
	//update data barang ke database
	if($valid_nama && $valid_deskripsi && $valid_kategori && $valid_stok && $valid_harga){
		//escape inputs data
		$nama=$db->real_escape_string($nama);
		$deskripsi=$db->real_escape_string($deskripsi);
		$kategori=$db->real_escape_string($kategori);
		$harga=$db->real_escape_string($harga);
		$stok=$db->real_escape_string($stok);
		//asign a query
		$query  = " INSERT INTO barang (nama, deskripsi, idkategori, stok, harga, last_update) 
				 VALUES ('$nama','$deskripsi','$kategori','$stok','$harga',now())"; //
		//execute query
		$result=$db->query($query);
		if(!$result){
			die("Could not connect to the database : <br/>". $db->connect_error);
		} else {
			echo'Data sudah diperbaharui.<br /><br />';
			echo'<a href="add_furniture.php"> Tambah data baru</a><br /><br />';
			
			echo'<a href="index.php"> Lihat table Barang</a><br />';
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
			<td valign="top">Deskripsi</td>
			<td valign="top">:</td>
			<td valign="top"><textarea name="deskripsi" rows="5" cols="30" maxlength="255" 
			placeholder="Masukkan deskripsi (maximal 255 karakter)" required> <?php echo $deskripsi; ?> </textarea></td>
			<td valign="top"><span class="error">*<?php if(!empty($error_deskripsi)) echo $error_deskripsi; ?></span></td>
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
			<td valign="top">Stok</td>
			<td valign="top">:</td>
			<td valign="top"><input type="numeric" id="stok" name="stok" size="50" maxlength="100" 
			placeholder="Masukkan Stok (numeric)" required autofocus value="<?php echo $stok; ?>"></td>
			<td valign="top"><span class="error">*<?php if(!empty($error_stok)) echo $error_stok; ?></span></td>
		</tr>
		<tr>
			<td valign="top">Harga</td>
			<td valign="top">:</td>
			<td valign="top"><input type="numeric" id="harga" name="harga" size="50" maxlength="100" 
			placeholder="Masukkan Harga (numeric)" required autofocus value="<?php echo $harga; ?>"></td>
			<td valign="top"><span class="error">*<?php if(!empty($error_harga)) echo $error_harga; ?></span></td>
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