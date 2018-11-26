<?php
session_start();
include("classDB.php");
include("menuadmin.php");

$obj = new DB;
$obj->linktoDB();
?>
<html>
<head>
<title></title>
<link rel="stylesheet" href="style.css" type="text/css" />	
<script src="jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="menu.js" type="text/javascript"></script>
<body>
<?php
$view .= "<div class='wrap'>	
					<div class='inleft'>
						<h1 class='judullain'>Transaksi pending</h1>
					<table class='laptab' width='100%'>
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
								$view.="</select>
								<input type='submit' name='submit' value='Cari'><input type='button' value='Print' onclick='window.print();'>
						</form>
					</td></tr>										 
					 <tr><th>#Penjualan</th><th>Nama</th><th>Diskon</th><th>Jumlah</th></tr>";	
	
	if(!empty($_REQUEST['bln']) and !empty($_REQUEST['thn'])){
		$sql = "select jual.idjual,jual.tgl, jual.nama, jual.telp, jual.alamat, sum(djual.berat), sum(djual.qty), 
				   sum(djual.diskon), sum(djual.jumlah), jual.status, jual.resi 
				   from jual join djual on jual.idjual = djual.idjual
				   where date_format(jual.tgl, '%Y')= '".$_POST['thn']."' and date_format(jual.tgl, '%m')= '".$_POST['bln']."' and jual.status ='Pending'
				   group by jual.status, jual.idjual order by jual.inputdt, jual.idjual desc";		
	}elseif(!empty($_REQUEST['thn'])){	
		$sql = "select jual.idjual,jual.tgl, jual.nama, jual.telp, jual.alamat, sum(djual.berat), sum(djual.qty), 
				   sum(djual.diskon), sum(djual.jumlah), jual.status, jual.resi 
				   from jual join djual on jual.idjual = djual.idjual
				   where date_format(jual.tgl, '%Y')= '".$_POST['thn']."' and jual.status ='Pending'
				   group by jual.status, jual.idjual order by jual.inputdt, jual.idjual desc";		
	}else{
		$sql = "select jual.idjual,jual.tgl, jual.nama, jual.telp, jual.alamat, sum(djual.berat), sum(djual.qty), 
				   sum(djual.diskon), sum(djual.jumlah), jual.status, jual.resi 
				   from jual join djual on jual.idjual = djual.idjual
				   where jual.status ='Pending'
				   group by jual.status, jual.idjual order by jual.inputdt, jual.idjual desc";
	}
	
	//print_r($sql);		   
	$run = $obj->viewdata($sql);
	foreach($run as $res){
		$total += (int) $res[8];
		$num += 1;
		
		$view .= "	<tr><td><h3>".$res[0]."</h3><br><small>".$res[1]."</small></td><td><b>".$res[2]."</b><br>".$res[3]."<br>".$res[4]."</td>
							  <td align='right'>".number_format($res[7])."</td><td align='right'>".number_format($res[8])."</td></tr>";					
	}	
	
	$view .="<tr><td colspan='3'>Jumlah data : <b>".number_format($num)."</b></td><td align='right'><b>".number_format($total)."</b></td><td>&nbsp;</td><td>&nbsp;</td></tr></table>";
		
					$view.="</div>
					<div class='inright'>
						<h1 class='judullain'>Stok</h1>
						<table clas='laptab' width='100%'>";
						
						$sql = "select nama, stok from barang order by stok desc";
						foreach($obj->viewdata($sql) as $res){
							$view .="<tr><td>".$res[0]."</td><td>".$res[1]."</td></tr>";
						}
					$view.="</table></div>
			   </div>";
print $view;
?>
</body>
</html>
