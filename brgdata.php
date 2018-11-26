<?php
ob_start();
include ("classDb.php");
$obj = new DB;
$obj->linktoDB();
?>
<html>
<head>
<title></title>
<link rel="stylesheet" href="style.css" type="text/css" />	
<script language="javascript">
function pilih( idbrg, nama, berat){
	window.opener.document.pembelian.idbrg.value = idbrg;
	window.opener.document.pembelian.nama.value = nama;
	window.opener.document.pembelian.berat.value = berat;
	window.opener.document.pembelian.hberat.value = berat;
	window.close();
}
</script>
</head>
<body>
<?php
	$view .= "<table class='tablist' width='100%'>";			 
			
			$sql = "select * from barang order by nama asc"; 	
			
			//proses menampilkan sebuah data
			foreach  ($obj->viewdata($sql) as $res){	
				$view.="<tr>
								<td width='25%'><img src='".$res[1]."' height='80px'></td>
								<td><h3>".$res[2]."</h3><br><small>Stok = <b>".$res[10]."</b>&nbsp;&nbsp;&nbsp;Berat = <b>".$res[11]."</b><br>".$res[7]."</small><br></td>
								<td width='12%'><a href='#' class='currpage' onclick=\"return pilih('".$res[0]."', '".$res[2]."', '".$res[11]."')\">Pilih</a></td>
							</tr>";
			}
			
			$view .="</table>";
print $view;
ob_flush();
?>
</body>
</html>