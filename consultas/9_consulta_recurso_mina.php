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
  require("../config/conexion.php"); #Llama a conexión, crea el objeto PDO y obtiene la variable $db

  $f1 = $_POST["fecha_1"];
  $f2 = $_POST["fecha_2"];

  $query = "SELECT DISTINCT RecursosProyectos.rid, RecursosProyectos.pnombre
   FROM RecursosProyectos, Recursos 
   WHERE RecursosProyectos.rid = Recursos.rid 
   AND Recursos.rfecha_apertura >= '$f1' 
   AND Recursos.rfecha_apertura <= '$f2' 
   AND RecursosProyectos.pnombre IN (SELECT Proyectos.pnombre FROM Proyectos WHERE Proyectos.ptipo = 1);";
  $result = $db2 -> prepare($query);
  $result -> execute();
  $dataCollected = $result -> fetchAll(); #Obtiene todos los resultados de la consulta en forma de un arreglo
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
      <th>Recurso</th>
      <th>Contra</th>
    </tr>
  
  <?php
  foreach ($dataCollected as $p) {
    echo "<tr>
    <td>$p[0]</td>
    <td>$p[1]</td>
    </tr>";
  }
  ?>
  </table>

</div>