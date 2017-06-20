<?php 
//if(isset($_POST['reg']))
//add(json_decode($_POST['reg']));
print_r($_POST);


function add($post){
	$DB_HOST='115.29.238.95';
	$DB_NAME="rec_form";
	$DB_USER="root";
	$DB_PASS="mingyang";
	$DB_TABLE="xingyao";
	foreach ($post as $k => $v) {
		if($k=='name')
			$name=addslashes(trim($v));
		if($k=='tel')
			$tel=addslashes(trim($v));

		$strK.='`'.addslashes(trim($k)).'`'.',';
		$strV.="'".addslashes(trim($v))."'".',';
	}
	$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
	$mysqli->set_charset('utf8');
	$sql="SELECT 1 FROM `$DB_TABLE` WHERE `name`='$name' AND `tel`='$tel' LIMIT 1;";
	$mysqli->query($sql);
	if($mysqli->affected_rows>0)
		exit ('exist');
	$sql="INSERT INTO `".$DB_TABLE."` ($strK `date`)VALUES($strV now());";
	echo $mysqli->query($sql);
	$mysqli->close();
	
}