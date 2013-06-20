<?php

namespace jordiaz\Ofertix\BannerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use jordiaz\Ofertix\BannerBundle\Model\Model;
use jordiaz\Ofertix\BannerBundle\Config\Config;

class DefaultController extends Controller
{
    public function indexAction()
    {

	$m = new Model(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario, Config::$mvc_bd_clave, Config::$mvc_bd_hostname);
	$params = array(
         'banners' => $m->dameBanners(),
         );

	/*Cuento el numero de banners*/
	$elementos= count($params['banners']);
	/*monto todos los banners*/
	
	for ($i = 0; $i < $elementos; $i++) {
		$banner[$i+1]="<a href=\"/app_dev.php/banners/listar?idb=". $params['banners'][$i]['id'] . "\" title = \"" 
		.$params['banners'][$i]['titulo']. "\"><img src=\"".$params['banners'][$i]['path']."\" alt=\""
		.$params['banners'][$i]['alt']."\" id=\"".$params['banners'][$i]['tiempo'] ."a\" height=\"170\" /></a>";
	}

	 $params = array(
         	'banners' => $m->dameBanners(),
		'banner'=> $banner,
		'elementos'=>$elementos,
             	'mensaje' => 'Rellena los siguientes campos',
             	'fecha' => date('d-m-yy'),
         );

	if(empty($_REQUEST['idb'])) {
	}else{
         	$resultado = array(
         	'query' => $m->agregarclick($_REQUEST['idb']),
         );
		header("Location: ".  $resultado['query'][0]['href']);
		exit();  
	}

        return $this->render('jordiazOfertixBannerBundle:Default:index.html.twig', $params);
    }

    public function listarAction()
     {
         $m = new Model(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario, Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

         $params = array(
         	'banners' => $m->dameBanners(),
         );

	/*Cuento el numero de banners*/
	$elementos= count($params['banners']);
	/*monto todos los banners*/
	
	for ($i = 0; $i < $elementos; $i++) {
		$banner[$i+1]="<a href=\"/app_dev.php/banners/listar?idb=
		". $params['banners'][$i]['id'] . "\" title = \"" .$params['banners'][$i]['titulo']. 
		"\"><img src=\"".$params['banners'][$i]['path']."\"  
		alt=\"".$params['banners'][$i]['alt']."\" id=\"".$params['banners'][$i]['tiempo'] ."a\" height=\"170\" /></a>";
	}

	 $params = array(
         	'banners' => $m->dameBanners(),
		'banner'=> $banner,
		'elementos'=>$elementos,
         );

	if(empty($_REQUEST['idb'])) {
	}else{
         	$resultado = array(
         		'query' => $m->agregarclick($_REQUEST['idb']),
         	);
		header("Location: ".  $resultado['query'][0]['href']);
		exit();  
	}

         return
          $this->render('jordiazOfertixBannerBundle:Default:mostrarBanners.html.twig', $params);
     }

     public function insertarAction()
     {

	$m = new Model(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario, Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

         $params = array(
         	'banners' => $m->dameBanners(),
         );

	/*Cuento el numero de banners*/
	$elementos= count($params['banners']);
	/*monto todos los banners*/
	
	for ($i = 0; $i < $elementos; $i++) {
    		
		$banner[$i+1]="<a href=\"/app_dev.php/banners/listar?idb=". $params['banners'][$i]['id'] . 
		"\" title = \"" .$params['banners'][$i]['titulo']. "\"><img src=\"".$params['banners'][$i]['path'].
		"\" alt=\"".$params['banners'][$i]['alt']."\" id=\"".$params['banners'][$i]['tiempo'] ."a\" height=\"170\" /></a>";
	}

         $params = array(
		 'id' => '',
		 'titulo' => '',
		 'alt' => '',
		 'path' => '',
		 'href' => '',
		 'tiempo' => '',
		 'clicks' => '',
		 'banners' => $m->dameBanners(),
		 'banner'=> $banner,
		 'elementos'=>$elementos,
		 'mensaje' => 'Rellena los siguientes campos',
		 'fecha' => date('d-m-yy'),
         );

         $m = new Model(Config::$mvc_bd_nombre, Config::$mvc_bd_usuario, Config::$mvc_bd_clave, Config::$mvc_bd_hostname);

         if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		 //Guardar imagen
		 $target_path = "bundles/jordiazofertixbanner/uploads/";
		 $target_path = $target_path . basename( $_FILES['file-input']['name']); 

		if(move_uploaded_file($_FILES['file-input'] ['tmp_name'], $target_path)){}

		 // comprobar campos formulario
		 if ($m->insertarBanner($_POST['id'],$_POST['titulo'],
		  $_POST['alt'], $target_path, $_POST['href'], $_POST['tiempo'],$_POST['clicks'])) {
		     $params['mensaje'] = 'Banner insertado correctamente';
		 } else {
		     $params = array(
			     'titulo' => $_POST['titulo'],
			     'alt' => $_POST['alt'],
			     'path' => $target_path,
			     'href' => $_POST['href'],
			     'tiempo' => $_POST['tiempo'],
			     'id' => $_POST['id'],
			     'clicks' => $_POST['clicks'],
			     'banners' => $m->dameBanners(),
			     'banner'=> $banner,
			     'elementos'=>$elementos,
		             'mensaje' => 'No se ha podido insertar el banner. Revisa el formulario',
		             'fecha' => date('d-m-yy'),
		     );
		 }
         }//if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         return
          $this->render('jordiazOfertixBannerBundle:Default:formInsertar.html.twig', $params);
     } 
}
