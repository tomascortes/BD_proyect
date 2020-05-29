<?php 
  if ((function_exists('session_status') 
    && session_status() !== PHP_SESSION_ACTIVE) || !session_id()) {
    session_start();
  }
  if ((!isset($_SESSION['loggedin'])) || (($_SESSION['loggedin'] != 'socio') && ($_SESSION['loggedin'] != 'ong'))) {
    include('templates/header_home.html');   
  }
  elseif ($_SESSION['loggedin'] == 'socio') {
    include('templates/header_home_socio.html'); 
  }
  else {  # $_SESSION['loggedin'] == 'ong'
    include('templates/header_home_ong.html'); 
  }
?>

<style>
body{background-image: url("http://www.omnarquitectos.cl/wp-content/uploads/2018/03/OMN-19-EDIFICIO-AULAS-SAN-JOAQUIN-06.jpg");}
h3{color: #FFFFFF}
form{color: #FFFFFF}
</style>

  <!-- <h1 align="center">Entrega 2 IIC2413 </h1> -->

  <img class="imagen" border="0" src="" align = center >

  <!-- <img class="imagen" border="0" src="https://k42.kn3.net/taringa/5/0/6/6/9/7/6/devilmankiller/286.gif" style="position:absolute; left: 60% ; top:2%" > -->
  <h3 align="center"> Busca ONGS. Si no escribes nada, se buscarán todas</h3>

  <body>
<form action="consultas/mostrar_ongs.php"  method="post">
  <input type="text" name="nombre" />
  <input type="submit" value="buscar" />
</form>

<h3 align="center"> Busca Proyectos. Si no escribes nombre se buscarán todas las de un tipo</h3>

<body>
<form action="consultas/mostrar_proyectos.php"  method="post">
<input type="text" name="nombre" />
<input type="submit" value="buscar" />

<select name = "tipo_proyecto">
    <option value="">Todas</option>
    <option value="Mina">Mina</option>
    <option value="Central">Central</option>
    <option value="Vertedero">Vertedero</option>
  </select> 

</form>



<p align="center">
<marquee scrollamount="15">Soy una consulta en wix!</marquee><br>
<marquee scrollamount="20">Soy una consulta con joins</marquee><br>
<marquee scrollamount="25">Soy una consulta con BD no relacionales</marquee><br>
<marquee scrollamount="135">Le pregunté a Rediz</marquee></p>


<form align="center" action="index_entrega2.php" method="post">
  <input type="submit" value="Consultas Entrega 2">
</form>

<marquee behavior="scroll" direction="right">
  <img src="https://image.jimcdn.com/app/cms/image/transf/none/path/s7a7866289313eaaa/image/i5f8936f5a2ca1dd6/version/1405717936/image.gif" width="120" height="80" alt="Natural" />
</marquee>

<!-- 
  <h3 align="center"> 2: Todos los recursos abiertos entre las fechas</h3>

  <form align="center" action="consultas/2_recursos_entre_fechas.php" method="post">
    Despues de:
    <input type="date" name="fecha_a">
    <br/>
    Antes de:
    <input type="date" name="fecha_b">
    <br/><br/>
    <input type="submit" value="Buscar">
  </form>
  
  <br>
  <br>
  <br>

  <h3 align="center"> 3: ONGS que participan en el proyecto </h3>


  <form align="center" action="consultas/3_ongs_participantes.php" method="post">
    Proyecto:
    <input type="text" name="proyecto">
    <br/><br/>
    <input type="submit" value="Buscar">
  </form>
  
  <br>
  <br>
  <br>

  <h3 align="center"> 4: Regiones con recurso vigente </h3>

  <form align="center" action="consultas/4_regiones.php" method="post">

    <input type="submit" value="Mostrar">
  </form>
  <br>
  <br>
  <br>

  <h3 align="center"> 5: Movilizaciones por ONG, ordenadas por presupuesto anual </h3>

  <form align="center" action="consultas/5_mov_por_ong.php" method="post">
    <br/><br/>
    <input type="submit" value="Buscar">
  </form>
  <br>
  <br>
  <br>


  <h3 align="center"> 6: Proyectos con recurso en trámite y todas las movilizaciones vigentes asociadas </h3>

  <form align="center" action="consultas/6_muchas_cosas.php" method="post">
    <br/><br/>
    <input type="submit" value="Buscar">
  </form>
  <br>
  <br>
  <img class="imagen" border="0" src="https://k38.kn3.net/taringa/2/5/2/5/6/1/08/vacumilka/8FA.gif">
  <marquee scrollamount="9" style="font-family: Arial; font-size: 10pt; color: #FF0000; font-weight: bold">BREAKING NEWS:&nbsp; 3 out of 4 people say this is a beautifull website!</marquee>
  <br> -->


