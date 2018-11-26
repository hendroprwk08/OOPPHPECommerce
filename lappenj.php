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
</head>
<body>
<?php
if(isset($_REQUEST['action'])){
$aksi = $_REQUEST['action'];
}

if(empty($aksi)){
	include ("menuadmin.php");
	
	$view .= "<div class='wrap'>
					<h1 class='judullain'>Laporan Penjualan</h1>
					<table class='laptab' width='100%' border='0'>
					<tr>
					<td colspan='12'>
						<form method='POST' action='".$_SERVER['PHP_SELF']."'>
								<select name='thn'>";
								for($i =2010; $i<=(int)date('Y'); $i++){
									if($i == $_REQUEST['thn']){
										$view .="<option value='".$i."' selected>".$i."</option>";
									}else{
										$view .="<option value='".$i."'>".$i."</option>";
									}
								}	
								$view .="</select>&nbsp;&nbsp;<select name='bln'><option value=''></option>";
								for($i =1; $i<=12; $i++){
									if($i == $_REQUEST['bln']){
										$view .="<option value='".sprintf('%02s',$i)."' selected>".sprintf('%02s',$i)."</option>";
									}else{
										$view .="<option value='".sprintf('%02s',$i)."'>".sprintf('%02s',$i)."</option>";
									}
								}	
								$view.="</select>&nbsp;&nbsp;<select name='status'><option value=''></option>";
								$arr= array('Pending', 'Batal', 'Kirim');
								foreach($arr as $i){
									if($i == $_REQUEST['status']){
										$view .="<option value='".$i."' selected>".$i."</option>";
									}else{
										$view .="<option value='".$i."'>".$i."</option>";
									}
								}	
								$view.="</select>
								<input type='submit' name='submit' value='Cari'><input type='button' value='Print' onclick='window.print();'>
						</form>
					</td></tr>										 
					 <tr><th>#Penjualan</th><th>Nama</th><th>Berat</th><th>Qty</th><th>Diskon</th><th>Jumlah</th><th>Status</th><th>Resi</th></tr>";	
	
	if(empty($_REQUEST['bln']) and empty($_REQUEST['status'])){
		$sql = "select jual.idjual,jual.tgl, jual.nama, jual.telp, jual.alamat, sum(djual.berat), sum(djual.qty), 
				   sum(djual.diskon), sum(djual.jumlah), jual.status, jual.resi 
				   from jual join djual on jual.idjual = djual.idjual
				   where date_format(jual.tgl, '%Y')= '".$_POST['thn']."'
				   group by jual.status, jual.idjual order by jual.tgl, jual.idjual desc";		
	}elseif(isset($_REQUEST['bln']) and empty($_REQUEST['status'])){
		$sql = "select jual.idjual,jual.tgl, jual.nama, jual.telp, jual.alamat, sum(djual.berat), sum(djual.qty), 
				   sum(djual.diskon), sum(djual.jumlah), jual.status, jual.resi 
				   from jual join djual on jual.idjual = djual.idjual
				   where date_format(jual.tgl, '%Y')= '".$_POST['thn']."' and date_format(jual.tgl, '%m')= '".$_POST['bln']."'
				   group by jual.status, jual.idjual order by jual.tgl, jual.idjual desc";
	}elseif(empty($_REQUEST['bln']) and isset($_REQUEST['status'])){
		$sql = "select jual.idjual,jual.tgl, jual.nama, jual.telp, jual.alamat, sum(djual.berat), sum(djual.qty), 
					   sum(djual.diskon), sum(djual.jumlah), jual.status, jual.resi 
					   from jual join djual on jual.idjual = djual.idjual
					   where date_format(jual.tgl, '%Y')= '".$_POST['thn']."' and jual.status = '".$_POST['status']."'
					   group by jual.status, jual.idjual order by jual.tgl, jual.idjual desc";
	}else{
		$sql = "select jual.idjual,jual.tgl, jual.nama, jual.telp, jual.alamat, sum(djual.berat), sum(djual.qty), 
				   sum(djual.diskon), sum(djual.jumlah), jual.status, jual.resi 
				   from jual join djual on jual.idjual = djual.idjual
				   where date_format(jual.tgl, '%Y')= '".$_POST['thn']."' and date_format(jual.tgl, '%m')= '".$_POST['bln']."' and jual.status = '".$_POST['status']."'
				   group by jual.status, jual.idjual order by jual.tgl, jual.idjual desc";
	}
	
	//print_r($sql);		   
	$run = $obj->viewdata($sql);
	foreach($run as $res){
		$total += (int) $res[8];
		$num += 1;
		if($res[9] == "Pending"){
			$p += 1;
		}elseif($res[9] == "Kirim"){
			$k += 1;
		}elseif($res[9] == "Batal"){
			$b += 1;
		}
		
		$view .= "	<tr><td>".$res[0]."<br><i>".$res[1]."</i></td><td><b>".$res[2]."</b><br>".$res[3]."<br>".$res[4]."</td><td align='right'>".$res[5]."</td><td align='right'>".$res[6]."</td>
							  <td align='right'>".number_format($res[7])."</td><td align='right'>".number_format($res[8])."</td>
							  <td>".$res[9]."</td><td>".$res[10]."&nbsp;</td></tr>";					
	}	
	
	$view .="<tr><td colspan='5'>Kirim : <b>".number_format($k)."</b> | Pending: <b>".number_format($p)."</b> | Batal: <b>".number_format($b)."</b> | Jumlah data : <b>".number_format($num)."</b></td><td align='right'><b>".number_format($total)."</b></td><td>&nbsp;</td><td>&nbsp;</td></tr></table>";
	
}
print $view;
ob_flush();
?>
</body>
</html>