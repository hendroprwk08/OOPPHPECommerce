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
					<h1 class='judullain'>Laporan Pembelian</h1>
					<table class='laptab' width='100%' border='0'>
					<tr>
					<td colspan='10'>
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
					
								$view.="</select>
								<input type='submit' name='submit' value='Cari'><input type='button' value='Print' onclick='window.print();'>
						</form>
					</td></tr>										 
					 <tr><th>#Penjualan</th><th>Nama</th><th>Berat</th><th>Qty</th><th>Diskon</th><th>Jumlah</th></tr>";	
		
	if(empty($_REQUEST['bln']) and empty($_REQUEST['status'])){
		$sql = "select beli.idBeli,beli.tgl, beli.toko, beli.telp, beli.alamat, sum(dbeli.berat), sum(dbeli.qty), 
					sum(dbeli.diskon), sum(dbeli.jumlah) from beli join dbeli on beli.idbeli = dbeli.idbeli			   
					where date_format(beli.tgl, '%Y')= '".$_POST['thn']."'
				   group by beli.idbeli, beli.toko order by beli.tgl, beli.idbeli desc";		
	}elseif(isset($_REQUEST['bln']) and empty($_REQUEST['status'])){
		$sql = "select beli.idBeli,beli.tgl, beli.toko, beli.telp, beli.alamat, sum(dbeli.berat), sum(dbeli.qty), 
					sum(dbeli.diskon), sum(dbeli.jumlah) from beli join dbeli on beli.idbeli = dbeli.idbeli			   
					where date_format(beli.tgl, '%Y')= '".$_POST['thn']."' and date_format(beli.tgl, '%m')= '".$_POST['bln']."'
				    group by beli.idbeli, beli.toko order by beli.tgl, beli.idbeli desc";		
	}else{
		$sql = "select beli.idBeli,beli.tgl, beli.toko, beli.telp, beli.alamat, sum(dbeli.berat), sum(dbeli.qty), 
					sum(dbeli.diskon), sum(dbeli.jumlah) from beli join dbeli on beli.idbeli = dbeli.idbeli			   
					where date_format(beli.tgl, '%Y')= '".$_POST['thn']."' and date_format(beli.tgl, '%m')= '".$_POST['bln']."'
				    group by beli.idbeli, beli.toko order by beli.tgl, beli.idbeli desc";		
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

		$view .= "<tr><td>".$res[0]."<br><i>".$res[1]."</i></td><td><b>".$res[2]."</b><br>".$res[3]."<br>".$res[4]."</td><td align='right'>".$res[5]."</td><td align='right'>".$res[6]."</td>
						 <td align='right'>".number_format($res[7])."</td><td align='right'>".number_format($res[8])."&nbsp;</td></tr>";					
	}	
	
	$view .="<tr><td colspan='5'>Jumlah data : <b>".number_format($num)."</b></td><td align='right'><b>".number_format($total)."</b></td></tr></table>";
	
}
print $view;
ob_flush();
?>
</body>
</html>