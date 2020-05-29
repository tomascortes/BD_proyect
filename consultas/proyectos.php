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

  $proy = urldecode($_GET['id']);
  $proy = str_replace('\'', '\'\'', $proy);

 	$query = "SELECT p.*
      FROM Proyectos as p
      WHERE p.nombre_proyecto = '$proy';";
	$result = $db -> prepare($query);
	$result -> execute();
    $proyectos = $result -> fetchAll();

  $ptype = "Mina";
  $query = "SELECT m.nombre_proyecto
      FROM Minas as m
      WHERE m.nombre_proyecto = '$proy';";
	$result = $db -> prepare($query);
	$result -> execute();
    $mina = $result -> fetchAll();
        if ($mina[0][0]!= $proy) {
        $query = "SELECT c.nombre_proyecto
          FROM Centrales as c
          WHERE c.nombre_proyecto = '$proy';";
      $result = $db -> prepare($query);
      $result -> execute();
        $mina = $result -> fetchAll();
        if ($mina[0][0]!= $proy)
      $ptype = "Vertedero";
    else
      $ptype = "Central";
  };

    $query = "SELECT r.rid
    FROM Recursos as r
    WHERE r.rid IN (
        SELECT so.rid FROM Se_Opone AS so WHERE so.nombre_proyecto = '$proy'
    );";
  $result = $db -> prepare($query);
  $result -> execute();
  $recursos = $result -> fetchAll();

  ?>

	<table>
    <tr>
      <th>Nombre</th>
      <th>Activo</th>
      <th>Fecha Apertura</th>
      <th>Comuna</th>
      <th>Longitud</th>
      <th>Latitud</th>
      <th>Región</th>
      <th>Tipo</th>
    </tr>
  <?php
	foreach ($proyectos as $p) {
  		echo "<tr><td>$p[0]</td><td>$p[1]</td><td>$p[2]</td><td>$p[3]</td><td>$p[4]</td><td>$p[5]</td><td>$p[6]</td><td>$ptype</td></tr>";
	}
  ?>
	</table>

	<table>
    <tr>
      <th>Recursos asociados</th>
    </tr>
  <?php
	foreach ($recursos as $r) {
      echo "<tr><td><a href='recursos.php?id=" . urlencode($r[0]) . "'>$r[0]</a></td></tr>";
    }
  ?>
	</table>


</html>