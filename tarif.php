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
	var propinsi = document.form.propinsi.value;
	var kota = document.form.kota.value;
	var tarif = document.form.tarif.value;
	
	if(confirm("Anda akan menambahkan data tarif?")){
		if(propinsi == "" || kota == "" || tarif == ""){
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
	if(confirm("Update data?")){
		return true;
	}	
	return false;	
}

function cekharga(){
	var beli = document.getElementById('hargabeli').value;
	var hasil = (parseint(beli) + parseint(beli));
	alert(hasil);
	alert("kelewt");
	
	document.getElementById('hargajual').value = hasil;
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
					<form id='form' name='form' method='POST' enctype='multipart/form-data' action='".$_SERVER['PHP_SELF']."'>
					 <tr><td>Daerah :</td><td><input type='text' id='kota' name='kota' size='50'> Propinsi, kota</td></tr>
					 <tr><td>Tarif : </td><td><input type='text' id='tarif' name='tarif'></td></tr>			 
					 <tr><td></td><td><input type='hidden' name='action' value='add'>
					 <input type='submit' name='submit' value='Simpan' onclick='return konfadd();'> <input type='button' class='tutup' value='Tutup'></a></td></tr>
					 </table>
					 </form>
					 </div>
					 </div>
					 <div class='wrap'><table class='transtab' width='100%'>
					 <tr><td colspan='10'><form method='POST' action='".$_SERVER['PHP_SELF']."'><input type='text' name='cari' value='".$_REQUEST['cari']."' size='40'><input type='submit' name='submit' value='Cari'><input type='button' class='indata' value='Masukkan data'></form></td></tr>
					 <th>Kota</th><th width='10%'>Tarif</th><th width='10%'>Aksi</th></tr>";			 
	
	//----------------config paging------------------
	$limit =15;
	
	if(isset($_GET['page'])){
		$noPage = $_GET['page'];
	}else{ 
		$noPage = 1;
	}	 
	
	$offset = ($noPage - 1) * $limit;
	//--------------- end config paging----------------	
	
	$sql = "select * from tarif where kota like '".$_REQUEST['cari']."%' order by kota asc limit ".$offset.", ".$limit.""; 	
	//die($sql);
	//proses menampilkan sebuah data
	foreach  ($obj->viewdata($sql) as $res){	
		$view.="<tr><td>".$res[1]."</td><td>".$res[2]."</td>
					 <td><a href='tarif.php?action=del&idtarif=".$res[0]."&page=".$noPage."&cari=".$_REQUEST['cari']."' onclick='return konfdel()'><img src='material/del.png' alt='Hapus'></a>
					 <a href='tarif.php?action=edit&idtarif=".$res[0]."&page=".$noPage."&cari=".$_REQUEST['cari']."'><img src='material/edit.png' alt='Edit'></a>
					</td></tr>";
	}
			
	//------------------------- tampilkan deretan halaman------------------------
	$view .="</table></div><div class='paging'>";
	// mencari jumlah semua data dalam tabel  
	$sql  = "select count(*)  from tarif where  kota like '".$_REQUEST['cari']."%' ";
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
	
}elseif($aksi == "add"){
	
	$sql = "insert into tarif values('',  '".$_POST['kota']."',  '".$_POST['tarif']."',	'".date('Y-m-d')."')";
	//die($sql);
	$obj->run($sql);
	
	header("location:tarif.php");
}elseif($aksi == "del"){
	$sql = "delete from tarif where idtarif = ".$_GET['idtarif'];
	$obj->run($sql);
	
	//kembalikan ke tampilan supplier
	header("location:tarif.php?cari=".$_GET['cari']."&page=".$_GET['page']."");
	
}elseif ($aksi == "edit"){

	$sql = "select * from tarif where idtarif = '".$_GET['idtarif']."'";
	$res = $obj->viewonedata($sql);
	
	$view = "<div class='editdata'>
					<div class='wrap'>
					<table>
					<form method='POST' enctype='multipart/form-data' action='".$_SERVER['PHP_SELF']."'>
					 <tr><td>Kota : </td><td><input type='text' name='kota' value='".$res[1]."'></td></tr>			 
					 <tr><td>Tarif : </td><td><input type='text' name='tarif' size='70' value='".$res[2]."'></td></tr>			 
					 <tr><td></td><td><input type='hidden' name='idtarif' value='".$res[0]."'>
													<input type='hidden' name='action' value='update'>
													<input type='hidden' name='page' value='".$_GET['page']."'>
													<input type='hidden' name='cari' value='".$_GET['cari']."'>
					 <input type='submit' name='submit' value='Update' onclick='return konfupdate();'> <input type='button' value='Batal' onclick='window.history.back()'></td></tr>
					 </table>
					 </form>
					 </div>";

}elseif($aksi == "update"){
		
	$sql = "update tarif set 
				kota = '".$_POST['kota']."',
				tarif = '".$_POST['tarif']."'	
				where idtarif='".$_POST['idtarif']."'";
	
	$obj->run($sql);
	header("location:tarif.php?cari=".$_POST['cari']."&page=".$_POST['page']."");	
}

print $view;
ob_flush();
?>
</body>
</html>