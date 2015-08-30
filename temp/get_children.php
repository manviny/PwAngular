	<?php 

 
	/**
	 * datos enviados mediante JSON
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


	$pagina = wire('pages')->get($pageId);


		
    // fields to be avoided
    $avoid = array("FieldtypeFieldsetOpen", "FieldtypeFieldsetClose","FieldtypeFieldsetTabOpen","FieldtypeFieldsetTabClose");
    // fields that must be returned
    $wanted = $fields;

    // selector
    $paginas = $pagina->find($selector);

	$arr = array(); 
    foreach ($paginas as $child) {

		$array = array(); 

		foreach($child->fields as $field) {

			$array['id'] = $child->id;

			// if we dont' want all fields back
			if (  !in_array($field->type, $avoid)   &&   in_array($field->name, $wanted) && (count($wanted)>0) ) {
				$array[$field->name] = htmlentities($child->get($field->name));
			}

			// we want all fields back
			if (  !in_array($field->type, $avoid) && (count($wanted)==0) ) {
				$array[$field->name] = htmlentities($child->get($field->name));
			}			

		}
		array_push($arr, $array);
    }

	echo json_encode($arr);


?>