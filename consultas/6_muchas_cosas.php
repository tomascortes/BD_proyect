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


  #Se construye la consulta como un string
  $query = "select distinct * from consulta_6;";

  #Se prepara y ejecuta la consulta. Se obtienen TODOS los resultados
	$result = $db -> prepare($query);
	$result -> execute();
	$mov = $result -> fetchAll();
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
      <th>mid</th>
      <th>Nombre Proyecto</th>
      <th>presupuesto</th>
      <th>fecha</th>
      <th>duración</th>
      <th>contenido</th>
      <th>asistentes estimados</th>
      <th>lugar</th>

    </tr>
  
      <?php
        foreach ($mov as $p) {
          echo "<tr>
          <td>$p[0]</td>
          <td>$p[1]</td>
          <td>$p[2]</td>
          <td>$p[3]</td>
          <td>$p[4]</td>
          <td>$p[5]</td>
          <td>$p[6]</td>
          <td>$p[7]</td>
          </tr>";
      }
      ?>
      
  </table>
  </div>