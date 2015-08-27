<?php
/* 
	Le code contenu dans cette page ne sera éxecuté qu'à la désactivation du plugin 
	Vous pouvez donc l'utiliser pour supprimer des tables SQLite, des dossiers, ou executer une action
	
*/
require_once('Sensor.class.php');
require_once('SensorType.class.php');
$table = new Sensor();
$table2 = new SensorType();
$table->drop();
$table2->drop();

$conf = new Configuration();
$conf->delete(array('key'=>'plugin_sensor_receptor_pin'));

$table_section = new Section();
$id_section = $table_section->load(array("label"=>"sensor"))->getId();
$id_section2 = $table_section->load(array("label"=>"sensortypes"))->getId();
$table_section->delete(array('label'=>'sensor'));
$table_section2->delete(array('label'=>'sensortypes'));

$table_right = new Right();
$table_right->delete(array('section'=>$id_section));
$table_right->delete(array('section'=>$id_section2));

?>