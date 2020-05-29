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
 	$query = "SELECT pnombre AS Proyectos FROM RecursosProyectos
	  WHERE pnombre IN 
	  (SELECT pnombre FROM Proyectos WHERE poperativo)
	  AND rid IN (SELECT rid FROM Recursos_Tramitados
	  WHERE status = 'aprobado');";
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
	foreach ($proyectos as $proyecto) {
  		echo "<tr> <td>$proyecto[0]</td> </tr>";
	}
  ?>
	</table>

</div>