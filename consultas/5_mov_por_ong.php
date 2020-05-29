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
    $query = "select o.nombre_ong, o.mid, m.presupuesto, m. fecha  
    from organizan as o natural join  movilizaciones as m  
    order by presupuesto DESC;";

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
      <th>nombre ong</th>
      <th>mid</th>
      <th>presupuesto</th>
      <th>fecha</th>

    </tr>
  
      <?php
        foreach ($mov as $p) {
          echo "<tr><td>$p[0]</td><td>$p[1]</td><td>$p[2]</td><td>$p[3]</td></tr>";
      }
      ?>
      
  </table>

    </div>