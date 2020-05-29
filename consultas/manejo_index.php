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

  // #Se obtiene el valor del input del usuario
  $nombre = $_POST["busqueda"];
  $nombre = strval($nombre);
  $category = $_POST["consultasobre"];
  $category = strval($category);
  session_start();
  $_SESSION['nombre'] = $nombre;
  $_SESSION['category'] = $category;



  if(empty($nombre))
  {
    echo "<li>Estimado usuario olvidaste  ingresar un nombre!</li>";
  }
  if ($category == "")
  {   
    echo "<li> Estimado usuario olvidaste seleccionar tipo de cosa que buscaras</li>";
  }
  if ($category == "ONG")
  {
    $url .= '?nombre=Code';
   header("Location: mostrar_ongs.php? nombre = $nombre");
   exit;
  }
  ?>
  <form action=mostrar_proyectos.php  method="post"> 
  <select name = "tipo_proyecto">
    <option value="">Todas</option>
    <option value="Mina">Mina</option>
    <option value="Central">Central</option>
    <option value="Vertedero">Vertedero</option>
  </select> 
  <input type="submit" value="buscar" />
  </form>


<?php include('../templates/footer.html'); ?>