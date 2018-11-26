<?php
ob_start();
session_start();
include ("classDB.php");

$obj = new DB;
$obj->linktoDB();
?>
<html>
<head>
<title></title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
<?php
if(isset($_REQUEST['action'])){
	$aksi = $_REQUEST['action'];
}

if(empty($aksi)){
	$view = "<div class='menu'>
				<a href='barang.php'>Input barang</a> |
				<a href='lihatbarang.php'>Lihat barang</a>
			 </div>
			 <div class='kotak1'>
			 <table>";
			 
	$sql = "select * from barang order by idbrg desc"; //ambil data barang

	//proses menampilkan sebuah data
	foreach($obj->viewdata($sql) as $res){
		$view.="<tr><td><img src='".$res[5]."' width='200'></td>
					<td>".$res[1]."</td><td>".$res[2]."</td><td>".$res[4]."</td>
					<td>
				    <a href='lihat_barang.php?action=pilih&idbrg=".$res[0]."&nama=".$res[1]."&qty=1&harga=".$res[4]."'>Pilih</a>
					</td>
					</tr>";
	}
		$view .="</table></div>";
		
		//lihat barang yang dipilih disini
		$view .="<div>Produk :";
		
		//tampilkan isi chart
		foreach($_SESSION['barang'] as $brg){

		$view .="<br><b>".$brg['idbrg']." ".$brg['nama']."</b><br>".$brg['qty']."x".$brg['harga']." = ".($brg['qty']*$brg['harga'])."
		<br><a href='lihat_barang.php?action=delsess&idbrg=".$brg['idbrg']."'>Hapus<a/>";
		}
		
		$view .="</div>";
}elseif($aksi=="pilih"){

	//masukkan kedalam session
	$_SESSION['barang'][$_REQUEST['idbrg']] = array("idbrg"=>$_REQUEST['idbrg'],"nama"=>$_REQUEST['nama'],"qty"=>$_REQUEST['qty'],"harga"=>$_REQUEST['harga']);
	header("location:lihat_barang.php");
	
}elseif($aksi = "delsess"){

	unset($_SESSION['barang'][$_REQUEST['idbrg']]);
	header("location:lihat_barang.php");
	
}

print $view;
ob_flush();
?>
</body>
</html>