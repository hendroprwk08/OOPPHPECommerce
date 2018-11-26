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
<script language="javascript">
$(document).ready(function(){
	$(".insdata").hide();
	$(".menulaporan").hide();
	
	$("#lap").click(function(){
		$(".menulaporan").fadeToggle();
	});
	
	$(".menulaporan").blur(function(){
		$(this).fadeOut();
	});
	
	$(".indata").click(function(){
		$(".insdata").fadeIn("slow");
	});
	
	$(".tutup").click(function(){
		$(".insdata").fadeOut("slow");
	});
});
</script>

<script language="javascript">
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
					 <tr><td>Username :</td><td><input type='text' id='username' name='username' size='70'></td></tr>
					 <tr><td>Password : </td><td><input type='password' id='password' name='password'></td></tr>			 
					 <tr><td>Kategori : </td><td><select id='kategori' name='kategori'>
									<option>Admin</option>
									<option>User</option>									
								</select></td></tr>
					 <tr><td>Nama lengkap :</td><td><input type='text' id='nama' name='nama' size='70'></td></tr>
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
					 <tr><th>Nama</th><th>Kategori</th><th>Nama lengkap</th><th>Telp</th><th>Alamat</th><th>Input</th><th>Oleh</th><th>Aksi</th></tr>";			 
			
	//----------------config paging------------------
	$limit =15;
	
	if(isset($_GET['page'])){
		$noPage = $_GET['page'];
	}else{ 
		$noPage = 1;
	}	 
	
	$offset = ($noPage - 1) * $limit;
	//--------------- end config paging----------------
	
	$sql = "select * from username where username like '".$_REQUEST['cari']."%' order by username desc"; 	
	
	//proses menampilkan sebuah data
	foreach  ($obj->viewdata($sql) as $res){	
		$view.="<tr><td>".$res[0]."</td><td>".$res[2]."</td><td>".$res[3]."</td><td>".$res[4]."</td>
					<td>".$res[5]."</td><td>".$res[6]."</td><td>".$res[7]."</td>
					 <td><a href='user.php?action=del&username=".$res[0]."&page=".$noPage."&cari=".$_REQUEST['cari']."' onclick='return konfdel()'><img src='material/del.png' alt='Hapus'></a>
					 <a href='user.php?action=edit&username=".$res[0]."&page=".$noPage."&cari=".$_REQUEST['cari']."'><img src='material/edit.png' alt='Edit'></a>
					</td></tr>";
	}
	
	$view .="</table></div>";
	//------------------------- tampilkan deretan halaman------------------------
	$view .="<div class='paging'>";
	// mencari jumlah semua data dalam tabel  
	$sql  = "select count(*)  from username where username like '".$_REQUEST['cari']."%'  ";
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
}elseif($aksi == "add"){
	
	$sql = "insert into username values('".$_POST['username']."', '".md5($_POST['password'])."',
														 '".$_POST['kategori']."',  '".$_POST['nama']."',  '".$_POST['telp']."',	 
														 '".$_POST['alamat']."', '".date('Y-m-d')."', 'coba')";
	//die($sql);
	$obj->run($sql);
	
	header("location:user.php");
}elseif($aksi == "del"){
	$sql = "delete from username where username = '".$_GET['username']."'";
	//die($sql);
	$obj->run($sql);
	
	//kembalikan ke tampilan barang
	header("location:user.php?page=".$_REQUEST['page']."&cari=".$_REQUEST['cari']."");
	
}elseif ($aksi == "edit"){

	$sql = "select * from username where username = '".$_GET['username']."'";
	$res = $obj->viewonedata($sql);
	
	$view = "<div class='editdata'>
					<div class='wrap'>
					<table>
					<form method='POST' enctype='multipart/form-data' action='".$_SERVER['PHP_SELF']."'>
					 <tr><td>Username :</td><td><input type='text' name='username' size='70' value='".$res[0]."' readonly></td></tr>
					 <tr><td>Password : </td><td><input type='password' name='password'></td></tr>			 
					 <tr><td>Kategori : </td><td><select name='kategori'>";
								$list = array("Admin", "User");
								
								foreach($list as $opsi){
									if($opsi == $res[2]) {
										$view .= "<option selected>".$opsi."</option>";
									}else{
										$view .= "<option>".$opsi."</option>";
									}
									
								}
								
								$view .="</select></td></tr>
					 <tr><td>Nama lengkap :</td><td><input type='text' name='nama' size='70' value='".$res[3]."'></td></tr>
					 <tr><td>Telp : </td><td><input type='text' name='telp' value='".$res[4]."'></td></tr>			 
					 <tr><td>Alamat : </td><td><input type='text' name='alamat' size='70' value='".$res[5]."'></td></tr>			 
					 <tr><td></td><td><input type='hidden' name='temppassword' value='".$res[1]."'><input type='hidden' name='action' value='update'>
					 								<input type='hidden' name='page' value='".$_GET['page']."'>
													<input type='hidden' name='cari' value='".$_GET['cari']."'>
					 <input type='submit' name='submit' value='Update' onclick='return konfupdate();'> <input type='button' value='Batal' onclick='window.history.back()'></td></tr>
					 </table>
					 </form>
					 </div>";

}elseif($aksi == "update"){

	//cek apakah upload gambar baru?
	if(!empty($_POST['password'])){
		$pass = md5($_POST['password']);
	}else{
		$pass = temppassword;
	}
	 	
	$sql = "update username set 
				username = '".$_POST['username']."',
				password = '".$pass."',
				kategori = '".$_POST['kategori']."',
				namalengkap = '".$_POST['nama']."',
				telp = '".$_POST['telp']."',
				alamat = '".$_POST['alamat']."',
				inputDt = '".date('Y-m-d')."',
				username = 'coba'				
				where username='".$_POST['username']."'";
	$obj->run($sql);
	header("location:user.php?page=".$_POST['page']."&cari=".$_POST['cari']."");	

}
print $view;
ob_flush();
?>
</body>
</html>