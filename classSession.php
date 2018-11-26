<?php

class Sess{
	var $result;
	
	function __construct(){}
	
	function start(){
		session_start();
	}
	
	function setSess($name, $value){
		$_SESSION[$name] = $value; 
	}
	
	function unsetSess($name){
		unset($_SESSION[$name]);
	}
	
	function setCartSess($id, $value){
		$_SESSION['jual'][$id] = $value;
	}
	
	function unsetCartSess($id, $value){
		unset($_SESSION['jual'][$id]);
	}
	
	function readSess($name){
		$this->result = $_SESSION[$name];
		return ($this->result);		
	}
	
	function destSess(){
		session_destroy();
	}
}
?>