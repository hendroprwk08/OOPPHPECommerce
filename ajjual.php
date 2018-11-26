<?php
session_start();
include("classDB.php");
include("classSession.php");
$obj = new DB;
$obj->linktoDB();

$ses = new Sess;
$ses->start();

$act = $_REQUEST['act'];

if ($act=="ipembeli"){
	$kota = split("-", $_POST['kota']);
	unset($_SESSION['pembeli']);
	$_SESSION['pembeli'] = array('nama'=>$_POST['nama'], 'telp'=>$_POST['telp'], 'alamat'=>$_POST['alamat'], 'kota'=>$kota[0], 'tarif' =>$kota[1]);
}elseif($act=="ibeli"){
	
}
print $view;
?>