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

  #Se obtiene el valor del input del usuario
  $fecha_a = $_POST["fecha_a"];
  // $fecha_a = dateval($fecha_a);
  // $fecha_a = date('Y/m/d H:i:s', $fecha_a); 
  $fecha_b = $_POST["fecha_b"];
  // $fecha_b = intval($fecha_b);
  // $fecha_a = date('Y/m/d H:i:s', $fecha_a); 


  #Se construye la consulta como un string
     $query = "select rid,fecha_apertura from no_dictaminados 
     where DATE(fecha_apertura) >= '$fecha_a' and DATE(fecha_apertura) <= '$fecha_b';";

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
      <th>Rid</th>
      <th>Fecha</th>

    </tr>
  
      <?php
        foreach ($mov as $p) {
          echo "<tr><td>$p[0]</td><td>$p[1]</td></tr>";
      }
      ?>
  </table>
</div>
