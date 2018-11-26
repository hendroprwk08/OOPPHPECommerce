function konfadd(){
	if(confirm("Anda akan menambahkan data supplier?")){
		
		return true;
	}	
	return false;	
}

function konfdel(){
	if(confirm("Yakin akan dihapus?")){
		return true;
	}	
	return false;	
}

function konfupdate(){
	if(confirm("Update data?")){
		return true;
	}	
	return false;	
}

function cekharga(){
	var beli = document.getElementById('hargabeli').value;
	var hasil = (parseint(beli) + parseint(beli));
	
	document.getElementById('hargajual').value = hasil;
}
