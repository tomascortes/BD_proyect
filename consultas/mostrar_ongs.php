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
  $nombre = $_POST["nombre"];
  $nombre = strval($nombre);
  $nombre = str_replace('\'', '\'\'', $nombre);

  $query = "SELECT nombre_ong FROM ongs WHERE  nombre_ong ILIKE '%$nombre%';";
  if ($nombre == "")
  {
  $query = "SELECT nombre_ong FROM ongs;";
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
      <th>Nombre ONG</th>
    </tr>
  
      <?php
        foreach ($pokemones as $p) {
          echo "<tr><td><a href='ongs.php?id=" . urlencode($p[0]) . "'>$p[0]</a></td></tr>";          
      }
      ?>
      
  </table>

</div>