<?php
include_once "Usuario.php";
ob_start();

?>


<?php  
$auto = $_SERVER['PHP_SELF'];
foreach($usuarios as $clave=>$valor){
  if($valor->user == $_GET['id']){
    $user=$usuarios[$clave];
  }
}
$numeroArchivos=0;
$espacioTotal=0;
$directorio="app/dat/".$_GET['id'];
if(is_dir($directorio)){
$gestor=opendir($directorio);
  while(($archivo=readdir($gestor))!==false){
  if( $archivo=="." || $archivo==".."){
      continue;
  }
  $numeroArchivos++;
  $espacioTotal +=round((filesize($directorio."/".$archivo)/1024),2);
}
}
?>

<div class="container">
<h2>Detalles de <?=$_GET['id']?></h2>
<table class="table table-hover">
<tbody>
    <tr>
      <th scope="row">Nombre</th>
    <td><?=$user->nombre?></td>
    </tr>
    <tr> 
    <th scope="row">Email</th>
    <td><?=$user->correo?></td>
    </tr>
    <tr>
    <th scope="row">Plan</th>
    <td><?=$user->plan?></td>
    </tr>
    <tr>
    <th scope="row">Número de ficheros</th>
    <td><?=$numeroArchivos?></td>
    </tr>
    <tr>
    <th scope="row">Espacio ocupado</th>
    <td><meter min="0" max="10000" low="5000" high="1000" optimum="0" value="<?=$espacioTotal?>"></meter></td>
</tr>
</tbody>
</table>
  <div class="row">
    <div class="col">
      <form action="index.php" method="POST" id="formularioDetalles">
	      <input type="submit" name="VerUsuarios" value="Volver">
      </form>  
    </div>
  </div>
</div>

     

<?php 
$contenido = ob_get_clean();
include_once "principal.php";
?>
