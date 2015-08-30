<?php 
// http://processwire.com/talk/topic/67-front-end-image-uploader-like-admin/page-2
 
	/**
	 * datos enviados mediante JSON
	 * @return [type] [description]
	 *     2 calls
     *     function (pageId, fieldName, '') -> deletes field
     *     function (pageId, fieldName, content) -> deletes element froma array
	 */
	function getPost(){
		$request = file_get_contents('php://input');
		return json_decode($request,true);
	}
	$getPost = getPost();

	$pageId = $getPost['pageId'];
	$fieldName = $getPost['fieldName'];
	$content = $getPost['content'];




	$pagina = wire('pages')->get($pageId);
	$campo = $pagina->get($fieldName);
	if($content=='') $campo = "";	// removes field
	else $campo->delete($content);	// removes item form array

  	$pagina->of(false); 
	$pagina->save();

?>