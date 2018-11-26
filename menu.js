$(document).ready(function(){
	$(".insdata").hide();
	$(".menulaporan").hide();
	$(".menumaster").hide();
	$(".menutrans").hide();
	
	$("#lap").click(function(){
		$(".menulaporan").fadeToggle();
	});
	
	$("#master").click(function(){
		$(".menumaster").fadeToggle();
	});
	
	$("#trans").click(function(){
		$(".menutrans").fadeToggle();
	});
	
	$(".menulaporan").blur(function(){
		$(this).fadeOut();
	});
	
	$(".indata").click(function(){
		$(".insdata").fadeIn("slow");
	});
	
	$(".tutup").click(function(){
		$(".insdata").fadeOut("slow");
	});
});
