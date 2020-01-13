<?php
// Guardo la salida en un buffer(en memoria)
// No se envia al navegador
ob_start();

?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>

<?php $auto = $_SERVER['PHP_SELF'];?>

<div class="container">
  <h2>Formulario de registro</h2>
  
  <form action="index.php?orden=Alta" method="POST" class="needs-validation" novalidate>
	<div class="row">
		<div class="col">
			<div class="form-group">
				<label for="id">Identificador:</label>
				<input type="text" class="form-control" id="id" placeholder="Introduzca un identificador" name="id" required
					value="<?=(isset($_POST['id']))?$_POST['id']:""?>">
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Por favor, introduzca un identificador</div>
			</div>
		</div>
		<div class="col">
			<div class="form-group">
				<label for="nombre">Nombre:</label>
				<input type="text" class="form-control" id="nombre" placeholder="Introduzca un nombre" name="nombre" required
					value="<?=(isset($_POST['nombre']))?$_POST['nombre']:""?>">
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Por favor, introduzca un nombre</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="form-group">
				<label for="mail">Email:</label>
				<input type="mail" class="form-control" id="mail" placeholder="Ejemplo@ejemplo.com" name="mail" required
					value="<?=(isset($_POST['mail']))?$_POST['mail']:""?>">
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Por favor, introduzca un email</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="form-group">
				<label for="password">Contraseña:</label>
				<input type="password" class="form-control" id="password" name="password" required
					value="<?=(isset($_POST['password']))?$_POST['password']:""?>">
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Por favor, introduzca una contraseña</div>
			</div>
		</div>
		<div class="col">
			<div class="form-group">
				<label for="password2">Confirme contraseña:</label>
				<input type="password" class="form-control" id="password2" name="password2" required
					value="<?=(isset($_POST['password2']))?$_POST['password2']:""?>">
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Por favor, confirme la contraseña contraseña</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="form-group">
			<label for="plan">Plan:</label>
			<select name="plan" class="form-control">
    			<option value="0">Básico</option>
    			<option value="1">Profesional</option>
    			<option value="2">Premium</option>
    			<option value="3">Máster</option></select>
			</div>
		</div>
        <div class="col">
			<div class="form-group">
			<label for="estado">Estado:</label>
			<select name="estado" class="form-control">
				<option value="A">Activo</option>
    			<option value="B">Bloqueado</option>
    			<option value="I">Inactivo</option>
			</select>
		</div>
	</div>
</div>
    <div class="row">	
	<div class="col">       
		<button type="submit" class="btn btn-primary" name="orden" id="alta" value="Alta">Registro</button>
	</div>
	<div class="col">  
		<button name="atras" class="btn btn-success"  id="atras" onclick="VolverListaUsuarios()" value="atras">Atrás</button>
		</div>
	</div>
  </form>
</div>


<?php 
// Vacio el bufer y lo copio a contenido
// Para que se mue p div de contenido de la página principal

$contenido = ob_get_clean();
include_once "principal.php";

?>
