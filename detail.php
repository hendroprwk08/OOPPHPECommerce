<?php
ob_start();
include("classDB.php");
include("classSession.php");
include("youtube.php");

$ses = new Sess();
$ses->start();

$obj = new DB;
$obj->linktoDB();

//load decription, keyword
$sql = "select * from barang where idbrg = ".$_GET['brg']."";
$desc = $obj->viewonedata($sql);	
?>
<html>
<head>
<meta content="index follow" name="robots"/>
<meta name='description' content='<?php print $desc[2]." | ".$desc[3]." ". $desc[7];?>'/>
<meta name='keywords' content='<?php print $desc[13];?>' />
<link rel="icon" 
      type="image/png" 
      href="logoico.png">
<title>hero | <?php print $desc[2];?></title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<?php
if($ses->readsess('username') != ""){
		$st = "<span class='buttlogin'><a href='supplier.php'>Halaman admin</a></span>";
	}else{
		$st = "";
	}
	
	$view .="<div class='heading'>
					<div class='headwrap'>
					<div class='head-left'>".$st."</div>
					<div class='head-right'><a href='#' onclick='window.history.back()'>Kembali ke halaman sebelumnya</a> | <b>Jumlah</b> : ";
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
			<div class='cartdetail'>";				
	
	$sql = "select * from barang where idbrg = ".$_GET['brg']."";
			
	foreach($obj->viewdata($sql) as $res){
		$harga = (int)$res[5] - (((int)$res[5]*(int)$res[6])/100);		
		
		if(empty($res[12])){
			$youtube = "-- tidak ada video --";
		}else{	
			$youtube = "<h3>Review</h3><br><br>".youtube($res[12]);
		}
		
		if(!empty($res[6]) or $res[6] == "" or $res[6] == "0"){
			$view .="<form action='index.php' method='POST'>
							<div class='left'>
							<img src='".$res[1]."' width='300px' >
							".$youtube."
							</div>
							<div class='right'>
							<!-- AddThis Button BEGIN -->
							<div class='addthis_toolbox addthis_default_style'>
							<a class='addthis_button_facebook_like' fb:like:layout='button_count'></a>
							<a class='addthis_button_tweet'></a>
							<a class='addthis_button_pinterest_pinit'></a>
							<a class='addthis_counter addthis_pill_style'></a>
							</div>
							<script type='text/javascript'>var addthis_config = {'data_track_addressbar':true};</script>
							<script type='text/javascript' src='//s7.addthis.com/js/300/addthis_widget.js#pubid=hendroprwk'></script>
							<!-- AddThis Button END -->							
							<br><b><font size='6'>".$res[2]."</font></b><br><br><small>Kategori : <i>".$res[3]."</i></small>
							<h3>Deskripsi/Spesifikasi</h3><br>
							<p>".nl2br($res[7])."</p>
							<h3>Harga</h3>
							<br>Reg. <small><s>Rp. ".number_format($res[5])."</s></small>
							<br><font color='red' size='2px'><b>Rp. ".number_format($harga)."</b> (  disc. ".$res[6]."% )</font><br><br>
							<input type='hidden' name='action' value='addcart'>
							<input type='hidden' name='dari'  value='detail'>
							<input type='hidden' name='page' value='".$_GET['page']."'>
							<input type='hidden' name='brg' value='".$res[0]."'>
							<input type='submit' name='submit' value='Beli'><br><br>
							<!-- AddThis Button BEGIN -->
							<div class='addthis_toolbox addthis_default_style'>
							<a class='addthis_button_facebook_like' fb:like:layout='button_count'></a>
							<a class='addthis_button_tweet'></a>
							<a class='addthis_button_pinterest_pinit'></a>
							<a class='addthis_counter addthis_pill_style'></a>
							</div>
							<script type='text/javascript'>var addthis_config = {'data_track_addressbar':true};</script>
							<script type='text/javascript' src='//s7.addthis.com/js/300/addthis_widget.js#pubid=hendroprwk'></script>
							<!-- AddThis Button END -->							
							</form><br>
							<div class='fb-comments' data-href='http://originalearphone.com' data-width='400' data-num-posts='10'></div>
							 </div>";	
		}else{	
			$view .="<form action='index.php' method='POST'>
							<div class='left'>
							<img src='".$res[1]."' width='300px'>
							<h3>Review</h3><br><br>".$youtube."							
							</div>
							<div class='right'>
							<!-- AddThis Button BEGIN -->
							<div class='addthis_toolbox addthis_default_style'>
							<a class='addthis_button_facebook_like' fb:like:layout='button_count'></a>
							<a class='addthis_button_tweet'></a>
							<a class='addthis_button_pinterest_pinit'></a>
							<a class='addthis_counter addthis_pill_style'></a>
							</div>
							<script type='text/javascript'>var addthis_config = {'data_track_addressbar':true};</script>
							<script type='text/javascript' src='//s7.addthis.com/js/300/addthis_widget.js#pubid=hendroprwk'></script>
							<!-- AddThis Button END -->	
							<br><b><font size='6'>".$res[2]."</font></b><br><br><small>Kategori : <i>".$res[3]."</i></small>
							<h3>Deskripsi/Spesifikasi</h3><br>
							<p>".nl2br($res[7])."</p>
							<h3>Harga</h3>						
							<br><font color='red' size='2px'><b>Rp. ".number_format($harga)."</b></font><br><br>
							<input type='hidden' name='action' value='addcart'>
							<input type='hidden' name='dari'  value='detail'>							
							<input type='hidden' name='page' value='".$_GET['page']."'>
							<input type='hidden' name='brg' value='".$res[0]."'>
							<input type='submit' name='submit' value='Beli'><br><br>
							<!-- AddThis Button BEGIN -->
							<div class='addthis_toolbox addthis_default_style'>
							<a class='addthis_button_facebook_like' fb:like:layout='button_count'></a>
							<a class='addthis_button_tweet'></a>
							<a class='addthis_button_pinterest_pinit'></a>
							<a class='addthis_counter addthis_pill_style'></a>
							</div>
							<script type='text/javascript'>var addthis_config = {'data_track_addressbar':true};</script>
							<script type='text/javascript' src='//s7.addthis.com/js/300/addthis_widget.js#pubid=hendroprwk'></script>
							<!-- AddThis Button END -->					
							</form><br>
							<div class='fb-comments' data-href='http://originalearphone.com' data-width='400' data-num-posts='10'></div>
							 </div>";		
		}
	}
	$view .="<div class='footindex'><div class='head-left'><b>hero |  Original earphone</b></div><div class='head-right'>Layanan : 02196364964,  2013</div></div>
				</div>";
print($view);	
?>
</body>