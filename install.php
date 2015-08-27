<?php
/* 
	Le code contenu dans cette page ne sera éxecuté qu'à l'activation du plugin 
	Vous pouvez donc l'utiliser pour créer des tables SQLite, des dossiers, ou executer une action
	qui ne doit se lancer qu'à l'installation ex :
	
*/
require_once('Sensor.class.php');
$table = new Sensor();
$table->create();


require_once('SensorType.class.php');
$table2 = new SensorType();
$table2->create();

$s1 = New Section();
$s1->setLabel('sensor');
$s1->save();

$s2 = New Section();
$s2->setLabel('sensortypes');
$s2->save();

$r1 = New Right();
$r1->setSection($s1->getId());
$r1->setRead('1');
$r1->setDelete('1');
$r1->setCreate('1');
$r1->setUpdate('1');
$r1->setRank('1');
$r1->save();

$r2 = New Right();
$r2->setSection($s2->getId());
$r2->setRead('1');
$r2->setDelete('1');
$r2->setCreate('1');
$r2->setUpdate('1');
$r2->setRank('1');
$r2->save();

$conf = new Configuration();
$conf->put('plugin_sensor_receptor_pin','0');
?>