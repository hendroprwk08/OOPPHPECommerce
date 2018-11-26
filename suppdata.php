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
function pilih( toko, telp, alamat)
{
	window.opener.document.pembelian.toko.value = toko;
	window.opener.document.pembelian.telp.value = telp;
	window.opener.document.pembelian.alamat.value = alamat;
	window.close();
}
</script>
</head>
<body>
<?php
	$view .= "<table class='tablist' width='100%'>";			 
			
			$sql = "select * from supplier order by toko asc"; 	
			
			//proses menampilkan sebuah data
			foreach  ($obj->viewdata($sql) as $res){	
				$view.="<tr>
								<td>&nbsp;&nbsp;<b>".$res[0]."</b></td>
								<td>".$res[1]."</td><td>".$res[2]."</td>
								<td width='12%'><a href='#' class='currpage' onclick=\"return pilih('".$res[0]."', '".$res[1]."', '".$res[2]."')\">Pilih</a></td>
							</tr>";
			}
			
			$view .="</table>";
print $view;
ob_flush();
?>
</body>
</html>