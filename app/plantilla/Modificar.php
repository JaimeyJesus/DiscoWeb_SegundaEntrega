<?php
// No se envia al navegador
ob_start();
?>
<div id='aviso'><b><?= (isset($msg))?$msg:"" ?></b></div>
<?php  
$auto = $_SERVER['PHP_SELF'];
$usuarioM=$usuarios[$usuarioid];

for ($j=0; $j < count($usuarioM); $j++){
}
?>


<div class="container">
  <h2>Formulario de modificación</h2>
  
  <form action="index.php?orden=Modificar" method="POST" class="needs-validation" novalidate>
	<div class="row">
		<div class="col">
			<div class="form-group">
				<label for="id">Identificador:</label>
				<input type="text" class="form-control" id="id" placeholder="Introduzca un identificador" name="id" required
				value="<?=(isset($usuarioid))?$usuarioid:''?>" readonly>
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Por favor, introduzca un identificador</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="form-group">
				<label for="nombre">Nombre:</label>
				<input type="text" class="form-control" id="nombre" placeholder="Introduzca un nombre" name="nombre" required
				value="<?=(isset($usuarioM[1]))?$usuarioM[1]:''?>">
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Por favor, introduzca un nombre</div>
			</div>
		</div>
		</div>
	
	<div class="row">
		<div class="col">
			<div class="form-group">
				<label for="mail">Email:</label>
				<input type="mail" class="form-control" id="email" placeholder="Ejemplo@ejemplo.com" name="email" required
				value="<?=(isset($usuarioM[2]))?$usuarioM[2]:''?>">
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Por favor, introduzca un email</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="form-group">
				<label for="clave">Contraseña:</label>
				<input type="password" class="form-control" id="clave" name="clave" required
				value="<?=(isset($usuarioM[0]))?$usuarioM[0]:''?>">
				<div class="valid-feedback">Valid.</div>
				<div class="invalid-feedback">Por favor, introduzca una contraseña</div>
			</div>
		</div>

	</div>
	<div class="row">
		<div class="col">
			<div class="form-group">
			<label for="plan">Plan:</label>
			<select name="plan" class="form-control" >
    			<option value="0" <?=($usuarioM[3]=='Básico')?'selected':''?>>Básico</option>
    			<option value="1" <?=($usuarioM[3]=='Profesional')?'selected':''?>>Profesional</option>
    			<option value="2" <?=($usuarioM[3]=='Premium')?'selected':''?>>Premium</option>
    			<option value="3" <?=($usuarioM[3]=='Máster')?'selected':''?>>Máster</option>
			</select>
			</div>
		</div>
		<div class="col">
			<div class="form-group">
				<label for="estado">Estado:</label>
				<select <?=($_SESSION['modo']!='1')?'id="deshabilitado"':'' ?> name="estado" class="form-control">
					<option value="A"<?=($usuarioM[4]=='Activo')?'selected':''?>>Activo</option>
    				<option value="B"<?=($usuarioM[4]=='Bloqueado')?'selected':''?>>Bloqueado</option>
    				<option value="I"<?=($usuarioM[4]=='Inactivo')?'selected':''?>>Inactivo</option>
				</select>
			</div>
		</div>
	</div>


	<div class="row">
		<div class="col">
    		<button type="submit" class="btn btn-primary" name="Modificar" id="Modificar" value="Modificar"
			onclick="confirmarModificar('<?= $usuarioM[0]."','".$usuarioM."'"?>)">Modificar</button>
		</div>	
		<div class="col">
			<input type="cancel"<?php 
			if($_SESSION['modo']==GESTIONUSUARIOS){?>
			onclick="javascript:document.location='index.php'" <?php
			}else{?>
			onclick="VerArchivos()" <?php }  ?>
			name="orden" class="btn btn-success"  id="atras" value="Atrás">
		</div>
	</div>
  </form>
</div>

<?php 
$contenido = ob_get_clean();
include_once "principal.php";
?>
