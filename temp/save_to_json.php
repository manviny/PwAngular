<?php 

 
	/**
	 * 		Upgrade de cualquier pagina
	 *   	entrada:
	 *    		pageId 	=>	id de la pagina para hacer el upgrade
	 *      	data 	=>	datos de la pagina (litIcon, audioImagenes, lat ...)
	 * 
	 * @return [type] [description]
	 */
	
	function getPost(){
		$request = file_get_contents('php://input');
		return json_decode($request,true);
	}

	$getPost = getPost();


	/**
	 * GUARDA DATOS DE LA PAGINA EN LA BD
	 */

	$p = wire('pages')->get($getPost['pageId']);

	if(!$p->id) return; // si no existe, salir


	/**
	 * CONVIERTE LA PAGINA A JSON Y LA GUARDA EN UN FICHERO
	 */

	// $pagina = wire('pages')->get($pagina);
	$arr = array();	
	$array = array(); 

    // fields to be avoided
    $avoid = array("FieldtypeFieldsetOpen", "FieldtypeFieldsetClose","FieldtypeFieldsetTabOpen","FieldtypeFieldsetTabClose");
    
    // don't apply htmlentities
    $noEntities = array("FieldtypePageTitle", "FieldtypeText","FieldtypeTextarea");


	foreach($p->fields as $field) {


		if (!in_array($field->type, $avoid)) {


			// si es de tipo texto no htmlentities ( textarea, text...)
			if(in_array($field->type, $noEntities)) $array[$field->name] = $p->get($field->name);
			
			// otros tipos (imagenes, file ...)
			else $array[$field->name] = htmlentities($p->get($field->name));

		}
	}

	// Save page
	$bucket = "/var/www/html/patrimonio24" .wire('config')->urls->files . $p->id . "/" . $p->id .".json";
	 // si la pagina esta despublicada, borra el json
	if ($p->is(Page::statusUnpublished)){ 
		$array="";
	}

	file_put_contents($bucket, json_encode($array));
echo json_encode($array);
