<?php
ob_start();
include ("classDB.php");
include ("classSession.php");

$obj = new DB;
$obj->linktoDB();

$ses = new Sess;
$ses->start();
?>
<html>
<head>
<title></title>
<link rel="stylesheet" href="style.css" type="text/css" />	
<script language="javascript">
</script>
</head>

<body>
<?php
if(!empty($_REQUEST['action'])){
	$aksi = $_REQUEST['action'];
}else{
	$aksi = "";
}

if($aksi == "login"){
	$sql = "select * from username where username = '".$_POST['username']."' and password = '".md5($_POST['password'])."'";
	$res = $obj->viewonedata($sql);
	
	print_r($res);
	
	if (!empty($res[0]) and !empty($res[1])){
		$ses->setSess('username', $res[0]);
		$ses->setSess('password', $res[1]);
		$ses->setSess('kategori', $res[2]);
		$ses->setSess('nama', $res[3]);
		
		header("location:indexadmin.php");
	}else{
		$view = "<div class='warning'><h1>Maaf proses login gagal</h1><a href=''>silahkan melakukan login ulang</a></div>";
	}
	
}elseif(empty($aksi)){
	$view = "<div class='menuadmin'>
				<form action='".$_SERVER['PHP_SELF']."' method='POST'>
					Nama pengguna : <input type='text' name='username'>
					Password : <input type='password' name='password' autocomplete='off'>
					<input type='hidden' name='action' value='login'>
					<input type='submit' name='submit' value='Masuk'>
					<input type='reset' name='reset' value='Ulangi'>
				</form>
			 </div>";
}else{

}
print $view;
ob_flush();
?>
</body>
</html>