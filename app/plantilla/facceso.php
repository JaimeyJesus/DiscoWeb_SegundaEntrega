

<?php 

ob_start();
?>

<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>

<form method="GET" action="">

</form>

<div class="container">
  <h2>Formulario de acceso</h2>
  
  <form name='ACCESO' method="POST" action="index.php" class="needs-validation" novalidate>
	<div class="row">
		<div class="col">
			<div class="form-group">
				<label for="user">Usuario:</label>
				<input type="text" class="form-control" id="user" name="user" required
				value="<?= $user ?>">
				<div class="valid-feedback">OK</div>
				<div class="invalid-feedback">Por favor, introduzca nombre de usuario</div>
			</div>
			<div class="form-group">
				<label for="clave">Contraseña:</label>
				<input type="password" class="form-control" id="clave" name="clave" required
				value="<?= $clave ?>">
				<div class="valid-feedback">OK</div>
				<div class="invalid-feedback">Por favor, introduzca la contraeña</div>
			</div>
			<div class="form-group">
			<button name="orden" class="btn btn-primary" value="Entrar">Entrar</button>
			</div>
			<div class="form-group">
			<a href="index.php?orden=Nuevo" class="enlaceboton">Registrarse</a>
			</div>

		</div>
	</div>
<?php 

$contenido = ob_get_clean();
include_once "principal.php";

?>
