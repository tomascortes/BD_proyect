<?php 
  if ((function_exists('session_status') 
    && session_status() !== PHP_SESSION_ACTIVE) || !session_id()) {
    session_start();
  }
  if ((!isset($_SESSION['loggedin'])) || (($_SESSION['loggedin'] != 'socio') && ($_SESSION['loggedin'] != 'ong'))) {
    include('../templates/header.html');   
  }
  elseif ($_SESSION['loggedin'] == 'socio') {
    include('../templates/header_socio.html'); 
  }
  else {  # $_SESSION['loggedin'] == 'ong'
    include('../templates/header_ong.html'); 
  }
?>

<body>

<?php
  #Llama a conexión, crea el objeto PDO y obtiene la variable $db
  require("../config/conexion.php");

  // #Se obtiene el valor del input del usuario
  $nombre  = $_POST["nombre"];
  $nombre = strval($nombre);
  $nombre = str_replace('\'', '\'\'', $nombre);
  $tipo_p = $_POST["tipo_proyecto"];
  $tipo_p = strval($tipo_p);



  $query = "SELECT nombre_proyecto FROM proyectos WHERE  nombre_proyecto ILIKE '%$nombre%';";
  if ($nombre  == "")
  {
    if ($tipo_p == "")
    {
      $query = "SELECT nombre_proyecto FROM proyectos;";
    }
    elseif ($tipo_p == "Mina")
    {
      echo "<div>Proyectos correspondientes con minas </div>";
      $query = "SELECT nombre_proyecto FROM proyectos WHERE  nombre_proyecto IN  (select nombre_proyecto from minas);";
    }
    elseif ($tipo_p == "Central")
    {
      
      $query = "SELECT nombre_proyecto FROM proyectos WHERE  nombre_proyecto  IN  (select nombre_proyecto from centrales);";
    }
    elseif ($tipo_p == "Vertedero")
    {
      $query = "SELECT nombre_proyecto FROM proyectos WHERE  nombre_proyecto  IN  (select nombre_proyecto from vertederos);";
    }

}
  elseif ($tipo_p == "Mina")
{
    echo "<div>Proyectos correspondientes con minas </div>";
    $query = "SELECT nombre_proyecto FROM proyectos WHERE  nombre_proyecto ilike '%$nombre%' AND nombre_proyecto IN
    (select nombre_proyecto from minas);";
}
elseif ($tipo_p == "Central")
{

  $query = "SELECT nombre_proyecto FROM proyectos WHERE  nombre_proyecto ilike '%$nombre%' AND nombre_proyecto IN 
  (select nombre_proyecto from centrales);";
}
elseif ($tipo_p == "Vertedero")
{
  $query = "SELECT nombre_proyecto FROM proyectos WHERE  nombre_proyecto ilike '%$nombre%' AND nombre_proyecto IN 
  (select nombre_proyecto from vertederos);";
}

  #Se construye la consulta como un string
  #Se prepara y ejecuta la consulta. Se obtienen TODOS los resultados
	$result = $db -> prepare($query);
	$result -> execute();
	$pokemones = $result -> fetchAll();
  ?>

<div align="center">
  <table>
    <tr>
      <th>Nombre Proyecto</th>
    </tr>
  
      <?php
        foreach ($pokemones as $p) {
          echo "<tr><td><a href='proyectos.php?id=" . urlencode($p[0]) . "'>$p[0]</a></td></tr>";
      }
      ?>
      
  </table>

</div>