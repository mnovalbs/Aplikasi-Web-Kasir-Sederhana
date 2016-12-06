<?php
	require_once('../db_login.php');
	$db =  new mysqli($db_host,$db_username,$db_password,$db_database);

	if($db->connect_errno){
		die ("could not connect to the database : <br/>". $db->connect_error);
	}
	if(isset($_POST["submit"])){
		$idtransaksi = $db->real_escape_string($idtransaksi);
		$jumlah = $db->real_escape_string($jumlah);
		$idbarang = $db->real_escape_string($idbarang);
		
		$hargabarang = "SELECT harga FROM barang WHERE idbarang='$idbarang'";
		$harga = $hargabarang * $jumlah;

		$query = "INSERT INTO detail_transaksi (idtransaksi,idbarang,jumlah,harga) VALUES ('$idtransaksi','$idbarang','$jumlah','$harga')";

		$result = $db->query($query);
		if (!$result){
			die("could not query the database: <br />".$db->error);
		}else {
			echo 'detail ditambahkan<br /><br />';
			echo '<br /><a href="view_detail_transaksi.php">Kembali</a>';
			$db->close();
			exit;
		}
	}
?>

<html>
	<head>
	</head>
	<body>
		<center><h2>USER INPUT</h2></center>
		<form method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<table>
			<tr>
				<td valign="top">idtransaksi</td>
				<td valign="top">:</td>
				<td valign="top"><input type="number" name="idtransaksi" size="10" maxlength="10" placeholder="idtransaksi" autofocus value="<?php echo $idtransaksi;?>"></td>
			</tr>
			<tr>
				<td valign="top">barang</td>
				<td valign="top">:</td>
				<td valign="top">
					<select name="city" required>
						<option value="none" <?php if (!isset($city)) echo 'selected="true"';?>>--Select a city--</option>
						<?php
							$querykat = "select * from barang";
							$resultkat = $db->query($querykat);
							if(!$resultkat){
								die("Could not connect to the database : <br/>". $db->connect_error);
							}
							while ($row = $resultkat->fetch_object()){ 
								$id = $row->idbarang; 
								$name = $row->nama; 
								echo '<option value='.$id.' '; 
								if(isset($idbarang) && $idbarang==$id)
								echo 'selected="true"';
								echo '>'.$name.'<br/></option>';
							} 
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td valign="top">jumlah</td>
				<td valign="top">:</td>
				<td valign="top"><input type="number" name="jumlah" size="10" maxlength="10" placeholder="jumlah" autofocus value="<?php echo $jumlah;?>"></td>
			</tr>
			<tr>
				<td valign="top" colspan="3"><br><input type="submit" name="submit" value="Submit"></td>
				<td valign="top"><a href="view_detail_transaksi.php">Kembali</a></td>
			</tr>
		</table>
		</form>
	</body>
</html>
<?php
	$db->close();
?>
