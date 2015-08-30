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
	$datos = $getPost['data']; 


	$p = wire('pages')->get($getPost['pageId']);

	if(!$p->id) return; // si no existe, salir

	$p->of(false); // turns off output formatting

	// Update todos los campos que tienen contenido en el json enviado desde la web
	foreach ($p->fields as $key => $value) {
		if ($datos["$value"] ){
		 $p->$value = $datos["$value"];
		}
	}
	$p->save();
