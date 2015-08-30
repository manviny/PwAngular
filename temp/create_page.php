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

	// DATOS POST para crear la pagina
	$parent = wire('pages')->get($getPost['parent']); 
	$template = $getPost['template']; 
	$title = $getPost['title']; 
	$name =	$sanitizer->pageName($title, true);
 
	echo $parent->title ." , ".$template." , ".$title." , ".$name;


	// Crea la pagina

  	$p = new Page();

  	$p->template = $template;
  	$p->parent = $parent;
  	$p->title = $title; 
  	$p->name = $name;


  	$p->of(false); 
	$p->save();
