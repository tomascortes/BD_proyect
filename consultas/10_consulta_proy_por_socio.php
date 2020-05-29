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

	$socio = $_POST["socio"];
    $socio = strval($socio);

 	$query = "SELECT SociosProyectos.pnombre AS Proyectos FROM SociosProyectos, ConteoRecursos
	   WHERE SociosProyectos.pnombre = ConteoRecursos.pnombre AND SociosProyectos.snombre = '$socio'
	   ORDER BY ConteoRecursos.cont_recurso DESC;";
	$result = $db2 -> prepare($query);
	$result -> execute();
	$proyectos = $result -> fetchAll();
    ?>
	<div align="center">
		<table  class = "center">
		
		<?php include('../templates/footer.html'); ?>
		
		<form action="../index_entrega2.php" method="get">
			<input type="submit" value="Volver entrega 2">
		</form>
		</table>
    <br>

	<table>
    <tr>
      <th>Proyectos</th>
    </tr>
  <?php
	foreach ($proyectos as $proyectos) {
  		echo "<tr> <td>$proyectos[0]</td> </tr>";
	}
  ?>
	</table>

</div>
