<?php
ob_start();
include ("classDB.php");
include ("menuadmin.php");
$obj = new DB;
$obj->linktoDB();
?>
<html>
<head>
<title></title>
<link rel="stylesheet" href="style.css" type="text/css" />	
<script src="jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="menu.js" type="text/javascript"></script>

<script language="javascript">
function konfadd(){
	var id = document.pembelian.idtransaksi.value;
	var toko = document.pembelian.toko.value;
	
	if(confirm("Anda akan menambahkan data "+id+" ?")){
		if(toko == ""){
			alert("Anda harus memilih supplier terlebih dahulu");
			return false;
		}else{
			return true;
		}
		
	}	
	return false;	
}

function konfdel(){
	if(confirm("Yakin akan dihapus?")){
		return true;
	}	
	return false;	
}

function konfupdate(){
	if(confirm("Update data?")){
		return true;
	}	
	return false;	
}

function hitung(){
	var beli = document.pembelian.hargabeli.value;
	var diskon = document.pembelian.diskon.value;	
	var qty = document.pembelian.qty.value;	
	var berat = document.pembelian.berat.value;	
	var hasil = (eval(qty) * eval(beli)) - eval(diskon) || "0";	
	
	if (diskon == "") diskon=0;
	document.pembelian.jumlah.value = hasil;

	/*hitung berat*/
	if(qty > 0 ){
		var hberat = (qty * berat ) || "0";
	/*	
		alert("masuk");
		alert(qty);
		alert(berat);
		alert(hberat.toFixed(1));
	*/
		document.pembelian.hberat.value = hberat.toFixed(1);
	}
}
</script>
<script type="text/javascript">
<!--
spe=500;
na=document.all.tags("blink");
swi=1;
bringBackBlinky();
function bringBackBlinky() {
if (swi == 1) {
sho="visible";
swi=0;
}
else {
sho="hidden";
swi=1;
}
for(i=0;i<na.length;i++) {
na[i].style.visibility=sho;
}
setTimeout("bringBackBlinky()", spe);
}
-->
</script>
</head>

<body>
<?php
if(isset($_REQUEST['action'])){
$aksi = $_REQUEST['action'];
}

if(empty($aksi)){
	//delete dpembelian yang tidak ada pada detail
	$sql = "Delete From beli Where idbeli not in (Select idbeli from dbeli)";
	$obj->run($sql);
	
	//buat nomer transaksi
	$res = $obj->viewonedata("select * from beli order by idbeli desc");

	//hitung
	if (empty($res)){
		$no = date(y)."".date(m)."0001";
	}else{
		$no = (int) substr($res[0],-4) + 1;
		$no = date(y)."".date(m)."".sprintf('%04s', $no);
	}
	
	$view .= "<div class='insdata'>
					<div class='wrap'>
					<table>
					<form method='GET' id='pembelian' name='pembelian' enctype='multipart/form-data' action='".$_SERVER['PHP_SELF']."'>
					 <tr><td>No. Transaksi :</td><td><input type='text' id='idtransaksi'  name='idtransaksi' value=".$no."> Tgl : <input type='date' name='tgl' value='".date('Y-m-d')."' readonly></td></tr>
					 <tr><td>Supplier :</td><td> <input type='text' id='toko' name='toko' size='20' readonly><input type='button' name='getsupp' value='Cari...'  onclick=\"window.open('suppdata.php', 'Catalogue', 'width=500px, height=450px, scrollbars=yes')\">
					 Telp :<input type='text' id='telp' name='telpsupp'  size='30' readonly></td></tr>
					 <tr><td valign='top'>Alamat :</td><td> <textarea id='alamat' name='alamat' rows='5' cols='50' readonly></textarea></td></tr>
					 <tr><td></td><td><input type='hidden' name='action' value='addtrans'>
					 <input type='submit' name='submit' value='Lanjutkan transaksi pembelian' onclick='return konfadd();'> <input type='button' class='tutup' value='Tutup'></td></tr>
					 </table>
					 </form>
					 </div>
					 </div>
					 <div class='wrap'>
					 <table class='transtab' width='100%'>
					<tr><td colspan='10'><form method='POST' action='".$_SERVER['PHP_SELF']."'><input type='text' name='cari' value='".$_REQUEST['cari']."' size='40'><input type='submit' name='submit' value='Cari'><input type='button' class='indata' value='Masukkan data'></form></td></tr>
					<tr><th>#Pembelian</th><th>Tgl</th><th>Nama</th><th>Telp</th><th>Alamat</th><th>Berat</th><th>Qty</th><th>Diskon</th><th>Jumlah</th></tr>";
	//----------------config paging------------------
	$limit =15;
	
	if(isset($_GET['page'])){
		$noPage = $_GET['page'];
	}else{ 
		$noPage = 1;
	}	 
	
	$offset = ($noPage - 1) * $limit;
	//--------------- end config paging----------------	
	
	$sql = "select beli.idBeli,beli.tgl, beli.toko, beli.telp, beli.alamat, sum(dbeli.berat), sum(dbeli.qty), 
			   sum(dbeli.diskon), sum(dbeli.jumlah) from beli join dbeli on beli.idbeli = dbeli.idbeli			   
			   where beli.idBeli like '".$_REQUEST['cari']."%' or beli.toko like '".$_REQUEST['cari']."%'
			   group by beli.idbeli 
			   order by beli.tgl desc  limit ".$offset.", ".$limit."";
			   
	$run = $obj->viewdata($sql);
	
	foreach($run as $res){
		$view .= "	<tr><td>".$res[0]."</td><td>".$res[1]."</td><td>".$res[2]."</td><td>".$res[3]."</td>
							  <td>".$res[4]."</td><td align='right'>".$res[5]."</td><td align='right'>".$res[6]."</td>
							  <td align='right'>".number_format($res[7])."</td><td align='right'>".number_format($res[8])."</td></tr>";					
	}	
	
	//------------------------- tampilkan deretan halaman------------------------
	$view .="</table></div><div class='paging'>";
	// mencari jumlah semua data dalam tabel  
	$sql = "select count(*)  from beli  where idBeli like '".$_REQUEST['cari']."%' or toko like '".$_REQUEST['cari']."%'";
	$res=$obj->viewonedata($sql); 
	$jumData = $res[0];
	 
	 // menentukan jumlah halaman yang muncul berdasarkan jumlah semua data	 
	$jumPage = ceil($jumData/$limit);
	 // menampilkan link previous	 
	if ($noPage > 1) 
		$view .= "<a href='".$_SERVER['PHP_SELF']."?page=".($noPage-1)."&cari=".$_REQUEST['cari']."'  class='page'>&lt;&lt; Prev</a>";
	
	// memunculkan nomor halaman dan linknya	 
	for($page = 1; $page <= $jumPage; $page++)
	{
			 if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage)){
				//if (($showPage == 1) && ($page != 2))  
				//		$view .= "...";
				
				//if (($showPage != ($jumPage - 1)) && ($page == $jumPage))  
				//		$view .= "...";
						
				if ($page == $noPage) 
						$view .= " <b class='currpage'>".$page."</b> ";
				
			}else{ 
				//$view .= " <a href='".$_SERVER['PHP_SELF']."?page=".$page."' class='buttcart'>".$page."</a> ";
				//$showPage = $page;
			 }
	}
	 
	// menampilkan link next	 
	if ($noPage < $jumPage) 
		$view .= "<a href='".$_SERVER['PHP_SELF']."?page=".($noPage+1)."&cari=".$_REQUEST['cari']."' class='page'>Next &gt;&gt;</a>";
	
	$view.=" Data : <b class='currpage'>".$jumData."</b>";
	//--------------------------- akhir tampilan halaman -------------------------------
			 
}elseif($aksi == "addtrans"){
	
	$sql = "insert into beli (idbeli, tgl, toko, telp, alamat, inputDt, username) values
				('".$_GET['idtransaksi']."','".$_GET['tgl']."', '".$_GET['toko']."', '".$_GET['telpsupp']."', '".$_GET['alamat']."', '".date('Y-m-d')."', 'coba')";				
	$obj->run($sql);
	
	header("location:pembelian.php?action=adddetailtrans&idtransaksi=".$_GET['idtransaksi']."");
		
}elseif($aksi == "adddetailtrans"){	

	$sql = "select * from beli where idbeli = ".$_GET['idtransaksi'];
	$res = $obj->viewonedata($sql);
	
	$view .= "<div>
					<div class='wrap'>
					<table>
					<form method='GET' id='pembelian' name='pembelian' enctype='multipart/form-data' action='".$_SERVER['PHP_SELF']."'>
					 <tr><td>No. Transaksi :</td><td><input type='text' name='idtransaksi' value='".$res[0]."' readonly> Tgl : <input type='text' name='tgl' value='".$res[1]."' readonly></td></tr>
					 <tr><td>Supplier :</td><td> <input type='text' id='toko' name='toko' size='20' value='".$res[2]."' readonly>
					 Telp :<input type='text' id='telp' name='telpsupp'  size='30' value='".$res[3]."' readonly></td></tr>
					 <tr><td valign='top'>Alamat :</td><td> <textarea id='alamat' name='alamat' rows='5' cols='50' readonly>".$res[4]."</textarea>
																					<p><a href='penjualan.php' class='currpage'>Selesai transaksi</a></p></td></tr>					 					
					<tr><td colspan='2'>
						<table class='transtab'>									
						<tr><th>Id Barang</th><th>Nama</th><th>Berat</th><th>Harga</th><th>Qty</th><th>Diskon</th><th>Jumlah</th><th></th></tr>
						<tr><th><input type='text'  id='idbrg' name='idbrg' size='3' readonly><input type='button' name='cari' value='Cari' onclick=\"window.open('brgdata.php', 'Catalogue', 'width=500px, height=450px, scrollbars=yes')\"</th>
							   <th><input type='text' id='nama' name='nama' size='20' readonly></th><th><input type='hidden' id='berat' name='berat' size='5' readonly><input type='text' id='hberat' name='hberat' size='5' readonly></th><th><input type='text' id=\"hargabeli\" name=\"hargabeli\" size='3' onchange=\"hitung();\"></th>
							   <th><input type='text' id=\"qty\" name=\"qty\" size='1' onchange=\"hitung();\"></th><th><input type='text' id=\"diskon\" name=\"diskon\" size='3' onchange=\"hitung();\"></th>
							   <th><input type='text' id='jumlah' name='jumlah' size='7' readonly></th><th><input type='hidden' name='action' value='insdbeli'><input type='submit' name='submit' value='tambah'></th></tr>";
					
					$sql = "SELECT dbeli.idbeli, dbeli.idbrg, barang.nama, dbeli.berat, dbeli.qty, dbeli.harga, dbeli.diskon, dbeli.jumlah
								FROM dbeli INNER JOIN barang 
								ON dbeli.idbrg = barang.idbrg
								where dbeli.idbeli = ".$res[0];						
								
					$run = $obj->viewdata($sql);
					
					foreach( $run as $res){
						$view .= "<tr><td>".$res[1]."</td><td>".$res[2]."</td><td align='right'>".$res[3]."</td>
											  <td align='right'>".number_format($res[5])."</td><td align='right'>".number_format($res[4])."</td><td align='right'>".number_format($res[6])."</td>
											  <td align='right'>".number_format($res[7])." </td><td><a href='pembelian.php?action=deldbeli&idtransaksi=".$res[0] ."&idbrg=".$res[1]."&qty=".$res[4]."'  onclick='return konfdel();''><img src='material/del.png' alt='Hapus'></a></td>
									 </tr>";
									 
						$hitung += (int)$res[7];
						$berat += $res[3];
						$qty += (int)$res[4];
					}
					
						$view .= "<tr><td colspan='2'></td><td><h2 align='right'>".ceil($berat)."</h2></td><td></td><td align='right'><h2>".number_format($qty)."</h2></td><td align='right'><h2>".number_format($diskon)."</h2></td><td align='right'><h2>".number_format($hitung)."</h2></td></tr>
										</table>
					</td></tr>
					</table>
					 </form>
					 </div>
					 </div>";
			 
}elseif($aksi == "insdbeli"){

	$sql = "insert into dbeli values ('".$_GET['idtransaksi']."',".$_GET['idbrg'].", ".$_GET['qty'].", ".$_GET['hargabeli'].", ".$_GET['hberat'].", ".$_GET['diskon'].", ".$_GET['jumlah'].")";					
	//die($sql);
	$obj->run($sql);
	
	$sql = "update barang set stok = stok + ".$_GET['qty']." where idbrg = ".$_GET['idbrg'];
	$obj->run($sql);	
	
	header("location:pembelian.php?action=adddetailtrans&idtransaksi=".$_GET['idtransaksi']."");
	
}elseif($aksi == "deldbeli"){

	$sql = "delete from dbeli  where idbeli = ".$_GET['idtransaksi']." and idbrg =  ".$_GET['idbrg']." and qty =".$_GET['qty'];
	//die($sql);
	$obj->run($sql);
	header("location:pembelian.php?action=adddetailtrans&idtransaksi=".$_GET['idtransaksi']."");
	
}elseif($aksi == "del"){
	//proses delete file gambar
	if ($_GET['img'] <> ""){
		unlink($_GET['img']);
	}
	
	$sql = "delete from barang where idbrg = ".$_GET['idbrg'];
	$obj->run($sql);
	
	//kembalikan ke tampilan barang
	header("location:barang.php");
	
}elseif ($aksi == "edit"){

	$sql = "select * from barang where idbrg = ".$_GET['idbrg'];
	$res = $obj->viewonedata($sql);
	
	$view = "<div class='editdata'>
					<div class='wrap'>
					<table>
					<form method='POST' enctype='multipart/form-data' action='".$_SERVER['PHP_SELF']."'>
					 <tr><td>Produk :</td><td><input type='text' name='nama' size='70' value='".$res[2]."'></td></tr>
					 <tr><td valign='top'><br	>Gambar : </td><td><input type='file' name='gambar'><br><img src='".$res[1]."'</td></tr>			 
					 <tr><td>Kategori : </td><td><select name='kategori'>";
					 
					$list = array("T shirt  lengan pendek", "T shirt lengan panjang", "POLO shirt", "Jeans");

					foreach($list as $opsi){	
						if($opsi == $res[3]){
							$view .= "<option selected>".$opsi."</option>";
						}else{
							$view .= "<option>".$opsi."</option>";
						}
					}	
					
					$view .= "</select></td></tr>
					 <tr><td>Harga beli :</td><td> <input type='text' id='hargabeli' name='hargabeli'  value=".$res[4]." onkeydown='return cekharga();' size='10'>
					 Harga jual :<input type='text' id='hargajual' name='hargajual'  size='10' value=".$res[5].">
					 Diskon :<small>Rp.</small><input type='text' name='diskon' size='9' value=".$res[6]."></td></tr>
					 <tr><td valign='top'>Deskripsi :</td><td> <textarea name='deskripsi' rows='20' cols='80'>".$res[7]."</textarea></td></tr>
					 <tr><td></td><td><input type='hidden' name='idbrg' value='".$res[0]."'><input type='hidden' name='tempimage' value='".$res[1]."'>
					 <input type='hidden' name='action' value='update'>
					 <input type='submit' name='submit' value='Update' onclick='return konfupdate();'><input type='button' name='batal' value='Batal' onclick='window.history.back()'></td></tr>
					 </table>
					 </form>
					 </div>
					 </div>";
			 
}elseif($aksi == "update"){

	//cek apakah upload gambar baru?
	if(!empty($_FILES['gambar']['tmp_name'])){
	
		//buang gambar yang lama(kalau ada)
		if(!empty($_POST['tempimage'])){
			unlink ($_POST['tempimage']);
		}
		
		//proses upload
		if($_FILES['gambar']['size'] > 150000 ||
		   $_FILES['gambar']['type'] != 'image/jpeg'){
		   $view="Ukuran max 10 KByte dan berformat *.jpg";
		   die($view);
		}
		
		//sebelum upload buat folder image terlebih dahulu
		$dir = "image/". $_POST['nama'].".jpg";
		move_uploaded_file($_FILES['gambar']['tmp_name'], $dir);
		
		$sql = "update barang set 
				imageBrg = '".$dir."',
				nama = '".$_POST['nama']."',
				kategori = '".$_POST['kategori']."',
				hrgbeli = ".$_POST['hargabeli'].",
				hrgjual = ".$_POST['hargajual'].",
				diskon = ".$_POST['diskon'].",
				deskripsi = ".$_POST['deskripsi'].",
				inputDt = '".date('Y-m-d')."',
				username = 'coba'				
				where idbrg=".$_POST['idbrg'];
	
		$obj->run($sql);
		
		//kembalikan ke tampilan barang
		header("location:barang.php");
	
	}else{

	$sql = "update barang set 
				imageBrg = '".$_POST['tempimage']."',
				nama = '".$_POST['nama']."',
				kategori = '".$_POST['kategori']."',
				hrgbeli = ".$_POST['hargabeli'].",
				hrgjual = ".$_POST['hargajual'].",
				diskon = ".$_POST['diskon'].",
				deskripsi = ".$_POST['deskripsi'].",
				inputDt = '".date('Y-m-d')."',
				username = 'coba'				
				where idbrg=".$_POST['idbrg'];
					
		$obj->run($sql);	
	}
	header("location:barang.php");	

}

print $view;
ob_flush();
?>
</body>
</html>