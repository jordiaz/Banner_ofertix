<?php

 namespace jordiaz\Ofertix\BannerBundle\Model;

 class Model
 {
     protected $conexion;

      public function __construct($dbname,$dbuser,$dbpass,$dbhost)
  {
      $mvc_bd_conexion = mysql_connect($dbhost, $dbuser, $dbpass);

      if (!$mvc_bd_conexion) {
          die('No ha sido posible realizar la conexión con la base de datos: '
          . mysql_error());
      }
      mysql_select_db($dbname, $mvc_bd_conexion);

      mysql_set_charset('utf8');

      $this->conexion = $mvc_bd_conexion;
  }

     public function bd_conexion()
     {

     }

     public function dameBanners()
     {
         $sql = "select * from banners order by id asc";

         $result = mysql_query($sql, $this->conexion);

         $banners = array();
         while ($row = mysql_fetch_assoc($result))
         {
             $banners[] = $row;
         }

         return $banners;
     }

     public function buscarBannersPorId($id)
     {
         $id = htmlspecialchars($id);

         $sql = "select * from banners where id like '" . $id . "' order
 by id desc";

         $result = mysql_query($sql, $this->conexion);

         $banners = array();
         while ($row = mysql_fetch_assoc($result))
         {
             $banners[] = $row;
         }

         return $banners;
     }

     public function dameBanner($id)
     {
         $id = htmlspecialchars($id);

         $sql = "select * from banners where id=".$id;

         $result = mysql_query($sql, $this->conexion);

         $banners = array();
         $row = mysql_fetch_assoc($result);

         return $row;

     }

     public function insertarBanner($id, $titulo, $alt, $path, $href, $tiempo, $clicks)
     {

         $titulo = htmlspecialchars($titulo);
         $alt = htmlspecialchars($alt);
         $path = htmlspecialchars($path);
         $href = htmlspecialchars($href);
         $tiempo = htmlspecialchars($tiempo);
	 $clicks =0;

	//con esto cojo el ID mas grande y le sumo uno
	$rs = mysql_query("SELECT MAX(id) AS id FROM banners");
	if ($row = mysql_fetch_row($rs)) {
		$id = trim($row[0]);
		$id=$id+1;
	}

         $sql = "insert into banners (id, titulo, alt, path,
 href, tiempo, clicks) values ('" .
                 $id . "','" . $titulo . "','" . $alt . "','http://ofertix.dev/" . $path . "','" . $href . "'," . $tiempo . "," . $clicks . ")";

         $result = mysql_query($sql, $this->conexion);

         return $result;
     }



     public function agregarClick($id)
     {
         $id = htmlspecialchars($id);

	 $sql = "UPDATE banners SET clicks=(clicks + 1) WHERE id='$id'";	
	mysql_query($sql, $this->conexion);

         $sql = "select * from banners where id like '" . $id . "' order
 by id desc";

         $result = mysql_query($sql, $this->conexion);

         $banners = array();
         while ($row = mysql_fetch_assoc($result))
         {
             $banners[] = $row;
         }

         return $banners;
     }

 }
