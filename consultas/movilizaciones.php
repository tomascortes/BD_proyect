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

  $mov = urldecode($_GET['id']);
  $mov = str_replace('\'', '\'\'', $mov);

  
 	$query = "SELECT m.mid, m.presupuesto, m.fecha
      FROM movilizaciones as m
      WHERE m.mid = '$mov';";
	$oesult = $db -> prepare($query);
	$oesult -> execute();
    $movilizaciones = $oesult -> fetchAll();
    
    $query = "SELECT o.nombre_ong
    FROM ONGs as o
    WHERE o.nombre_ong IN (
        SELECT org.nombre_ong FROM Organizan AS org WHERE org.mid = '$mov'
    );";
  $oesult = $db -> prepare($query);
  $oesult -> execute();
  $movs = $oesult -> fetchAll();
  
    $query = "SELECT p.nombre_proyecto
    FROM Proyectos as p
    WHERE p.nombre_proyecto IN (
        SELECT r.nombre_proyecto FROM Rechazan AS r WHERE r.mid = '$mov'
    );";
  $oesult = $db -> prepare($query);
  $oesult -> execute();
  $proyectos = $oesult -> fetchAll();
  
  

  ?>

	<table>
    <tr>
      <th>ID</th>
      <th>Presupuesto</th>
      <th>Fecha</th>
    </tr>
  <?php
	foreach ($movilizaciones as $m) {
  		echo "<tr><td>$m[0]</td><td>$m[1]</td><td>$m[2]</td></tr>";
	}
  ?>
	</table>

	<table>
    <tr>
      <th>ONG asociada</th>
      <th>Proyecto al que se opone</th>
    </tr>
    <?php
  $cnt = 0;
  while ($cnt<count($movs) or $cnt<count($proyectos)) {
    $str = "<tr>";
    if ($cnt<count($movs))
      $str = $str . "<td><a href='ongs.php?id=" . urlencode($movs[$cnt][0]) ."'>" . $movs[$cnt][0] ."</a></td>";
    if ($cnt<count($proyectos))
      $str = $str . "<td><a href='proyectos.php?id=" . urlencode($proyectos[$cnt][0]) ."'>" . $proyectos[$cnt][0] ."</a></td>";
    echo $str . "</tr>";
    $cnt = $cnt + 1;
    }
  ?>
	</table>

</html>
