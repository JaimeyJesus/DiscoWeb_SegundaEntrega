<?php

ob_start();

?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php?orden=Mis Archivos">Mis Archivos <span class="sr-only"></span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?orden=Alta">Nuevo usuario</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?orden=Cerrar Sesión">Cerrar sesión</a>
      </li>

    </ul>
  </div>
</nav>
<?=(isset($msg))?'<p>'.$msg.'</p>':''?>

<div class="grid-cabecera-usuarios">
    <div class="grid-item-cabecera" id="CabId"><b>ID</b></div>
    <div class="grid-item-cabecera" id="CabNombre"><b>NOMBRE</b></div>
    <div class="grid-item-cabecera" id="CabCorreo"><b>CORREO</b></div>
    <div class="grid-item-cabecera" id="CabPlan"><b>PLAN</b></div>
    <div class="grid-item-cabecera" id="CabEstado"><b>ESTADO</b></div>
    <div class="grid-item-cabecera" id="CabBorrar"><b>OPERACIONES</b></div>
    <!-- <div class="grid-item-cabecera" id="CabModificar"><b>MODIFICAR</b></div> -->
    <!-- <div class="grid-item-cabecera" id="CabDetalles"><b>DETALLES</b></div> -->
</div>
    <?php
    $auto = $_SERVER['PHP_SELF'];    
    ?>
<div class="container-usuarios">
    <?php foreach ($usuarios as $clave => $datosusuario) : ?>    		
    	<div class="grid-item" id="identificador"><?= $clave ?></div>
	<?php for  ($j=1; $j < count($datosusuario); $j++) :?>
  <div class="grid-item"<?=($j==2)?"id='Correo'":''?>
  <?=($j==3)?"id='plan'":''?><?=($j==4)?"id='Estado'":''?>
  ><?=$datosusuario[$j] ?></div>
    	<?php endfor;?>
    <div class="grid-item"><a href="#"
		onclick="confirmarBorrar('<?= $datosusuario[1]."','".$clave."'"?>);">
		<img class="icono" title="borrar" src="web/img/papelera.png"></a>
	</div>
    <div class="grid-item"><a href="<?= $auto?>?orden=Modificar&id=<?= $clave ?>">
    	<img class="icono" title="modificar" src="web/img/editar.png"></a>
	</div>
    <div class="grid-item"><a href="<?= $auto?>?orden=Detalles&id=<?= $clave?>">
    	<img class="icono" title="detalles" src="web/img/ojo.png"></a>
	</div>


<?php endforeach; ?>
</div>
<?php

$contenido = ob_get_clean();
include_once "principal.php";

?>