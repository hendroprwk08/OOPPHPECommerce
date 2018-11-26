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
	var telp = document.form.telp.value;
	var alamat = document.form.alamat.value;
	
	if(confirm("Anda akan menambahkan data supplier?")){
		if(nama == "" || telp == "" || alamat == ""){
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
					 <tr><td>Nama toko :</td><td><input type='text' id='nama' name='nama' size='70'></td></tr>
					 <tr><td>Telp : </td><td><input type='text' id='telp' name='telp'></td></tr>			 
					 <tr><td>Alamat : </td><td><input type='text' id='alamat' name='alamat' size='70'></td></tr>			 
					 <tr><td></td><td><input type='hidden' name='action' value='add'>
					 <input type='submit' name='submit' value='Simpan' onclick='return konfadd();'> <input type='button' class='tutup' value='Tutup'></a></td></tr>
					 </table>
					 </form>
					 </div>
					 </div>
					 <div class='wrap'><table class='transtab' width='100%'>
					 <tr><td colspan='10'><form method='POST' action='".$_SERVER['PHP_SELF']."'><input type='text' name='cari' value='".$_REQUEST['cari']."' size='40'><input type='submit' name='submit' value='Cari'><input type='button' class='indata' value='Masukkan data'></form></td></tr>
					 <tr><th>Nama lengkap</th><th>Telp</th><th width='150'>Alamat</th><th>Input</th><th>Oleh</th><th>Aksi</th></tr>";			 
			
	//----------------config paging------------------
	$limit =15;
	
	if(isset($_GET['page'])){
		$noPage = $_GET['page'];
	}else{ 
		$noPage = 1;
	}	 
	
	$offset = ($noPage - 1) * $limit;
	//--------------- end config paging----------------
	
	$sql = "select * from supplier where toko like '".$_REQUEST['cari']."%' order by toko asc  limit ".$offset.", ".$limit.""; 	

	//proses menampilkan sebuah data
	foreach  ($obj->viewdata($sql) as $res){	
		$view.="<tr><td>".$res[0]."</td><td>".$res[1]."</td><td>".$res[2]."</td><td>".$res[3]."</td><td>".$res[4]."</td>
					 <td><a href='supplier.php?action=del&toko=".$res[0]."&page=".$noPage."&cari=".$_REQUEST['cari']."' onclick='return konfdel()'><img src='material/del.png' alt='Hapus'></a>
					 <a href='supplier.php?action=edit&toko=".$res[0]."&page=".$noPage."&cari=".$_REQUEST['cari']."'><img src='material/edit.png' alt='Edit'></a>
					</td></tr>";
	}
		
	//------------------------- tampilkan deretan halaman------------------------
	$view .="</table></div><div class='paging'>";
	// mencari jumlah semua data dalam tabel  
	$sql  = "select count(*)  from supplier where toko like '".$_REQUEST['cari']."%'";
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
	//--------------------------- akhir tampilan halaman-------------------------------
}elseif($aksi == "add"){
	
	$sql = "insert into supplier values('".$_POST['nama']."',  '".$_POST['telp']."',	 
														 '".$_POST['alamat']."', '".date('Y-m-d')."', 'coba')";
	//die($sql);
	$obj->run($sql);
	
	header("location:supplier.php");
}elseif($aksi == "del"){
	$sql = "delete from supplier where toko = '".$_GET['toko']."'";
	//die($sql);
	$obj->run($sql);
	
	//kembalikan ke tampilan supplier
	header("location:supplier.php?cari=".$_POST['cari']."&page=".$_POST['page']."");
	
}elseif ($aksi == "edit"){

	$sql = "select * from supplier where toko = '".$_GET['toko']."'";
	$res = $obj->viewonedata($sql);
	
	$view = "<div class='editdata'>
					<div class='wrap'>
					<table>
					<form method='POST' enctype='multipart/form-data' action='".$_SERVER['PHP_SELF']."'>
					 <tr><td>Nama toko :</td><td><input type='text' name='nama' size='70' value='".$res[0]."' readonly></td></tr>
					 <tr><td>Telp : </td><td><input type='text' name='telp' value='".$res[1]."'></td></tr>			 
					 <tr><td>Alamat : </td><td><input type='text' name='alamat' size='70' value='".$res[2]."'></td></tr>			 
					 <tr><td></td><td><input type='hidden' name='action' value='update'>
													<input type='hidden' name='page' value='".$_GET['page']."'>
													<input type='hidden' name='cari' value='".$_GET['cari']."'>
					 <input type='submit' name='submit' value='Update' onclick='return konfupdate();'> <input type='button' value='Batal' onclick='window.history.back()'></td></tr>
					 </table>
					 </form>
					 </div>";

}elseif($aksi == "update"){
		
	$sql = "update supplier set 
				toko = '".$_POST['nama']."',
				telp = '".$_POST['telp']."',
				alamat = '".$_POST['alamat']."',
				inputDt = '".date('Y-m-d')."',
				username = 'coba'				
				where toko='".$_POST['nama']."'";
	
	$obj->run($sql);
	header("location:supplier.php?cari=".$_POST['cari']."&page=".$_POST['page']."");	
}

print $view;
ob_flush();
?>
</body>
</html>