<?php
class DB{
	var $host;
	var $usr;
	var $pwd;
	var $db;
	var $sql;
	var $res;

	function __construct(){}
	
	function connect($host, $usr, $pwd, $db){
		$mysqli = new mysqli($host, $usr, $pwd, $db);
		
		if($mysqli->connect_errno)
			die ('Gagal :'.$mysqli->connect_error);

		return ($mysqli);
	}
	
	function run($sql){
		$res = $mysqli->query($sql) or die($mysqli_error);
		return($res);
	}
	
	function viewdata($sql){
		$this->res = array(); //definisikan kedalam array
		$runsql = $this->run($sql); // jalankan sql
		
		if (!empty($runsql)){
			while($res = mysqli_fetch_row($runsql)){
				$this->res[] = $res; //tampung data
			}
		}
		return($this->res);
	}
	
	function viewonedata($sql){
		$runsql = $this->run($sql); // jalankan sql		
		$this->res = mysqli_fetch_row($runsql);
		
		return($this->res);
	}
	
	function countdata($sql){
		$runsql = $this->run($sql); // jalankan sql		
		$this->res = mysqli_num_rows($runsql);
		
		return($this->res);
	}
}
?>