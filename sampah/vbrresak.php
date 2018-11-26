<?php
include "classDB.php";	
$limit = 4;
$sql = "select * from barang order by idbrg desc limit 0, 4 ";

$obj = new DB;
$obj->linktoDB();
	
foreach($obj->viewdata($sql) as $res){
	$harga = (int)$res[5]-(int)$res[6];
	if(!empty($res[6]) or $res[6] == ""){
		$view .="<div class='cartwrap'>
				<form action='".$_SERVER['PHP_SELF']."' method='POST'>
				<img src='".$res[1]."' height='230px' width='200px'>
				<br><b>".$res[2]."</b><br><small><i>".$res[3]."</i></small>
				<br><small><s>Rp. ".number_format($res[5])."</s></small>
				<br><font color='red' size='2px'><b>Rp. ".number_format($harga)."</b></font>
				<br><small>Hemat : Rp.".number_format($res[6])."</small><br><br>
				<input type='hidden' name='action' value='addcart'>
				<input type='hidden' name='brg' value='".$res[0]."'>
				<input type='submit' name='submit' value='Beli'>				
				</form>
				 </div>";	
	}else{	
		$view .="<div class='cartwrap'>
				<form action='".$_SERVER['PHP_SELF']."' method='POST'>
				<img src='".$res[1]."' height='230px' width='200px'>
				<br><b>".$res[2]."</b><br><small><i>".$res[3]."</i></small>
				<br><font color='red' size='2px'><b>Rp. ".number_format($harga)."</b></font><br><br>
				<input type='hidden' name='action' value='addcart'>
				<input type='hidden' name='brg' value='".$res[0]."'>
				<input type='submit' name='submit' value='Beli'>				
				</form>
				 </div>";		
	}

}

print $view;
?>