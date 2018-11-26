<?php
ob_start();
include ("classDB.php");
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
	var id = document.penjualan.idtransaksi.value;
	var pelanggan = document.penjualan.pelanggan.value;
	var telp = document.penjualan.telp.value;
	var alamat = document.penjualan.alamat.value;
	
	if(confirm("Anda akan menambahkan transaksi " + id +"?")){
		if(pelanggan == "" || telp == "" || alamat == ""){
			alert("Maaf, lengkapi data anda");
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
	var status = document.form.status.value;
	var resi = document.form.resi.value;
	
	if (status == "Kirim"){
		if(resi == ""){
			alert("Harap isi nomer resi! \n jika tidak ada anda boleh memasukan angka nol");
			return false;
		}else{
			if(confirm("Update data?\nAnda akan memotong stok barang setelah melakukan update")){
				return true;
			}			
			return false;	
		}
	}else{
		if(confirm("Update data?")){
			return true;
		}		
		return false;	
	}			
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
	include ("menuadmin.php");
	
	//delete penjualan yang tidak ada pada detail
	$sql = "delete From jual Where idjual not in (Select idjual from djual)";
	$obj->run($sql);
	
	//buat nomer transaksi
	$res = $obj->viewonedata("select * from jual where length(idjual) = 8 order by idjual desc");
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
					<form method='GET' id='penjualan' name='penjualan' enctype='multipart/form-data' action='".$_SERVER['PHP_SELF']."'>
					 <tr><td>No. Transaksi :</td><td><input type='text' id='idtransaksi' name='idtransaksi' value=".$no."> Tgl : <input type='text' name='tgl' value='".date('Y-m-d')."' readonly></td></tr>
					 <tr><td>Pelanggan :</td><td><input type='text' id='pelanggan' name='pelanggan' size='20'>
					 Telp :<input type='text' id='telp'  name='telp'  size='30'></td></tr>
					 <tr><td valign='top'>Alamat :</td><td> <textarea id='alamat' name='alamat' rows='5' cols='50'></textarena></td></tr>
					 <tr><td></td><td><input type='hidden' name='action' value='addtrans'>
					 <input type='submit' name='submit' value='Lanjutkan transaksi penjualan' onclick='return konfadd();'> <input type='button' class='tutup' value='Tutup'></td></tr>
					 </table>
					 </form>
					 </div>
					 </div>
					 <div class='wrap'>
					 <table class='transtab' width='100%'>
					<tr><td colspan='12'><form method='POST' action='".$_SERVER['PHP_SELF']."'><input type='text' name='cari' value='".$_REQUEST['cari']."' size='40'><input type='submit' name='submit' value='Cari'><input type='button' class='indata' value='Masukkan data'></form></td></tr>										 
					 <tr><th>#Penjualan</th><th>Nama</th><th>Berat</th><th>Qty</th><th>Diskon</th><th>Jumlah</th><th>Status</th><th>Resi</th><th width='10px'></th></tr>";
	
	//----------------config paging------------------
	$limit =15;
	
	if(isset($_GET['page'])){
		$noPage = $_GET['page'];
	}else{ 
		$noPage = 1;
	}	 
	
	$offset = ($noPage - 1) * $limit;
	//--------------- end config paging----------------
	
	$sql = "select jual.idjual,jual.tgl, jual.nama, jual.telp, jual.alamat, sum(djual.berat), sum(djual.qty), 
			   sum(djual.diskon), sum(djual.jumlah), jual.status, jual.resi 
			   from jual join djual on jual.idjual = djual.idjual
			   where jual.idJual like '".$_REQUEST['cari']."%' or jual.nama like '".$_REQUEST['cari']."%'
			   group by jual.idjual order by jual.tgl, jual.idjual desc  limit ".$offset.", ".$limit."";			   
	$run = $obj->viewdata($sql);
	
	foreach($run as $res){		
		if($res[9] == "Kirim" || $res[9] == "Lunas"){
			$link="<a href='penjualan.php?action=lihat&page=".$noPage."&cari=".$_REQUEST['cari']."&id=".$res[0]."'><img src='material/search.gif' alt='Lihat'></a>";
		}else{
			$link = "<a href='penjualan.php?action=lihat&page=".$noPage."&cari=".$_REQUEST['cari']."&id=".$res[0]."'><img src='material/search.gif' alt='Lihat'></a>
						<a href='penjualan.php?action=edit&page=".$noPage."&cari=".$_REQUEST['cari']."&id=".$res[0]."'><img src='material/edit.png' alt='Edit'></a> 
						<a href='penjualan.php?action=del&page=".$noPage."&cari=".$_REQUEST['cari']."&id=".$res[0]."' onclick='return konfdel()'><img src='material/del.png' alt='Hapus'></a>";
		}
		
		$view .= "	<tr><td>".$res[0]."<br><i>".$res[1]."</i></td><td><b>".$res[2]."</b><br>".$res[3]."<br>".$res[4]."</td><td align='right'>".$res[5]."</td><td align='right'>".$res[6]."</td>
							  <td align='right'>".number_format($res[7])."</td><td align='right'>".number_format($res[8])."</td>
							  <td>".$res[9]."</td><td>".$res[10]."</td>
							  <td width='10%'>".$link."</td></tr>";					
	}	
	//------------------------- tampilkan deretan halaman------------------------
	$view .="</table></div><div class='paging'>";
	// mencari jumlah semua data dalam tabel  
	$sql = "select count(*)  from jual  where idJual like '".$_REQUEST['cari']."%' or nama like '".$_REQUEST['cari']."%'";
	
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
	
	$sql = "insert into jual (idjual, tgl, nama, alamat, telp, status, inputDt, username) values
				('".$_GET['idtransaksi']."','".$_GET['tgl']."', '".$_GET['pelanggan']."', '".$_GET['telp']."', '".$_GET['alamat']."', 'Lunas','".date('Y-m-d H:i:s')."', 'coba')";				
	//die($sql);
	$obj->run($sql);
	
	header("location:penjualan.php?action=adddetailtrans&idtransaksi=".$_GET['idtransaksi']."");
		
}elseif($aksi == "adddetailtrans"){	

	$sql = "select * from jual where idjual = ".$_GET['idtransaksi'];
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
						<tr><th><input type='text'  id='idbrg' name='idbrg' size='3' readonly><input type='button' name='cari' value='Cari' onclick=\"window.open('brgdatajual.php', 'Catalogue', 'width=500px, height=450px, scrollbars=yes')\"</th>
							   <th><input type='text' id='nama' name='nama' size='20' readonly></th><th><input type='hidden' id='berat' name='berat' size='5' readonly><input type='text' id='hberat' name='hberat' size='5' readonly></th>
							   <th><input type='text' id='hargabeli' name='hargabeli' size='3' onchange='hitung();'></th>
							   <th><input type='text' id='qty' name='qty' size='1' onchange='hitung();'></th><th><input type='text' id='diskon' name='diskon' size='3' onchange='hitung();'></th>
							   <th><input type='text' id='jumlah' name='jumlah' size='7' readonly></th><th><input type='hidden' name='action' value='insdjual'><input type='submit' name='submit' value='tambah'></th></tr>";
					
					$sql = "SELECT djual.idjual, djual.idbrg, barang.nama, djual.berat, djual.qty, djual.harga, djual.diskon, djual.jumlah
								FROM djual INNER JOIN barang 
								ON djual.idbrg = barang.idbrg
								where djual.idjual = ".$res[0];							
					$run = $obj->viewdata($sql);
					
					foreach( $run as $res){
						$view .= "<tr><td>".$res[1]."</td><td>".$res[2]."</td><td align='right	'>".$res[3]."</td>
											  <td align='right	'>".number_format($res[5])."</td><td align='right'>".number_format($res[4])."</td><td align='right	'>".number_format($res[6])."</td>
											  <td align='right	'>".number_format($res[7])." </td><td><a href='penjualan.php?action=deldjual&idtransaksi=".$res[0] ."&idbrg=".$res[1]."&qty=".$res[4]."' onclick='return konfdel();''><img src='material/del.png' alt='Hapus'></a></td>
									 </tr>";
									 
						$hitung += (int)$res[7];
						$berat += $res[3];
						$qty += (int)$res[4];
					}
					
						$view .= "<tr><td colspan='2'></td><td align='right'><h2>".ceil($berat)."</h2></td><td></td><td align='right'><h2>".$qty."</h2></td><td></td><td align='right'><h2>".number_format($hitung)."</h2></td></tr>
										</table>
					</td></tr>
					</table>
					 </form>
					 </div>
					 </div>";
			 
}elseif($aksi == "insdjual"){

	$sql = "insert into djual values ('".$_GET['idtransaksi']."',".$_GET['idbrg'].", ".$_GET['qty'].", ".$_GET['hargabeli'].", ".$_GET['hberat'].", ".$_GET['diskon'].", ".$_GET['jumlah'].")";					
	$obj->run($sql);
	
	$sql = "update barang set stok = stok - ".$_GET['qty']." where idbrg = ".$_GET['idbrg'];
	$obj->run($sql);	
	 
	header("location:penjualan.php?action=adddetailtrans&idtransaksi=".$_GET['idtransaksi']."");
	
}elseif($aksi == "deldjual"){

	$sql = "delete from djual  where idjual = ".$_GET['idtransaksi']." and idbrg =  ".$_GET['idbrg']." and qty =".$_GET['qty'];
	//die($sql);
	$obj->run($sql);
	header("location:penjualan.php?action=adddetailtrans&idtransaksi=".$_GET['idtransaksi']."");
	
}elseif ($aksi == "edit"){

	$sql = "select * from jual where idjual = '".$_GET['id']."'";
	$res = $obj->viewonedata($sql);
	//print_r($res);
	$view = "<div class='editdata'>
					<div class='wrap'>
					<table>
					<form method='POST' id='form' name='form' enctype='multipart/form-data' action='".$_SERVER['PHP_SELF']."'>
					 <tr><td>#Penjualan :</td><td><input type='text' name='id' size='50' value='".$res[0]."' readonly></td></tr>
					 <tr><td>Atas nama :</td><td><input type='text' name='nama' size='70' value='".$res[2]."'></td></tr>
					 <tr><td>Status :</td>
							<td><select id='status' name='status'>";
									$arr=array('Pending', 'Kirim', 'Batal');
									foreach($arr as $do){
										if ($do == $res[8]){
											$view.="<option value='".$do."' selected>".$do."</option>";
										}else{
											$view.="<option value='".$do."'>".$do."</option>";
										}
									}
							$view.="</select></td>
					</tr>
					 <tr><td>Resi :</td><td><input type='text' id='resi' name='resi' size='50' value='".$res[9]."'></tr>			 
					 <tr>
						<td></td>
						<td>
								<input type='hidden' name='id' value='".$_REQUEST['id']."'>
								<input type='hidden' name='page' value='".$_REQUEST['page']."'>
								<input type='hidden' name='cari' value='".$_REQUEST['cari']."'>
								<input type='hidden' name='action' value='update'>
								<input type='submit' name='submit' value='Update' onclick='return konfupdate();'><input type='button' name='batal' value='Batal' onclick='window.history.back()'>
						</td>
					</tr>
					 </table>
					 </form>
					 </div>
					 </div>";
			 
}elseif($aksi == "update"){

	$sql = "update jual set status = '".$_POST['status']."',  resi = '".$_POST['resi']."' where  idjual = '".$_POST['id']."'";
	$obj->run($sql);
	
	if ($_POST['status'] == "Kirim"){
		$sql = "select * from djual where idjual='".$_POST['id']."'";
		$res = $obj->viewdata($sql);
		foreach($res as $data){
			$sql = "update barang set stok=stok - ".$data[2]." where idbrg = ".$data[1];
			$obj->run($sql);
		}
	}

	header("location:penjualan.php?cari=".$_POST['cari']."&page=".$_POST['page']."");	
}elseif($aksi == "lihat"){	
	$view ="<div class='editcart'>
				 <div class='headwrap'>
					<div class='head-right'><span class='buttcart'><a href='#' onClick='window.history.back()'>Kembali</a></span>&nbsp;&nbsp;&nbsp;<span class='buttcart'><a href='#' onClick='window.print()'>Cetak bukti pesanan</a></span></div>
					<h1 class='judul'>Invoice</h1>";
				$sqljual = "select * from jual where idjual='".$_GET['id']."'";
				$resjual = $obj->viewonedata($sqljual);
				$view .="<table border='0' width='100%'>
							  <tr>
									<td><b>No transaksi</b><br>".$resjual[0]."</td>
							        <td><b>Nama</b><br>".$resjual[2]."</td>
									<td><b>Telp</b><br>".$resjual[4]."</td>
									<td colspan='2'><b>Alamat</b><br>".$resjual[3]."</td>
							  </tr>
							  <tr><td colspan='5'>&nbsp;</td></tr>
							  <tr>
									<td><b>Pembayaran melalui rekening</b><br>a/n Hendro purwoko <br> BCA 0970909789<br>BNI 876876786</td>
									<td><b>Total berat</b><br>".$resjual[5]."</td>
									<td><b>Biaya kirim</b><br>".number_format($resjual[6])."</td>
							        <td><b>Total Bayar</b><br>".number_format($resjual[6]+$resjual[7])."*</td>
									<td><b>Status pengiriman</b><br>".$resjual[8]."</td>
									<td></td>
							  </tr>							 
							  </table>
							  <br><br>
							  <table width='100%' class='tabcart'>
							  <tr>
									<th class='headth' width='30%'><b>Nama</b></th>
									<th class='headth' width='5%'><b>Berat</b></th>
									<th class='headth' width='5%'><b>Qty</b></th>
									<th class='headth' width='10%'><b>Harga</b></th>
									<th class='headth' width='10%'><b>Diskon</b></th>
									<th class='headth' width='10%'><b>Jumlah</b></th>
							  </tr>";
			
			$sqldjual = "SELECT djual.idjual, djual.idbrg, barang.nama, djual.berat, djual.qty, djual.harga, djual.diskon, djual.jumlah
								FROM djual INNER JOIN barang 
								ON djual.idbrg = barang.idbrg
								where djual.idjual = '".$_GET['id']."'";
			
			foreach($obj->viewdata($sqldjual) as $row){			
				$berat += $row[3];
				$qty += $row[4];
				$harga += $row[5];
				$diskon += $row[6];
				$jumlah += $row[7];				
				$view .="<tr>
									<td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td><td>".number_format($row[5])."</td><td>".number_format($row[6])."</td><td>".number_format($row[7])."</td>
							   </tr>";	
			}

	$view .="<tr><th class='buttth'>&nbsp;</th><th class='buttth'>".number_format($berat,1)."</th><th class='buttth'>".number_format($qty)."</th><th class='buttth'>&nbsp;</th><th class='buttth'>".number_format($diskon)."</th><th class='buttth'>".number_format($jumlah+$unik)."*</th></tr>
				</table>
				</div>
				</div>";			
			  
}elseif($aksi == "del"){
	$sql = "delete djual from jual join djual on jual.idjual = djual.idjual where jual.idjual='".$_GET['id']."'";
	//die($sql);
	$obj->run($sql);
	
	$sql = "delete from jual where jual.idjual='".$_GET['id']."'";
	$obj->run($sql);
	
	header("location:penjualan.php?cari=".$_GET['cari']."&page=".$_GET['page']."");	
}

print $view;
ob_flush();
?>
</body>
</html>