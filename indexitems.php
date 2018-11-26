<?php
ob_start();
include("classDB.php");
include("classSession.php");
include("youtube.php");

$ses = new Sess();
$ses->start();

$obj = new DB;
$obj->linktoDB();
?>
<html>
<head>
<meta content="index follow" name="robots"/>
<meta name='description' content='Earphone original merek sony paling murah dengan kualitas terbaik di kelasnya ada di http://originalearphone.com'/>
<meta name='keywords' content='sony original earphone,  headphone asli, earphone untuk iphone, ipod, ipad, nokia, samsung dan android, 
															 running sports  pc headset' />
<link rel="icon" 
      type="image/png" 
      href="logoico.png">
<title>hero | original earphone</title>
<link rel="stylesheet" href="style.css" type="text/css" />
<script src="jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="jquery-number.js" type="text/javascript"></script>
<script language="javascript">
$(document).ready(function(){		
	//lihat konfirms
	$("#lihat").click(function(){
		var total = $("#tot").text();
		
		if (total=="0"){
			alert("Anda belum melakukan transaksi");
			return false;
		}
		
		return true;
	});	
});
</script>
<body>
<div id="fb-root"></div>
<!-- Facebook comment  --->
<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/id_ID/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- end of Facebook comment  --->
<!-- Google analiytcs --->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-42389353-1', 'originalearphone.com');
ga('send', 'pageview');
</script>
<!--- end of google analytics --->
<?php
if(!empty($_REQUEST['action'] )){
	$aksi = $_REQUEST['action'];
}else{
	$aksi = "";
}

if(empty($aksi)){
	if($ses->readsess('username') != ""){
		$st = "<span class='buttlogin'><a href='supplier.php'>Halaman admin</a></span>";
	}else{
		$st = "";
	}
	
	$view .="<div class='heading'>
					<div class='headwrap'>
					<div class='head-left'>".$st."</div>
					<div class='head-right'><b>Jumlah</b> : ";
					//jumlah barang dan total
					$arrres = $ses->readSess('jual');
					$jumlah=0; $qty=0; $total=0; 
					if (!empty($arrres)){
						foreach($ses->readSess('jual') as $row){
							//print_r($row);	
							$qty += $row['qty']; 
							$jumlah = ((int)$row['hrg'] * (int)$row['qty'])-((int)$row['diskon'] * (int)$row['qty']);
							$total += (int)$jumlah;						
						}
					}				
					$view .= number_format($qty)." item, Total <span id='tot'>".number_format($total)."</span> | <a href='index.php?action=editcart' id='lihat'>Lihat cart</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							 <span class='buttlogin'><a href='login.php'>Login</a></span></div>		
			</div>
			</div>
			<div class='wrap'>				
				<div class='headindex'>				
					<a href='index.php'><img src='material/logo.png'></a><br>
					<b><font size='4'>Original earphone</font></b>
				</div>
				<div class='menu'><ul><li><a href='indexitems.php'>ALL SERIES</a></li>";
					$sql = "select distinct kategori from barang";
					$opt = $obj->viewdata($sql);
					
					foreach($opt as $data){
						//$tampil = str_replace('SERIES','', $data[0]);
						//$view.="<li><a href='indexitems.php?series=".$data[0]."'>".$tampil."</a></li>";
						$view.="<li><a href='indexitems.php?series=".$data[0]."'>".$data[0]."</a></li>";
					}
				$view.="</ul></div>
				";
	//----------------config paging------------------
	$limit =12;
	
	if(isset($_GET['page'])){
		$noPage = $_GET['page'];
	}else{ 
		$noPage = 1;
	}	 
	
	$offset = ($noPage - 1) * $limit;
	//--------------- end config paging----------------
	
	if(!empty($_GET['series'])){
		$sql = "select * from barang where kategori = '".$_GET['series']."'order by hrgbeli asc limit ".$offset.", ".$limit.""; 	
	}else{
		$sql = "select * from barang order by hrgbeli asc limit ".$offset.", ".$limit.""; 	
	}
	
	foreach($obj->viewdata($sql) as $res){
		$harga = (int)$res[5] - (((int)$res[5]*(int)$res[6])/100);				
		if(!empty($res[6]) or $res[6] == ""){
			$view .="<div class='cartwrap'>
					<div class='discitems'><font size='6'><b>".$res[6]."</b></font>%</div>					
					<form action='index.php' method='POST'>
					<img src='".$res[1]."' height='180px'>
					<br><b>".$res[2]."</b><br><small><i>".$res[3]."</i></small>
					<br><small><s>Rp. ".number_format($res[5])."</s></small>
					<br><font color='red' size='2px'><b>Rp. ".number_format($harga)."</b></font><br><br>
					<input type='hidden' name='action' value='addcart'>
					<input type='hidden' name='series' value='".$_GET['series']."'>
					<input type='hidden' name='dari' value='items'>
					<input type='hidden' name='page' value='".$noPage."'>
					<input type='hidden' name='brg' value='".$res[0]."'>
					<a href='detail.php?brg=".$res[0]."&page=".$noPage."' class='detail'>Lihat</a><input type='submit' name='submit' value='Beli'>
					</form>
					 </div>";	
		}else{	
			$view .="<div class='cartwrap'>
					<form action='index.php' method='POST'>
					<img src='".$res[1]."' height='180px'>
					<br><b>".$res[2]."</b><br><small><i>".$res[3]."</i></small>
					<br><font color='red' size='2px'><b>Rp. ".number_format($harga)."</b></font><br><br><br>
					<input type='hidden' name='action' value='addcart'>
					<input type='hidden' name='series' value='".$_GET['series']."'>
					<input type='hidden' name='dari' value='items'>
					<input type='hidden' name='page' value='".$noPage."'>
					<input type='hidden' name='brg' value='".$res[0]."'>
					<a href='detail.php?brg=".$res[0]."&page=".$noPage."' class='detail'>Lihat</a><input type='submit' name='submit' value='Beli'>				
					</form>
					 </div>";		
		}
	}
	
	//------------------------- tampilkan deretan halaman------------------------
	$view .="<div class='paging'>";
	
	// mencari jumlah semua data dalam tabel  
	if(!empty($_GET['series'])){
		$sql = "select count(*) from barang where kategori = '".$_GET['series']."'order by hrgbeli asc limit ".$offset.", ".$limit.""; 	
	}else{
		$sql = "select count(*) from barang order by hrgbeli asc limit ".$offset.", ".$limit.""; 	
	}
	
	$res=$obj->viewonedata($sql); 
	$jumData = $res[0];
	 //	die($jumData);
	// menentukan jumlah halaman yang muncul berdasarkan jumlah semua data	 
	$jumPage = ceil($jumData/$limit);
	 // menampilkan link previous	 
	if ($noPage > 1) 
		$view .= "<a href='".$_SERVER['PHP_SELF']."?series=".$_GET['series']."&page=".($noPage-1)."'  class='page'>&lt;&lt; Prev</a>";
	 //die('hei');
	
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
				$view .= " <a href='".$_SERVER['PHP_SELF']."?series=".$_GET['series']."&page=".$page."' class='buttcart'>".$page."</a> ";
				$showPage = $page;
			 }
	}
	 
	// menampilkan link next
	 
	if ($noPage < $jumPage) 
		$view .= "<a href='".$_SERVER['PHP_SELF']."?page=".($noPage+1)."' class='page'>Next &gt;&gt;</a>";
	
	$view.="&nbsp;&nbsp;&nbsp;Produk : <b class='currpage'>".$jumData."</b>";
	//--------------------------- akhir tampilan halaman-------------------------------
	
	$view .="</div><div class='footindex'><div class='head-left'><b>hero |  Original earphone</b></div><div class='head-right'>Layanan : 02196364964,  2013</div></div>
	</div>";
	
}
print $view;
?>
</body>
</html>
<?php
ob_flush();
?>