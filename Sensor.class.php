<?php

/*
 @nom: Sensor
 @auteur: Sachawolf (sachawolf@live.fr)
 @description:  Classe de gestion des capteurs radios comme les tutos d'Idleman. lire le README pour utilisation
 */


class Sensor extends SQLiteEntity{

	
	protected $id,$name,$description,$radioCode,$room,$state,$value,$type, $positive, $lastrcv;
	protected $TABLE_NAME = 'plugin_sensor';
	protected $CLASS_NAME = 'Sensor';
	protected $object_fields = 
	array( 
		'id'=>'key',
		'name'=>'string',
		'description'=>'string',
		'radioCode'=>'int',
		'room'=>'int',
		'state'=>'string',
		'value'=>'string',
		'type'=>'integer',
		'positive'=>'integer',
		'lastrcv'=>'string'
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
	
	function getDescription(){
		return $this->description;
	}

	function setDescription($description){
		$this->description = $description;
	}

	function getRadioCode(){
		return $this->radioCode;
	}

	function setRadioCode($radioCode){
		$this->radioCode = $radioCode;
	}

	function getRoom(){
		return $this->room;
	}

	function setRoom($room){
		$this->room = $room;
	}

	function getState(){
		return $this->state;
	}

	function setState($state){
		$this->state = $state;
	}
	
	function getValue(){
		return $this->value;
	}

	function setValue($value){
		$this->value = $value;
	}
	
	function getType(){
		return $this->type;
	}

	function setType($type){
		$this->type = $type;
	}

	function getPositive(){
		return $this->positive;
	}

	function setPositive($positive){
		$this->positive = $positive;
	}

	 function getLastrcv(){
                return $this->lastrcv;
        }

        function setLastrcv($lastrcv){
                $this->lastrcv = $lastrcv;
        }
}

?>
