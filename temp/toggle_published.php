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

	// esta despublicada -> publicala
	if ($pagina->is(Page::statusUnpublished)){
		echo "despublicada";
		$pagina->removeStatus(Page::statusUnpublished);
	}
	// esta publicada -> despublicala
	else {
		echo "publicada";
		$pagina->addStatus(Page::statusUnpublished);

	}
	$pagina->of(false);
	$pagina->save();

?>