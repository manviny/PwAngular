<?php

/**
 * 
 * 			SUBE IMAGENES AL SERVIDOR
 * 
 * 			entrada:	
 *  			paginaActual 	[id]			-> id de la pagina donde se guardara la imagen
 *  			image_field		[InputFieldTye] ->	nombre del campo donde se guardara la imagen (litIcon, images, audio...)
 *     			removeAll 		[true|false]   	-> borrar las imagenes que contenida anteriormente 
 */

// valores pasados desde angular http post
$paginaActual = $_POST["paginaActual"];	
$image_field = $_POST["image_field"];	
$removeAll = $_POST["removeAll"];		


/**
 * Sube imagenes a un lit que ya esta creado
 * @var [type]
 */
	
	if(isset($_FILES['file'])){
		/**
		 * Sube imagenes a una carpeta temporal del servidor
		 * enviadas desde https://github.com/danialfarid/angular-file-upload
		 */
	    //The error validation could be done on the javascript client side.
	    
	    $errors= array();        
	    $file_name = $_FILES['file']['name'];	
	    $file_size =$_FILES['file']['size'];
	    $file_tmp =$_FILES['file']['tmp_name'];
	    $file_type=$_FILES['file']['type'];   
	    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	    $extensions = array("jpeg","jpg","png");        
	    if(in_array($file_ext,$extensions )=== false){
	     $errors[]="image extension not allowed, please choose a JPEG or PNG file.";
	    }
	    if($file_size > 2097152){
	    $errors[]='File size cannot exceed 2 MB';
	    }        
    
	    if(empty($errors)==true){
	        move_uploaded_file($file_tmp, wire('config')->paths->assets . "files/.tmp_uploads/". $file_name);

	    	// Set Page on the ProcessWire page tree
			$p = wire('pages')->get($paginaActual);
			$p->of(false); // turns off output formatting
			
			// Run photo upload
		
			$pathname = wire('config')->paths->assets . "files/.tmp_uploads/". $file_name;

			// borra imagenes antiguas (si removeAll es true)
			if($removeAll=="true") {
				$p->$image_field->removeAll();
				$p->save();
			}

			// añade el file
			$p->$image_field->add($pathname);
			$p->message("Added file: $filename");
			unlink($pathname);
			$p->save();

			// crea imagenes de tamaño reducido  foto.jpg -> foto.640x480.jpg
			// http://processwire.com/api/fieldtypes/images/
			$campo = $p->get($image_field);
			foreach ($campo as $imagen) {
				$imagen->size(80);
				$imagen->size(477);
				$imagen->size(640);
				$imagen->size(800);
			}
	    }
	    else {
	        print_r($errors);
	    }
	} // $_FILES

$session->redirect($pages->get($input->post->paginaActual)->url);




