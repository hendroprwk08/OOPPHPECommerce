<?php
ob_start();
include("classDB.php");
include("classSession.php");

$ses = new Sess();
$ses->start();

$obj = new DB;
$obj->linktoDB();
?>
<html>
<head>
<title>He_ro tees</title>
<link rel="stylesheet" href="style.css" type="text/css" />
<script src="jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="jquery-number.js" type="text/javascript"></script>
<script language="javascript">
$(document).ready(function(){
	alert("bisa");
	$("#result").load("ajjual.php?act=ibarang"); //load pertama
	
	//pagging
	$('.load_more').live("click",function() { //When user clicks
	alert("klik");
		var last_msg_id = $(this).attr("id");//Get the id from the hyperlink
	alert(last_msg_id);
		if(last_msg_id!='end'){ //if not all post has been loaded yet
		 
			$.ajax({//fetch the article via ajax
				type: "POST",
				url: "ajjual.php?act=ibarang",//calling this page
				data: "lastmsg="+ last_msg_id,
				beforeSend:  function() { // add the loadng image
											$('a.load_more').append('<img src="facebook_style_loader.gif" />');
									  },
				success: function(html){
											$(".load_more").remove();//buang agar tidak dobel class load_morenya"
											$("#result").append(html);//output the server response into ol#updates
											$(this).attr("id")= last_msg_id  + 4;
								}
			});
		 }
		return false;
	});
		
	$('#kota').click(function() {
		$.ajax({
			type:"post",
			url: "ajjual.php",
			data: $("#myform").serialize(),					
			beforeSend: function(){
							$('#respon').text("Mohon Tunggu Sebentar").fadeIn("slow");
						},
			success: function(data){
		          //alert("success");
		           $("#respon").html(data);
		           $("#respon").html("Biaya pengiriman berhasil ditentukan");
		    },
		    error:function(response){
		          $("#respon").html(response);
		          return false;
		    }   
		});	
			
		//validasi
		var nama = $("#nama").val() ;
		var telp = $("#telp").val() ;
		var alamat = $("#alamat").val() ;		
		
		if(nama.length == 0 || telp.length == 0 || alamat.length == 0){
			alert("Lengkapi data anda");
			return false;
		}
		
		//hitung pengiriman
		var jumlah = $("#jumlah").text().replace(',', '');		
		var tarif = $("#kota").val(); //kota dan tarif
		var ntarif = tarif.split("-"); //pecah kota dan tarif
		
		//tampilkan semua hasil
		$("#kotanya").val($("#kota").val());		
		$("#tarif").html(ntarif[2]);
		$("#tberat").html($("#berat").text());	  
		$("#ttarif").html(parseInt($("#tarif").text()) * parseInt($("#berat").text()));	  
		$("#total").html(parseInt($("#tarif").text()) + parseInt(jumlah)|| "0");		
		
		//konversi format tulisan ke number
		$("#tarif").number($("#tarif").text());
		$("#ttarif").number($("#ttarif").text());
		$("#total").number($("#total").text());	
		
		//location.reload();
	});
	
	//tabulasi untuk pembayaran
	$("#tab2").hide();
	$("#tab3").hide();
	
	$(".tabtrans ul li a").click(function(){
	
		$('.headwrap[id$="tab1"]').hide();
		$('.headwrap[id$="tab2"]').hide();
		$('.headwrap[id$="tab3"]').hide();
		
		$(".tabtrans div").hide();
		var currtab = $(this).attr("href");
		$(currtab).fadeIn();
	});
	
	//validasi 
	$("#konf").click(function(){
		var total = $("#total").text();

		if(total == "0"){
			alert("Mohon tentukan wilayah pengiriman dahulu");
			$("#tab3").hide();
			$("#tab2").fadeIn();
			return false;
		}
		return true;
	});
	
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
<?php
if(!empty($_REQUEST['action'] )){
	$aksi = $_REQUEST['action'];
}else{
	$aksi = "";
}

if(empty($aksi)){
	if($ses->readsess('username') != ""){
		$st = "<span class='buttlogin'><a href='supplier.php'>Kembali ke halaman admin</a></span>";
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
					<img src='material/logo.png'>
					<p>A : Ujung aspal, pondok gede. T : 02196364964 E: Hendroprwk@yahoo.com B : 3147DB82</p>
				</div><div id='result'>";

			$view .="</div><div class='footindex'><div class='head-left'><b>hero tees</b></div><div class='head-right'>2013</div></div>
			</div>";
}elseif($aksi == "addcart"){
	$sql = "select * from barang where idbrg = ".$_POST['brg']."";
	$res = $obj->viewonedata($sql);
	//die(print_r($res));
	$ses->setCartSess($res[0], array('id'=>$res[0], 'nama'=>$res[2], 'qty'=>'1', 'berat'=>$res[11], 'diskon'=>$res[6],'hrg'=>$res[5]));
	header("location:index.php");
}elseif($aksi == "delcart"){
	$ses->unsetCartSess($_GET['id']);
	header("location:index.php?action=editcart");
}elseif($aksi == "updatecart"){
	$ses->unsetCartSess($_GET['id']);
	$ses->setCartSess($_GET['id'], array('id'=>$_GET['id'], 'nama'=>$_GET['n'], 'qty'=>$_GET['q'], 'berat'=>$_GET['b'], 'diskon'=>$_GET['d'],'hrg'=>$_GET['h']));
	header("location:index.php?action=editcart");
}elseif($aksi == "editcart"){	
	$view = "<div class='heading'>
			<div class='headwrap' >
					<div class='head-left'>".$ses->readsess('nama')."</div>
					<div class='head-right'><a href='index.php'>Kembali ke halaman sebelumnya</a>&nbsp;&nbsp;&nbsp;&nbsp;<span class='buttlogin'><a href='login.php'>Login</a></span></div>		
			</div>
			</div>
			<div class='editcart'>
				<div class='tabtrans'>
					<ul>
						<li><a href='#tab1'>1. Cart</a></li>
						<li><a href='#tab2'>2. Pengiriman</a></li>
						<li><a href='#tab3'>3. Rekap Transaksi</a></li>
					</ul>
				</div>
				<div class='headwrap' id='tab1'>
					<h1 class='judul'>Transaksi</h1>
					<table width='100%' class='tabcart'>
						<th class='headth' width='25%'>Nama</th><th class='headth' width='20%'>Harga</th><th class='headth' width='5%'>Qty</th><th class='headth' width='5%'>Berat<br>(/Kg)</th><th class='headth' width='15%'>Diskon</th><th class='headth' width='15%'>jumlah</th><th width='10%'></th>";
					$arrres = $ses->readSess('jual');
					$jumlah=0; $qty=0; $berat=0;
					
					if (!empty($arrres)){
						asort($arrres);
						foreach($arrres as $row){
							$qty += $row['qty'];
							$berat += $row['qty']*$row['berat'];
							$diskon += $row['qty']*$row['diskon'];
							$jumlah = (int)$row['hrg'] * (int)$row['qty'];
							$total += ($row['hrg']*$row['qty']) - ($row['diskon']*$row['qty']);  
							
							$view.="<form method='GET' action='".$_SERVER['PHP_SELF']."'>							 			
						 			<tr id='line'>
						 				<td><input type='hidden' name='n' value='".$row['nama']."'>".$row['nama']."</td>
										<td><input type='hidden' name='h' value='".$row['hrg']."'>".number_format($row['hrg'])."</td>
										<td><select name='q'>";
										
										$arrc = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
										foreach($arrc as $sel){
											if ($sel == $row[qty]){
												$view.="<option selected>".$sel."</option>";
											}else{
												$view.="<option>".$sel."</option>";											
											}
										}
										
								$view .= "</select></td>
										<td><input type='hidden' name='b' value='".$row['berat']."'>".number_format($row['berat']*$row['qty'], 1 )."</td>	
										<td><input type='hidden' name='d' value='".$row['diskon']."'>".number_format($row['diskon']*$row['qty'])."</td>
										<td>".number_format(($row['hrg']*$row['qty']) - ($row['diskon']*$row['qty']))."</td>
										<td>
											<input type='hidden' name='action' value='updatecart'>
											<input type='hidden' name='id' value='".$row['id']."'>
											<input type='image' src='material/check.gif'></a>			
											<a href='index.php?action=delcart&id=".$row['id']."'><img src='material/del.png'></a>
										</td>
									</tr>
									</form>";
						}
						
						$view .= "<tr><th colspan='2' class='buttth'>Jumlah</th><th class='buttth'><b><div id='qty'>".number_format($qty)."</div></b></th><th class='buttth'><div id='berat'>".number_format(ceil($berat))."</div></th><th class='buttth'><div>".number_format($diskon)."</div></th><th class='buttth'><b><div id='jumlah'>".number_format($total)."</div></b></th></tr>";
					}
				$view .="</table>		
				</div> 
				<div class='headwrap' id='tab2'>
					<h1 class='judul'>Pengiriman</h1>
					<table width='80%'>
						<form id='myform'>
					 		<tr><td width='30%'>Nama lengkap :</td><td><input type='text' id='nama' name='nama' size='50' value='".$_SESSION['pembeli']['nama']."'></td></tr>
							<tr><td>Telp :</td><td><input type='text' id='telp' name='telp' size='40' value='".$_SESSION['pembeli']['telp']."'></td></tr>
							<tr><td>Alamat kirim :</td><td><textarea id='alamat' name='alamat' rows='5' cols='35'>".$_SESSION['pembeli']['alamat']."</textarea></td></tr>
							<tr><td>Propinsi :</td><td><select id='kota' name='kota'>";
							
							$sql = "select * from tarif order by propinsi asc, kota asc";
							
							foreach($obj->viewdata($sql) as $row){		
								$view .="<option value='".$row[1]."-".$row[2]."-".$row[3]."'>".$row[1]." - ".$row[2]." - ".$row[3]."/Kg</option>";
							}
							
							$view .= "</select></td></tr>
							<tr><td></td><td><input type='hidden' id='kotanya' name='kotanya' value=''>
							<input type='hidden' id='act' name='act' value='ipembeli'>
							<br><span id='respon'></span></td></tr>
							 </table>
						</form>	
				</div> 
				<div class='headwrap' id='tab3'>						
					<h1 class='judul'>Rekap transaksi</h1>
					<form id='transaksi'>
					<table width='100%'>
							<tr><td colspan='2'>Jumlah</td><td>".number_format($qty)." Pcs</td><td><b><div id='jumlah'>".number_format($total)."</div></b></td></tr>
							<tr><td colspan='2'>Ongkos kirim<span id='tarif'>0</span> /Kg</td><td><span id='tberat'>0</span> Kg</td><td><b><div id='ttarif'>0</div></b></td></tr>										  
							<tr><td colspan='2'>Total</td><td></td><td><b><div id='total'>0</div></b></td></tr>
							<tr><td colspan='4'><br><br><br>
							<div class='head-right'><p class='buttcart'><a href='index.php?action=pengiriman' id='konf'>Selanjutnya</a></p></div></td></tr>
					</table>
					</form>
				</div>
			</div>";
}elseif($aksi == "pengiriman"){
	//delete data yang tidak memiliki status
	$sql = "delete djual from jual join djual on jual.idjual = djual.idjual where jual.status=''";
	$obj->run($sql);
	
	$sql = "delete from jual where status=''";
	$obj->run($sql);
	
	//generate id
	session_regenerate_id();	
	$buyer = $ses->readSess('pembeli');				
	$jual = $ses->readSess('jual');							
	
	//proses data
	if(empty($jual) && empty($buyer)){
	}else{
		$unik = mt_rand(10,99);
		
		$sql = "insert into jual values('".session_id()."', '".date('Y-m-d')."', '".$buyer['nama']."', 
			 '".$buyer['alamat']."', '".$buyer['telp']."', '0', '0', '".($tbayar+$unik)."', 'Pending', '',  '".date('Y-m-d')."',  '".$buyer['nama']."')";
		$obj->run($sql); 	
	
		foreach($jual as $row){
			$sql = "insert into djual values('".session_id()."', '".$row['id']."', '".$row['qty']."', '".$row['hrg']."', 
					  '".ceil($row['berat']*$row['qty'])."','".($row['qty']*$row['diskon'])."', '".(($row['qty']*$row['hrg'])-($row['qty']*$row['diskon']))."')";
			$obj->run($sql); 
			$tbayar +=$row['qty']*$row['hrg'];
			$tberat +=ceil($row['qty']*$row['berat']);
			$ttotal +=($row['qty']*$row['hrg']) -($row['qty']*$row['diskon']) ;
		}		
		
		$sql = "update jual set berat = ".$tberat.", delivery=".$tberat *$buyer['tarif'].", total =".($ttotal+$unik)."  where idjual = '".session_id()."'";
		$obj->run($sql); 			
	}
	
	$view ="<div class='heading'>
			  <div class='headwrap' >
					<div class='head-right'><a href='index.php'>Kembali ke halaman sebelumnya</a>&nbsp;&nbsp;&nbsp;&nbsp;<span class='buttlogin'><a href='login.php'>Login</a></span></div>		
			  </div>
			  </div>
			  <div class='editcart'>
				<div class='headwrap'>
					<div class='head-right'><span class='buttcart'><a href='#' onClick='window.print()'>Cetak bukti pesanan</a></span>&nbsp;&nbsp;&nbsp;<span class='buttcart'><a href='index.php?action=selesai&idjual=".session_id()."'>Selesai transaksi</a></span></div>
					<h1 class='judul'>Invoice</h1>";
				$sqljual = "select * from jual where idjual='".session_id()."'";
				$resjual = $obj->viewonedata($sqljual);
				$view .="<table border='0' width='100%'>
							  <tr>
									<td><b>No transaksi</b><br>".$resjual[0]."</td>
							        <td><b>Nama</b><br>".$resjual[2]."</td>
									<td><b>Telp</b><br>".$resjual[4]."</td>
									<td colspan='2'><b>Alamat</b><br>".$resjual[3]."</td>
							  </tr>
							  <tr><td colspan='5'>&nbsp;</td></tr>
							  <tr>
									<td><b>Pembayaran melalui rekening</b><br>a/n Hendro purwoko <br> BCA 0970909789<br>BNI 876876786</td>
									<td><b>Total berat</b><br>".$resjual[5]."</td>
									<td><b>Biaya kirim</b><br>".number_format($resjual[6])."</td>
							        <td><b>Total Bayar</b><br>".number_format($resjual[6]+$resjual[7])."*</td>
									<td><b>Status pengiriman</b><br>".$resjual[8]."</td>
									<td></td>
							  </tr>							 
							  </table>
							  <br><br>
							  <table width='100%' class='tabcart'>
							  <tr>
									<th class='headth' width='30%'><b>Nama</b></th>
									<th class='headth' width='5%'><b>Berat</b></th>
									<th class='headth' width='5%'><b>Qty</b></th>
									<th class='headth' width='10%'><b>Harga</b></th>
									<th class='headth' width='10%'><b>Diskon</b></th>
									<th class='headth' width='10%'><b>Jumlah</b></th>
							  </tr>";
			
			$sqldjual = "SELECT djual.idjual, djual.idbrg, barang.nama, djual.berat, djual.qty, djual.harga, djual.diskon, djual.jumlah
								FROM djual INNER JOIN barang 
								ON djual.idbrg = barang.idbrg
								where djual.idjual = '".session_id()."'";
			
			foreach($obj->viewdata($sqldjual) as $row){			
				$berat += $row[3];
				$qty += $row[4];
				$harga += $row[5];
				$diskon += $row[6];
				$jumlah += $row[7];				
				$view .="<tr>
									<td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td><td>".number_format($row[5])."</td><td>".number_format($row[6])."</td><td>".number_format($row[7])."</td>
							   </tr>";	
			}		
			$view .="<tr><th class='buttth'>&nbsp;</th><th class='buttth'>".number_format($berat,1)."</th><th class='buttth'>".number_format($qty)."</th><th class='buttth'>&nbsp;</th><th class='buttth'>".number_format($diskon)."</th><th class='buttth'>".number_format($jumlah+$unik)."*</th></tr>
			<tr><th colspan='6'><br><small>Konfirmasi : <br>2 digit angka adalah nomer unik yg digunakan sebagai nomer konfirmasi pembayaran, harap mentransfer dgn jumlah tersebut</small><br><small>Atau dengan mencantumkan 4 digit nomer transaksi anda dapat menghubungi, Email : cs@herotees.com&nbsp;&nbsp;Telp/sms : 02196364964</small></th></tr>
			</table>
			</div>
			</div>";
			  
}elseif($aksi == "selesai"){
	$sql = "update jual set status='pending' where idjual='".$_GET['idjual']."'";
	$obj->run($sql);
	
	$ses->unsetSess('jual');
	$ses->unsetSess('pembeli');
	header("location:index.php");
}
print $view;
?>
</body>
</html>
<?php
ob_flush();
?>