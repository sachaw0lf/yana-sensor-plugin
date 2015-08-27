<?php

/*
 @nom: SensorType
 @auteur: Sachawolf (sachawolf@live.fr)
 @description:  Classe de gestion des types de capteurs radios
 */


class SensorType extends SQLiteEntity{

	
	protected $id,$name;
	protected $TABLE_NAME = 'plugin_sensor_type';
	protected $CLASS_NAME = 'SensorType';
	protected $object_fields = 
	array( 
		'id'=>'key',
		'name'=>'string'
	);

	function __construct(){
		parent::__construct();
	}
//Methodes pour recuperer et modifier les champs (set/get)
	function setId($id){
		$this->id = $id;
	}
	
	function getId(){
		return $this->id;
	}

	function getName(){
		return $this->name;
	}

	function setName($name){
		$this->name = $name;
	}

}

?>