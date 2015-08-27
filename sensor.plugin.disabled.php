<?php
/*
@name Sensor
@author Sachawolf <sachawolf@live.fr>
@link http://sachaw0lf.wordpress.com
@licence CC by nc sa
@version 1.0.0
@description Sensor plugin pour la gestion des sondes de températures like les tutos d'Idleman. Merci de Lire le README pour la mise en place.
*/

include('Sensor.class.php');
include('SensorType.class.php');


//Section gestion des capteurs
function sensor_plugin_setting_page(){
global $_,$myUser,$conf;
if(isset($_['section']) && $_['section']=='sensor' ){

	if($myUser!=false){
		$sensorManager = new Sensor();
		$sensors = $sensorManager->populate();
		$roomManager = new Room();
		$rooms = $roomManager->populate();
		$typeManager = new SensorType();
		$sensorTypes = $typeManager->populate();

		//Si on est en mode modification
		if (isset($_['id'])){
			$id_mod = $_['id'];
			$selected = $sensorManager->getById($id_mod);
			$description = $selected->GetName();
			$button = "Modifier";
		}
		//Si on est en mode ajout
		else
		{
			$description =  "Ajout d'un capteur";
			$button = "Ajouter";
		}
		?>

		<div class="span9 userBloc">


			<h1>Capteurs</h1>
			<p>Gestion des capteurs radio</p>  
			<form action="action.php?action=sensor_add_sensor" method="POST">
				<fieldset>
					<legend><?php  echo $description ?></legend>

					<div class="left">
						<label for="typeSensor">Type capteur</label>
						<select name="typeSensor" id="typeSensor">
						<?php foreach($sensorTypes as $sensorType){ 
							if (isset($selected)){$selected_type = ($selected->getType());
							}else if(isset($_['type'])){
								$selected_type = $_['type'];
							}else{
								$selected_type = null;
							}			    		
							?>

							<option <?php  if ($selected_type == $sensorType->getId()){echo "selected";} ?> value="<?php echo $sensorType->getId(); ?>"><?php echo $sensorType->getName(); ?></option>
							<?php } ?>
						</select>
						<label for="nameSensor">Nom</label>
						<?php  if(isset($selected)){echo '<input type="hidden" name="id" value="'.$id_mod.'">';} ?>
						<input type="text" id="nameSensor" value="<?php  if(isset($selected)){echo $selected->getName();} ?>" onkeyup="$('#vocalCommand').html($(this).val());" name="nameSensor" placeholder="Capteur Température Salon"/>
						<small>Commande vocale associée : "<?php echo $conf->get('VOCAL_ENTITY_NAME'); ?>, donne <span id="vocalCommand"></span>"</small>
						<label for="descriptionSensor">Description</label>
						<input type="text" value="<?php if(isset($selected)){echo $selected->getDescription();} ?>" name="descriptionSensor" id="descriptionSensor" placeholder="Capteur dans le salon" />
						<label for="radioCodeSensor">Code radio</label>
						<input type="text" value="<?php if(isset($selected)){echo $selected->getRadioCode();} ?>" name="radioCodeSensor" id="radioCodeSensor" placeholder="0,1,2…" />
						<label for="roomSensor">Pièce</label>
						<select name="roomSensor" id="roomSensor">
							<?php foreach($rooms as $room){ 
								if (isset($selected)){$selected_room = ($selected->getRoom());
								}else if(isset($_['room'])){
									$selected_room = $_['room'];
								}else{
									$selected_room = null;
								}			    		
								?>

								<option <?php  if ($selected_room == $room->getId()){echo "selected";} ?> value="<?php echo $room->getId(); ?>"><?php echo $room->getName(); ?></option>
								<?php } ?>
							</select>
						</div>

						<div class="clear"></div>
						<br/><button type="submit" class="btn"><?php  echo $button; ?></button>
					</fieldset>
					<br/>
				</form>

				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>Type</th>
							<th>Nom</th>
							<th>Description</th>
							<th>Code radio</th>
							<th>Pi&egrave;ce</th>
							<th></th>
						</tr>
					</thead>

					<?php foreach($sensors as $sensor){ 

						$room = $roomManager->load(array('id'=>$sensor->getRoom())); 
						$typeSensor = $typeManager->load(array('id'=>$sensor->getType())); 
						?>
						<tr>
							<td><?php echo $typeSensor->getName(); ?></td>
							<td><?php echo $sensor->getName(); ?></td>
							<td><?php echo $sensor->getDescription(); ?></td>
							<td><?php echo $sensor->getRadioCode(); ?></td>
							<td><?php echo $room->getName(); ?></td>
							<td><a class="btn" href="action.php?action=sensor_delete_sensor&id=<?php echo $sensor->getId(); ?>"><i class="icon-remove"></i></a>
								<a class="btn" href="setting.php?section=sensor&id=<?php echo $sensor->getId(); ?>"><i class="icon-edit"></i></a></td>
							</tr>
							<?php } ?>
						</table>
					</div>

					<?php }else{ ?>

					<div id="main" class="wrapper clearfix">
						<article>
							<h3>Vous devez être connecté</h3>
						</article>
					</div>
					<?php
				}
			}

		}

//Section gestion des types de capteurs
function sensortypes_plugin_setting_menu(){
global $_,$myUser,$conf;
if(isset($_['section']) && $_['section']=='sensortypes' ){

if($myUser!=false){
	$sensorTypeManager = new sensorType();
	$sensorTypes = $sensorTypeManager->populate();

	//Si on est en mode modification
	if (isset($_['id'])){
		$id_mod = $_['id'];
		$selected = $sensorTypeManager->getById($id_mod);
		$description = $selected->GetName();
		$button = "Modifier";
	}
	//Si on est en mode ajout
	else
	{
		$description =  "Ajout d'un type de capteur";
		$button = "Ajouter";
	}
	?>

	<div class="span9 userBloc">


		<h1>Types de capteurs</h1>
		<p>Gestion des types de capteurs radio</p>  
		<form action="action.php?action=sensor_add_type" method="POST">
			<fieldset>
				<legend><?php  echo $description ?></legend>

				<div class="left">
					<label for="nameSensorType">Nom</label>
					<?php  if(isset($selected)){echo '<input type="hidden" name="id" value="'.$id_mod.'">';} ?>
					<input type="text" id="nameSensorType" value="<?php  if(isset($selected)){echo $selected->getName();} ?>" name="nameSensorType" placeholder="Température, Hygrométrie"/>
				</div>

				<div class="clear"></div>
					<br/><button type="submit" class="btn"><?php  echo $button; ?></button>
				</fieldset>
				<br/>
			</form>

			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Nom</th>
						<th></th>
					</tr>
				</thead>

				<?php foreach($sensorTypes as $sensorType){ 
					?>
					<tr>
						<td><?php echo $sensorType->getName(); ?></td>
						<td><a class="btn" href="action.php?action=sensor_delete_type&id=<?php echo $sensorType->getId(); ?>"><i class="icon-remove"></i></a>
							<a class="btn" href="setting.php?section=sensortypes&id=<?php echo $sensorType->getId(); ?>"><i class="icon-edit"></i></a></td>
						</tr>
						<?php } ?>
					</table>
				</div>

				<?php }else{ ?>

				<div id="main" class="wrapper clearfix">
					<article>
						<h3>Vous devez être connecté</h3>
					</article>
				</div>
				<?php
			}
		}

	}

			function sensor_plugin_setting_menu(){
				global $_;
				echo '<li '.(isset($_['section']) && $_['section']=='sensor'?'class="active"':'').'><a href="setting.php?section=sensor"><i class="icon-chevron-right"></i> Capteurs radio</a></li>';
				echo '<li '.(isset($_['section']) && $_['section']=='sensortypes'?'class="active"':'').'><a href="setting.php?section=sensortypes"><i class="icon-chevron-right"></i> Types capteurs</a></li>';
			}




			function sensor_display($room){
				global $_;


				$sensorManager = new Sensor();
				$sensors = $sensorManager->loadAll(array('room'=>$room->getId()));

				if(count($sensors)>0){
				foreach ($sensors as $sensor) {
					
					$sensorTypeManager = new sensorType();
					$type = $sensorTypeManager->load(array('id'=>$sensor->getType()));
					?>

					
				<div class="flatBloc blue-color" style="max-width:30%;">
						<h3><?php echo $sensor->getName() ?></h3>	
						<h4><?php ($sensor->getPositive()==1) ? '+' : '-'; ?>&nbsp;<?php echo $sensor->getValue() ?>&deg;C</h4>	
						<p><?php echo $sensor->getDescription() ?>
						</p><ul>
						<li>Code radio : <code><?php echo $sensor->getRadioCode() ?></code></li>
						<li>Type : <span><?php echo $type->getName() ?></span></li>
						<li>Emplacement : <span><?php echo $room->getName() ?></span></li>
						<li>Derni&egrave;re r&eacute;ception : <span><?php if($sensor->getLastrcv()<0 || !is_int($sensor->getLastrcv())) {echo 'Aucune'; } else {echo date("d/m/Y H:i:s",$sensor->getLastrcv());} ?></span></li>
					</ul>
		
					
					<a class="flatBloc" title="Activer le capteur" href="action.php?action=sensor_change_state&engine=<?php echo $sensor->getId() ?>&amp;code=<?php echo $sensor->getRadioCode() ?>&amp;state=on"><i class="icon-thumbs-up"></i></a>
					<a class="flatBloc" title="Désactiver le capteur" href="action.php?action=sensor_change_state&engine=<?php echo $sensor->getId() ?>&amp;code=<?php echo $sensor->getRadioCode() ?>&amp;state=off"><i class="icon-thumbs-down "></i></a>
					
					
				</div>
			


				<?php
			}
}else{
	?>Aucun Capteur radio ajouté dans la piece <code><?php echo $room->getName() ?></code>, <a href="setting.php?section=sensor&amp;room=<?php echo $room->getId(); ?>">ajouter un capteur radio ?</a><?php
}


		}

		function sensor_vocal_command(&$response,$actionUrl){
			global $conf;
			$sensorManager = new Sensor();

			$sensors = $sensorManager->populate();
			foreach($sensors as $sensor){
			
				$response['commands'][] = array('command'=>$conf->get('VOCAL_ENTITY_NAME').', allume '.$sensor->getName(),'url'=>$actionUrl.'?action=sensor_change_state&engine='.$sensor->getId().'&state=on&webservice=true','confidence'=>'0.9');
				$response['commands'][] = array('command'=>$conf->get('VOCAL_ENTITY_NAME').', eteint '.$sensor->getName(),'url'=>$actionUrl.'?action=sensor_change_state&engine='.$sensor->getId().'&state=off&webservice=true','confidence'=>'0.9');
				$response['commands'][] = array('command'=>$conf->get('VOCAL_ENTITY_NAME').', donne '.$sensor->getName(),'url'=>$actionUrl.'?action=sensor_get_value&engine='.$sensor->getId().'&webservice=true','confidence'=>'0.9');
				
			}
		}

		function sensor_action_sensor(){
			global $_,$conf,$myUser;

			//Mise à jour des droits
			$myUser->loadRight();

			switch($_['action']){
				case 'sensor_delete_sensor':
				if($myUser->can('sensor','d')){
					$sensorManager = new Sensor();
					$sensorManager->delete(array('id'=>$_['id']));
					header('location:setting.php?section=sensor');
				}
				else
				{
					header('location:setting.php?section=sensor&error=Vous n\'avez pas le droit de faire ça!');
				}

				break;
				
				case 'sensor_plugin_setting':
				$conf->put('plugin_sensor_receptor_pin',$_['receptorPin']);
				header('location: setting.php?section=preference&block=sensor');
				break;

				case 'sensor_add_sensor':

				//Vérifie si on veut modifier ou ajouter un capteur
				$right_toverify = isset($_['id']) ? 'u' : 'c';

				if($myUser->can('sensor',$right_toverify)){
					$sensor = new Sensor();
					//Si modification on charge la ligne au lieu de la créer
					if ($right_toverify == "u"){$sensor = $sensor->load(array("id"=>$_['id']));}
					$sensor->setName($_['nameSensor']);
					$sensor->setDescription($_['descriptionSensor']);
					$sensor->setRadioCode($_['radioCodeSensor']);
					$sensor->setRoom($_['roomSensor']);
					$sensor->setType($_['typeSensor']);
					$sensor->save();
					header('location:setting.php?section=sensor');
				}
				else
				{
					header('location:setting.php?section=sensor&error=Vous n\'avez pas le droit de faire ça!');
				}
				break;
				
				case 'sensor_delete_type':
				if($myUser->can('sensortypes','d')){
					$sensorTypeManager = new SensorType();
					$sensorTypeManager->delete(array('id'=>$_['id']));
					header('location:setting.php?section=sensortypes');
				}
				else
				{
					header('location:setting.php?section=sensortypes&error=Vous n\'avez pas le droit de faire ça!');
				}

				break;
				
				case 'sensor_add_type':

				//Vérifie si on veut modifier ou ajouter un capteur
				$right_toverify = isset($_['id']) ? 'u' : 'c';

				if($myUser->can('sensortypes',$right_toverify)){
					$sensorType = new SensorType();
					//Si modification on charge la ligne au lieu de la créer
					if ($right_toverify == "u"){$sensorType = $sensorType->load(array("id"=>$_['id']));}
					$sensorType->setName($_['nameSensorType']);
					$sensorType->save();
					header('location:setting.php?section=sensortypes');
				}
				else
				{
					header('location:setting.php?section=sensortypes&error=Vous n\'avez pas le droit de faire ça!');
				}


				break;

				case 'UPDATE_ENGINE_STATE':
					
					$sensor = new Sensor();
					$sensor = $sensor->load(array("radioCode"=>$_SERVER['argv'][2]));
					$sensor->setValue($_SERVER['argv'][3]);
					$sensor->setPositive($_SERVER['argv'][4]);
					$sensor->setLastrcv(time());
					$sensor->save();
					break;


				case 'sensor_change_state':
					global $_,$myUser;


				if($myUser->can('sensor','u')){

					$sensor = new Sensor();
					$sensor = $sensor->getById($_['engine']);
					Event::emit('sensor_change_state',array('sensor'=>$sensor,'state'=>$_['state']));

					if(!isset($_['webservice'])){
						header('location:index.php?module=room&id='.$sensor->getRoom());
					}else{
						$affirmations = array(	
							'A vos ordres!',
							'Bien!',
							'Oui commandant!',
							'Avec plaisir!',
							'J\'aime vous obéir!',
							'J\'y cours !',
							'Certainement!',
							'Je fais ça sans tarder!',
							'oui maîtresse !',
							'Oui chef!');
						$affirmation = $affirmations[rand(0,count($affirmations)-1)];
						$response = array('responses'=>array(
							array('type'=>'talk','sentence'=>$affirmation)
							)
						);

						$json = json_encode($response);
						echo ($json=='[]'?'{}':$json);
					}
				}else{
					$response = array('responses'=>array(
						array('type'=>'talk','sentence'=>'mais t\'es qui toi ?, je refuse de faire ça!')
						)
					);
					echo json_encode($response);
				}
				break;
			}
		}


		function sensor_plugin_preference_menu(){
			global $_;
			echo '<li '.(@$_['block']=='sensor'?'class="active"':'').'><a  href="setting.php?section=preference&block=sensor"><i class="icon-chevron-right"></i> Capteurs radio</a></li>';
		}
		function sensor_plugin_preference_page(){
			global $myUser,$_,$conf;
			if((isset($_['section']) && $_['section']=='preference' && @$_['block']=='sensor' )  ){
				if($myUser!=false){
					?>

					<div class="span9 userBloc">
						<form class="form-inline" action="action.php?action=sensor_plugin_setting" method="POST">

							<p>Pin du raspberry PI branché au récepteur radio: </p>
							<input type="text" class="input-large" name="receptorPin" value="<?php echo $conf->get('plugin_sensor_receptor_pin');?>" placeholder="Pin wiring PI...">

							<button type="submit" class="btn">Enregistrer</button>
						</form>
					</div>

					<?php }else{ ?>

					<div id="main" class="wrapper clearfix">
						<article>
							<h3>Vous devez être connecté</h3>
						</article>
					</div>
					<?php

				}
			}
		}

				
		Plugin::addHook("preference_menu", "sensor_plugin_preference_menu"); 
		Plugin::addHook("preference_content", "sensor_plugin_preference_page"); 
		Plugin::addHook("sensor_setvalue", "sensor_set_value"); 
		

		Plugin::addHook("action_post_case", "sensor_action_sensor");
		//Plugin::addHook("sensor_set_value",array("engine"=>$argv[2],"value"=>$argv[3],"positive"=>$argv[4]));
		//Plugin::addHook("action_post_case", "sensor_set_value");


		Plugin::addHook("node_display", "sensor_display");   
		Plugin::addHook("setting_bloc", "sensor_plugin_setting_page");
		Plugin::addHook("setting_menu", "sensor_plugin_setting_menu");  
		Plugin::addHook("setting_bloc", "sensortypes_plugin_setting_menu");  
		Plugin::addHook("vocal_command", "sensor_vocal_command");

		//Anonnce que le plugin propose un évenement à l'application lors du changement d'etat (cf Event::emit('relay_change_state') dans le code )
		Event::announce('sensor_change_state', 'Changement de l\'état d\'un relais radio',array('code radio'=>'int','etat'=>'string'));
		?>
