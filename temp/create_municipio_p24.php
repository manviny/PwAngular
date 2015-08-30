	<?php 

 
	/**
	 * Guarda en un json 
	 * @return [type] [description]
	 */
	function getPost(){
		$request = file_get_contents('php://input');
		return json_decode($request,true);
	}
	$getPost = getPost();



	
	$pageId = $getPost['pageId'];

	// id del municipio
	$pagina = wire('pages')->get($pageId);

	// tipo de campos que no hay que guardar
	$avoidType = array("FieldtypeFieldsetOpen", "FieldtypeFieldsetClose","FieldtypeFieldsetTabOpen","FieldtypeFieldsetTabClose");
	// nombre de campos que no hay que guardar
	$avoidField = array("suscriptores", "marker");
    // don't apply htmlentities
    $noEntities = array("FieldtypePageTitle", "FieldtypeText","FieldtypeTextarea","InputfieldFileList");

	$arrayMunicipio = array(); 
	$arrayMunicipio['id'] = $pagina->id;
	$arrayMunicipio['hijos'] = array(); 


	// 1.- Guarda los campos del municipio
	
	foreach($pagina->fields as $field) {

		// guarda cada campo del municipio sino es del tipo avoidType o el nombre del campo es avoidField
		if ( !in_array($field->type, $avoidType) &&  !in_array($field->name, $avoidField) ) 

			// textarea, text , imagenes, audios
			if ( in_array($field->type, $noEntities)  ) 
				$arrayMunicipio[$field->name] = $pagina->get($field->name);
			// el resto 
			else 
				$arrayMunicipio[$field->name] = htmlentities($pagina->get($field->name));

	}

	// 2.- Guarda los hijos del municipio ( patrimonio, rutas, agenda, etc)
	
	foreach($pagina->children as $child) {

		$arrayHijosMunicipio = array();

		$arrayHijosMunicipio['id'] = $child->id;
		$arrayHijosMunicipio['title'] = $child->title;
		$arrayHijosMunicipio['template'] = "".$child->template; //cast

		$arrayNietos = array();

		// 3.- Guarda los nietos del municipio ( en lugares de interes->lits, en rutas->itinerarios, en agenda->noticias)
		
		foreach ($child->children as $nieto) { // patrimonio|rutas|agenda
			$arrayTemp = array();

			// campos de los nietos
			foreach ($nieto->fields as $field) {	// litIcon|title|audioAudio

				// guarda cada campo del municipio sino es del tipo avoidType o el nombre del campo es avoidField
				if ( !in_array($field->type, $avoidType) &&  !in_array($field->name, $avoidField) ) 

					// textarea, text , imagenes, audios
					if ( in_array($field->type, $noEntities)  ) 
						$arrayTemp[$field->name] = $nieto->get($field->name);
					// el resto 
					else 
						$arrayTemp[$field->name] = htmlentities($nieto->get($field->name));
			}
			
			// $arrayHijosMunicipio['hijos'] = $arrayNietos;
			array_push($arrayNietos, $arrayTemp);

		}

		$arrayHijosMunicipio['hijos'] = $arrayNietos;


		array_push($arrayMunicipio['hijos'], $arrayHijosMunicipio);
	}	



	/**
	 * Save page
	 * @var string
	 */
	$directorio = "/var/www/html/patrimonio24" .wire('config')->urls->files . $pagina->id ;
	$bucket = $directorio . "/data"  .".json";

	 // si la pagina esta despublicada, borra el json
	if ($pagina->is(Page::statusUnpublished)){ 
		$arr="";
	}

	// sino existe el directorio -> crealo
	if (!is_dir($directorio )) {
	  // dir doesn't exist, make it
	  mkdir($directorio);
	}

	file_put_contents($bucket, json_encode($arrayMunicipio));


	echo json_encode($arrayMunicipio);	


?>