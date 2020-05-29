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

  $ong = urldecode($_GET['id']);
  $ong = str_replace('\'', '\'\'', $ong);
  
 	$query = "SELECT o.*
      FROM ONGs as o
      WHERE o.nombre_ong = '$ong';";
	$oesult = $db -> prepare($query);
	$oesult -> execute();
    $ongs = $oesult -> fetchAll();
    
    $query = "SELECT r.rid
    FROM Recursos as r
    WHERE r.rid IN (
        SELECT g.rid FROM Generan AS g WHERE g.nombre_ong = '$ong'
    );";
  $oesult = $db -> prepare($query);
  $oesult -> execute();
  $recursos = $oesult -> fetchAll();
  
    $query = "SELECT m.mid, m.presupuesto
    FROM Movilizaciones as m
    WHERE m.mid IN (
        SELECT o.mid FROM Organizan AS o WHERE o.nombre_ong = '$ong'
    )
    order by presupuesto DESC;";
  $oesult = $db -> prepare($query);
  $oesult -> execute();
  $movilizaciones = $oesult -> fetchAll();
  
  

  ?>

	<table>
    <tr>
      <th>Nombre</th>
      <th>Descripción</th>
      <th>País</th>
    </tr>
  <?php
	foreach ($ongs as $o) {
  		echo "<tr><td>$o[0]</td><td>$o[1]</td><td>$o[2]</td></tr>";
	}
  ?>
	</table>

	<table>
    <tr>
      <th>Recursos asociados</th>
      <th> <span style="display:inline-block; width: 22vw;"></span> </th>
      <th>Movilizaciones asociadas</th>
      <th>Presupuesto Movilizaciones</th>

    </tr>
  <?php
  $cnt = 0;
  while ($cnt<count($recursos) or $cnt<count($movilizaciones)) {
    $str = "<tr>";
    if ($cnt<count($recursos))
      $str = $str . "<td><a href='recursos.php?id=" . urlencode($recursos[$cnt][0]) ."'>" . $recursos[$cnt][0] ."</a></td>";
    if ($cnt<count($movilizaciones))
      $str = $str . '<td> <span style="display:inline-block; width: 22vw;"></span> </td>';
      $str = $str . "<td><a href='movilizaciones.php?id=" . urlencode($movilizaciones[$cnt][0]) ."'>" . $movilizaciones[$cnt][0] ."</a></td>";
      $str = $str . "<td>". $movilizaciones[$cnt][1] ."</a></td>";
    echo $str . "</tr>";
    $cnt = $cnt + 1;
    }
  ?>
	</table>

  </html>
