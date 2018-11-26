<?php
ob_start();
include ("classDB.php");
include ("classSession.php");
include ("menuadmin.php");
$obj = new DB;
$obj->linktoDB();

$ses = new Sess;
$ses->start();
?>
<html>
<head>
<title></title>
<link rel="stylesheet" href="style.css" type="text/css" />	
<script src="jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="menu.js" type="text/javascript"></script>

<script language="javascript">
function konfadd(){
	var kategori = document.form.file.value;
	var judul = document.form.judul.value;
	
	if(confirm("Anda akan menambahkan banner?")){
		if(kategori == "" || judul == "" ){
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
					 <tr><td>Pilih gambar :</td><td><input type='file' id='file' name='file'><br><small> panjang 262px, tinggi 100px;</small><br></td></tr>
					 <tr><td>Judul :</td><td><input type='text' id='judul' name='judul' size='60'></td></tr>
					 <tr><td>Tampilkan :</td><td><select name='tampil'><option>Ya</option><option>Tidak</option></select></td></tr>
					 <tr><td></td><td><input type='hidden' name='action' value='add'>
					 <input type='submit' name='submit' value='Simpan' onclick='return konfadd();'> <input type='button' class='tutup' value='Tutup'></a></td></tr>
					 </table>
					 </form>
					 </div>
					 </div>
					 <div class='wrap'><table class='transtab' width='100%'>
					 <tr><td colspan='10'><form method='POST' action='".$_SERVER['PHP_SELF']."'><input type='text' name='cari' value='".$_REQUEST['cari']."' size='40'><input type='submit' name='submit' value='Cari'><input type='button' class='indata' value='Masukkan data'></form></td></tr>
					 <tr><th>Image</th><th width='52%'>Caption</th><th width='5%'>Tampil</th><th width='15%'>Aksi</th></tr>";			 
	
	//----------------config paging------------------
	$limit =15;
	
	if(isset($_GET['page'])){
		$noPage = $_GET['page'];
	}else{ 
		$noPage = 1;
	}	 
	
	$offset = ($noPage - 1) * $limit;
	//--------------- end config paging----------------	
	
	$sql = "select * from banner where caption like '".$_REQUEST['cari']."%' order by display asc limit ".$offset.", ".$limit.""; 	
	//die($sql);
	//proses menampilkan sebuah data
	foreach  ($obj->viewdata($sql) as $res){	
		$view.="<tr><td><img src='".$res[1]."' height='100px'></td><td><h3>".$res[2]."</h3><br><small>".$res[4]."</small></td><td>".$res[3]."</td>
					 <td><a href='promobann.php?action=del&bann=".$res[0]."&img=".$res[1]."&page=".$noPage."&cari=".$_REQUEST['cari']."' onclick='return konfdel()'><img src='material/del.png' alt='Hapus'></a>
					 <a href='promobann.php?action=edit&bann=".$res[0]."&img=".$res[1]."&page=".$noPage."&cari=".$_REQUEST['cari']."'><img src='material/edit.png' alt='Edit'></a>
					</td></tr>";
	}
			
	//------------------------- tampilkan deretan halaman------------------------
	$view .="</table></div><div class='paging'>";
	// mencari jumlah semua data dalam tabel  
	$sql  = "select count(*)  from banner where caption like '".$_REQUEST['cari']."%' ";
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
	
	//upload image
	if(!empty($_FILES['file']['tmp_name'])){
		$lokasi = 'banner/'.$_POST['judul'].".gif"; //lokasi sekaligus rename file
		move_uploaded_file($_FILES['file']['tmp_name'], $lokasi) 
			or die ('Gagal upload');
	}else{
		$lokasi = "";
	}
	
	$sql = "insert banner values('', '".$lokasi."', '".$_POST['judul']."', '".$_POST['tampil']."', '".date('Y-m-d H:i:s')."', '".$ses->readSess('username')."')";
	//die($sql);
	$obj->run($sql);
	
	header("location:promobann.php");
}elseif($aksi == "del"){
	if(!empty($_GET['img'])){
		unlink($_GET['img']);
	}
	
	$sql = "delete from banner where idbann = '".$_GET['bann']."'";
	$obj->run($sql);
	
	//kembalikan ke tampilan supplier
	header("location:promobann.php?cari=".$_GET['cari']."&page=".$_GET['page']."");
	
}elseif ($aksi == "edit"){

	$sql = "select * from banner where idbann = '".$_GET['bann']."'";
	$res = $obj->viewonedata($sql);
	
	$view = "<div class='editdata'>
					<div class='wrap'>
					<table>
					<form method='POST' enctype='multipart/form-data' action='".$_SERVER['PHP_SELF']."'>
					 <tr><td>Propinsi :</td><td><input type='text' name='kategori' size='70' value='".$res[0]."'></td></tr>
					<tr><td></td><td><input type='hidden' name='tkategori' value='".$res[0]."'>
													<input type='hidden' name='action' value='update'>
													<input type='hidden' name='page' value='".$_GET['page']."'>
													<input type='hidden' name='cari' value='".$_GET['cari']."'>
					 <input type='submit' name='submit' value='Update' onclick='return konfupdate();'> <input type='button' value='Batal' onclick='window.history.back()'></td></tr>
					 </table>
					 </form>
					 </div>";

}elseif($aksi == "update"){
		
	$sql = "update kategori set 
				kategori = '".$_POST['kategori']."'
				where kategori='".$_POST['tkategori']."'";
	
	$obj->run($sql);
	header("location:kategori.php?cari=".$_POST['cari']."&page=".$_POST['page']."");	
}

print $view;
ob_flush();
?>
</body>
</html>