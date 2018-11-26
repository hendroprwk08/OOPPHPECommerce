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
	var nama = document.form.nama.value;
	var gambar = document.form.gambar.value;
	var kategori = document.form.kategori.value;
	var deskripsi = document.form.deskripsi.value;
	var hargabeli = document.form.hargabeli.value;
	var hargajual = document.form.hargajual.value;
	var diskon = document.form.diskon.value;
	var berat = document.form.berat.value;
	
	if(confirm("Anda akan menambahkan data barang?")){
		if(nama == "" || gambar == "" || kategori == "" || deskripsi == "" || hargabeli == "" || hargajual == "" || diskon == "" || berat == ""
		   || hargabeli == "0" || hargajual == "0" || berat == "0"){
			alert("Maaf, lengkapi data anda dan angka pada bagian angka");
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

function valnum(id) {       
	var number = parseInt(id.value);
	if(isNaN(number)) {  
		alert('Masukkan angka');
		id.focus();	
		return false;  
     }else{  
		 return true;  
    } 
} 

function konfupdate(){
	if(confirm("Update data?")){
		return true;
	}	
	return false;	
}
</script>
</head>

<body>
<?php
if(isset($_REQUEST['action'])){
$aksi = $_REQUEST['action'];
}

if(empty($aksi)){
	$view .= "<div class='insdata'>
					<div class='wrap'>
					<table>
					<form method='POST' id='form' name='form' enctype='multipart/form-data' action='".$_SERVER['PHP_SELF']."'>
					 <tr><td>Produk :</td><td><input type='text' id='nama' name='nama' size='70'></td></tr>
					 <tr><td>Gambar : </td><td><input type='file' id='gambar' name='gambar'></td></tr>			 
					 <tr><td>Kategori : </td><td><select id='kategori' name='kategori'>";
									$sql = "select * from kategori order by kategori asc";
									$res = $obj->viewdata($sql) ;
									foreach($res as $opsi){
										$view.="<option value='".$opsi[0]."'>".$opsi[0]."</option>";
									}
								$view.="</select></td></tr>
					 <tr><td>Harga beli :</td><td> <input type='text' id='hargabeli' name='hargabeli' onchange='return valnum(this)' size='10'>
					 Harga jual :<input type='text' id='hargajual' name='hargajual'  onchange='return  valnum(this)' size='10'>
					 Diskon :<input type='text' id='diskon' name='diskon' onchange='return valnum(this)' size='3'><small> %</small></td></tr>
					 <tr><td valign='top'>Deskripsi :</td><td> <textarea id='deskripsi' name='deskripsi' rows='10' cols='60'></textarea></td></tr>
					 <tr><td valign='top'>Keyword :</td><td> <input type='text' id='keyword' name='keyword' size='70'></td></tr>
					 <tr><td></td><td><small><b>Contoh :</b> sony earphone murah, MDR E9LP sony, promo earphone, originalearphone.com</small><br></td></tr>					 
					 <tr><td>Berat :</td><td><input type='text' id='berat' name='berat' onchange='return valnum(this)' size='9'><small>/Kg</small></td><tr>					 
					 <tr><td>Id youtube video :</td><td><input type='text' id='youtube' name='youtube' size='30'></td></tr>
					 <tr><td></td><td><small><b>Contoh :</b><br>http://www.youtube.com/watch?v=<b>sCncPi4xpXc</b><br>yang anda masukkan hanya <b>sCncPi4xpXc</b></small><br></td></tr>					 
					 <tr><td>Status :</td><td><select  id='status' name='status'>
																						<option></option>
																						<option>Promo</option>
																						<option>Produk unggulan</option>
																						<option>Produk terlaris</option>
																						<option>Produk termurah</option>
																				</select></td></tr>
					 <tr><td></td><td><input type='hidden' name='action' value='add'>
					 <input type='submit' name='submit' value='Simpan' onclick='return konfadd();'> <input type='button' class='tutup' value='Tutup'></a></td></tr>
					 </table>
					 </form>
					 </div>
					 </div>
					 <div class='wrap'><table class='transtab' width='100%'>
					 <tr><td colspan='10'><form method='POST' action='".$_SERVER['PHP_SELF']."'><input type='text' name='cari' value='".$_REQUEST['cari']."' size='40'><input type='submit' name='submit' value='Cari'><input type='button' class='indata' value='Masukkan data'></form></td></tr>
					 <tr><th>Nama</th><th width='18%'>Harga</th><th>Deskripsi</th><th width='11%'>Aksi</th></tr>";			 
	//----------------config paging------------------
	$limit =15;
	
	if(isset($_GET['page'])){
		$noPage = $_GET['page'];
	}else{ 
		$noPage = 1;
	}	 
	
	$offset = ($noPage - 1) * $limit;
	//--------------- end config paging----------------
	
	//cek pencarian
	$sql = "select * from barang where nama like '".$_REQUEST['cari']."%' order by idbrg desc limit ".$offset.", ".$limit.""; 	
	
	//proses menampilkan sebuah data
	foreach  ($obj->viewdata($sql) as $res){	
		$view.="<tr><td><img src='".$res[1]."' height='120px'><br><b>".$res[2]."</b><br><small><i>".$res[3]."</i></small><br>Berat : ".$res[11]." Kg<br>Stok : <b>".number_format($res[10])."</b></td>
					<td id='orange'>B :".number_format($res[4])."<br>J : ".number_format($res[5])."<br>D : ".number_format($res[6])." % <br>( Rp. ".number_format(($res[5]*$res[6])/100 )." )<br>H : <b>".number_format($res[5] -($res[5]*$res[6])/100 )."</b></td>
					<td><small>".nl2br($res[7])."<br><br><b>Youtube id :</b> ".$res[12]."<br><br><b>keyword : </b>".$res[13]." <br><br><b>Status : </b>".$res[14]."</small></td>
					<td><a href='barang.php?action=del&idbrg=".$res[0]."&img=".$res[1]."&page=".$noPage."&cari=".$_REQUEST['cari']."' onclick='return konfdel()'><img src='material/del.png' alt='Hapus'></a>
					<a href='barang.php?action=edit&idbrg=".$res[0]."&page=".$noPage."&cari=".$_REQUEST['cari']."'><img src='material/edit.png' alt='Edit'></a>
					</td></tr>";
	}
	
	$view .="</table></div>";
	//------------------------- tampilkan deretan halaman------------------------
	$view .="<div class='paging'>";
	// mencari jumlah semua data dalam tabel  
	$sql  = "select count(*)  from barang where nama like '".$_REQUEST['cari']."%' ";
	$res=$obj->viewonedata($sql); 
	$jumData = $res[0];
	 //	die($jumData);
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
	//--------------------------- akhir tampilan halaman-------------------------------
}elseif($aksi == "add"){
	//cek gambar lhoo
	if($_FILES['gambar']['size'] == 0){
		$dir = "";
	}else{
		if($_FILES['gambar']['size'] > 150000 || $_FILES['gambar']['type'] != 'image/jpeg'){
		   $view="Ukuran max 100 KByte dan berformat *.jpg. <br>Silahkan ubah ukuran gambar anda terlebih dahulu";
		   die($view);
		}
		if($_FILES['gambar']['error'] > 0){
		   $view="Maaf file tidak bisa di upload.
				  <b>Pesan : </b>".$_FILES['gambar']['error'];
		}else{
			//sebelum upload buat folder image terlebih dahulu
			$dir="image/". $_FILES['gambar']['name']; //rename nama file
			move_uploaded_file($_FILES['gambar']['tmp_name'], $dir);
		}
	}
	$sql = "insert into barang values('','".$dir."', '".$_POST['nama']."', '".$_POST['kategori']."',
																 ".$_POST['hargabeli'].",  ".$_POST['hargajual'].",
																 ".$_POST['diskon'].",	 '".$_POST['deskripsi']."', 
																 '".date('Y-m-d')."', 'coba', '', ".$_POST['berat'].", '".$_POST['youtube']."', '".$_POST['keyword']."')";
	//die($sql);
	$obj->run($sql);
	
	header("location:barang.php");
}elseif($aksi == "del"){
	//proses delete file gambar
	if ($_GET['img'] <> ""){
		unlink($_GET['img']);
	}
	
	$sql = "delete from barang where idbrg = ".$_GET['idbrg'];
	$obj->run($sql);
	
	//kembalikan ke tampilan barang
	header("location:barang.php?cari=".$_GET['cari']."&page=".$_GET['page']."");
	
}elseif ($aksi == "edit"){

	$sql = "select * from barang where idbrg = ".$_GET['idbrg'];
	$res = $obj->viewonedata($sql);
	
	$view = "<div class='editdata'>
					<div class='wrap'>
					<table>
					<form method='POST' enctype='multipart/form-data' action='".$_SERVER['PHP_SELF']."'>
					 <tr><td>Produk :</td><td><input type='text' name='nama' size='70' value='".$res[2]."'></td></tr>
					 <tr><td valign='top'><br>Gambar : </td><td><input type='file' name='gambar'><br><img src='".$res[1]."' height='200px'></td></tr>			 
					 <tr><td>Kategori : </td><td><select name='kategori'>";
					 
					$sql = "select * from kategori order by kategori asc";	
					$res1 = $obj->viewdata($sql);
					
					foreach($res1 as $opsi){
						if($opsi[0] == $res[3]){
							$view .= "<option value='".$opsi[0]."' selected>".$opsi[0]."</option>";
						}else{
							$view .= "<option value='".$opsi[0]."'>".$opsi[0]."</option>";
						}
					}	
					
					$view .= "</select></td></tr>
					 <tr><td>Harga beli :</td><td> <input type='text' id='hargabeli' name='hargabeli'  value='".$res[4]."' onkeydown='return cekharga();' size='10'>
					 Harga jual :<input type='text' id='hargajual' name='hargajual'  size='10' value='".$res[5]."'>
					 Diskon :<input type='text' name='diskon' size='3' value='".$res[6]."'><small> %</small></td></tr>
					 <tr><td valign='top'>Deskripsi :</td><td> <textarea name='deskripsi' ' rows='10' cols='60'>".$res[7]."</textarea></td></tr>
					 <tr><td valign='top'>Keyword :</td><td> <input type='text' id='keyword' name='keyword' size='70' value='".$res[13]."'></td></tr>
					 <tr><td></td><td><small><b>Contoh :</b> sony earphone murah, MDR E9LP sony, promo earphone, originalearphone.com</small><br></td></tr>					 					 
					 <tr><td>Berat :</td><td><input type='text' name='berat' size='5' value='".$res[11]."'><small>/Kg</small></td></tr>					 					 
					 <tr><td>Id youtube video :</td><td><input type='text' id='youtube' name='youtube' size='30' value='".$res[12]."'></td></tr>
					 <tr><td></td><td><small><b>Contoh</b><br>http://www.youtube.com/watch?v=<b>sCncPi4xpXc</b><br>yang anda masukkan hanya <b>sCncPi4xpXc</b></small><br></td></tr>					 
					 <tr><td>Status :</td><td><select  id='status' name='status'>";
								$arr = array('', 'Promo', 'Produk unggulan', 'Produk terlaris', 'Produk termurah');
								
								foreach($arr as $opt){
									print_r($opt);
									if($opt == $res[14]){
										$view .= "<option value='".$opt."' selected>".$opt."</option>"; 
									}else{
										$view .= "<option value='".$opt."'>".$opt."</option>";
									}
								}
										
					$view .="</select></td></tr>					 
					 <tr><td></td><td><input type='hidden' name='idbrg' value='".$res[0]."'><input type='hidden' name='tempimage' value='".$res[1]."'>
					 <input type='hidden' name='action' value='update'>
													<input type='hidden' name='page' value='".$_GET['page']."'>
													<input type='hidden' name='cari' value='".$_GET['cari']."'>
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
				deskripsi = '".$_POST['deskripsi']."',
				inputDt = '".date('Y-m-d')."',
				username = 'coba',
				berat = ".$_POST['berat'].",
				youtube = '".$_POST['youtube']."',
				keyword = '".$_POST['keyword']."',
				status = '".$_POST['status']."'
				where idbrg=".$_POST['idbrg'];
	
		$obj->run($sql);
		
		//kembalikan ke tampilan barang
		header("location:barang.php?cari=".$_POST['cari']."&page=".$_POST['page']."");
	
	}else{

	$sql = "update barang set 
				imageBrg = '".$_POST['tempimage']."',
				nama = '".$_POST['nama']."',
				kategori = '".$_POST['kategori']."',
				hrgbeli = ".$_POST['hargabeli'].",
				hrgjual = ".$_POST['hargajual'].",
				diskon = ".$_POST['diskon'].",
				deskripsi = '".$_POST['deskripsi']."',
				inputDt = '".date('Y-m-d')."',
				username = 'coba',
				berat = ".$_POST['berat'].",
				youtube = '".$_POST['youtube']."',
				keyword = '".$_POST['keyword']."',
				status = '".$_POST['status']."'
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