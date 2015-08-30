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
	$selector = $getPost['selector']; 
	$fields = $getPost['fields']; 
	$title = $getPost['title']; 


	$pagina = wire('pages')->get($pageId);


		

    // fields that must be returned
    $wanted = $fields;

    // selector
    $paginas = $pagina->find($selector);

    // don't apply htmlentities
    $noEntities = array("FieldtypePageTitle", "FieldtypeText","FieldtypeTextarea");

	$arr = array(); 
    foreach ($paginas as $child) {

		$array = array(); 

		// add id to json
		$array['id'] = $child->id;

		// adds template type if in $wanted array
		if(in_array('template', $wanted)) $array['template'] = htmlentities($child->template);
		
		// resto de los campos			
		foreach($child->fields as $field) {

			// if we dont' want all fields back
			if ( in_array($field->name, $wanted) ) {

				// si es de tipo texto no htmlentities ( textarea, text...)
				if(in_array($field->type, $noEntities)) $array[$field->name] = $child->get($field->name);
				
				// otros tipos (imagenes, file ...)
				else $array[$field->name] = htmlentities($child->get($field->name));

			}		

		}
		array_push($arr, $array);
    }




	/**
	 * Save page
	 * @var string
	 */
	$directorio = "/var/www/html/patrimonio24" .wire('config')->urls->files . $pagina->id ;
	$bucket = $directorio . "/" . $title .".json";

	 // si la pagina esta despublicada, borra el json
	if ($pagina->is(Page::statusUnpublished)){ 
		$arr="";
	}

	// sino existe el directorio -> crealo
	if (!is_dir($directorio )) {
	  // dir doesn't exist, make it
	  mkdir($directorio);
	}

	file_put_contents($bucket, json_encode($arr));
	
echo json_encode($arr);

?>