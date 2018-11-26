<?php
class DB{
	var $host;
	var $usr;
	var $pwd;
	var $db;
	var $sql;
	var $res;

	function __construct(){}
	
	function connect($host, $usr, $pwd){
		$res = mysql_connect($host, $usr, $pwd) or die(mysql_error());
		return ($res);
	}
	
	function select_db($db){
		$res = mysql_select_db($db) or die(mysql_error());
		return ($res);
	}

	function run($sql){
		$res = mysql_query($sql) or die(mysql_error());
		return($res);
	}
	
	function viewdata($sql){
		$this->res = array(); //definisikan kedalam array
		$runsql = $this->run($sql); // jalankan sql
		
		if (!empty($runsql)){
			while($res = mysql_fetch_row($runsql)){
				$this->res[] = $res; //tampung data
			}
		}
		return($this->res);
	}
	
	function viewonedata($sql){
		$runsql = $this->run($sql); // jalankan sql		
		$this->res = mysql_fetch_row($runsql);
		
		return($this->res);
	}
	
	function countdata($sql){
		$runsql = $this->run($sql); // jalankan sql		
		$this->res = mysql_num_rows($runsql);
		
		return($this->res);
	}
	
	function linktoDB(){
		$this->connect("localhost", "root", "");
		$this->select_db("herodb");
	}
}
?>