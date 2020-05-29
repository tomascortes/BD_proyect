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

  $rec = urldecode($_GET['id']);
  $rec = str_replace('\'', '\'\'', $rec);

  
 	$query = "SELECT r.*
      FROM Recursos as r
      WHERE r.rid = '$rec';";
	$result = $db -> prepare($query);
	$result -> execute();
    $recursos = $result -> fetchAll();
    
    $query = "SELECT o.nombre_ong
    FROM ONGs as o
    WHERE o.nombre_ong IN (
        SELECT g.nombre_ong FROM Generan AS g WHERE g.rid = '$rec'
    );";
  $result = $db -> prepare($query);
  $result -> execute();
  $ongs = $result -> fetchAll();
  
    $query = "SELECT p.nombre_proyecto
    FROM Proyectos as p
    WHERE p.nombre_proyecto IN (
        SELECT s.nombre_proyecto FROM Se_Opone AS s WHERE s.rid = '$rec'
    );";
  $result = $db -> prepare($query);
  $result -> execute();
  $proyectos = $result -> fetchAll();
  
  

  ?>

	<table>
    <tr>
      <th>Id</th>
      <th>Descripción</th>
      <th>Comuna</th>
      <th>Fecha Apertura</th>
      <th>Área Influencia</th>
      <th>Causa Contaminante</th>
      <th>Región</th>
    </tr>
  <?php
	foreach ($recursos as $r) {
  		echo "<tr><td>$r[0]</td><td>$r[1]</td><td>$r[2]</td><td>$r[3]</td><td>$r[4]</td><td>$r[5]</td><td>$r[6]</td></tr>";
	}
  ?>
	</table>

	<table>
    <tr>
      <th>ONGs asociadas</th>
    </tr>
  <?php
	foreach ($ongs as $o) {
      echo "<tr><td><a href='ongs.php?id=" . urlencode($o[0]) . "'>$o[0]</a></td></tr>";
    }
  ?>
	</table>


    </table>

<table>
<tr>
  <th>Proyecto que busca cerrar</th>
</tr>
<?php
foreach ($proyectos as $p) {
  echo "<tr><td><a href='proyectos.php?id=" . urlencode($p[0]) . "'>$p[0]</a></td></tr>";
}
?>
</table>


</html>
