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



		$pagina = wire('pages')->get($pageId);

		$array = array(); 

        // fields to be avoided
        $avoid = array("FieldtypeFieldsetOpen", "FieldtypeFieldsetClose","FieldtypeFieldsetTabOpen","FieldtypeFieldsetTabClose");

		foreach($pagina->fields as $field) {
			if (!in_array($field->type, $avoid)) {
				// si el campo no esta vacio
				if( htmlentities($pagina->get($field->name)) )
					$array[$field->name] = htmlentities($pagina->get($field->name));
			}
		}
		echo json_encode($array);

?>