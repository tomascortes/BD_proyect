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

 	$query = "SELECT DISTINCT rregion AS Regiones
	 FROM Recursos WHERE rid NOT IN 
	 (SELECT rid FROM Recursos_Tramitados);";
	$result = $db2 -> prepare($query);
	$result -> execute();
	$regiones = $result -> fetchAll();
  ?>

	<table>
    <tr>
      <th>Region</th>
    </tr>
  <?php
	foreach ($regiones as $region) {
  		echo "<tr> <td>$region[0]</td> </tr>";
	}
  ?>
	</table>

<?php include('../templates/footer.html'); ?>
