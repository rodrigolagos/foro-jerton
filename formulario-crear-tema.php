<div class="container col-md-offset-3 col-md-6 col-xs-offset-1 col-xs-10" id="formulario-nuevo-tema">
		<div class="row">
			<div class="panel panel-default">
				<div style="padding: 15px" class="panel-heading">
			    	<h3 class="panel-title">Crear Tema</h3>
				</div>
				<div class="panel-body">
					<form id="form-crear-tema" class="form form-horizontal" role="form">
						<div id="form-titulo" class="form-group has-feedback">
						    <label class="control-label col-sm-3" for="titulo">Título</label>
						    <div class="col-sm-9">
						      	<input type="text" class="form-control" id="titulo" placeholder="Título del tema" maxlength="45" required>
						      	<span id="span-nickname-glyphicon" class="glyphicon form-control-feedback" aria-hidden="true"></span>
    							<span id="span-titulo" class="help-block with-errors"></span>
						    </div>
						</div>
						<div id="form-tipo" class="form-group has-feedback">
						    <label class="control-label col-sm-3">Tipo</label>
						    <div class="col-sm-9">
						      	
						      		<?php
						      			$resultado = $mysqli->query("SELECT tipo FROM CATEGORIAS WHERE id=".$id_categoria."");
						      			$categoria = $resultado->fetch_assoc();

						      			if($categoria['tipo']==1){
						      				echo 	'<div class="checkbox disabled">
						      							<label><input type="checkbox" id="tipo" value="0" disabled>Público</label>
						      						</div>';
						      			}else{
						      				echo 	'<div class="checkbox">
						      							<label><input type="checkbox" id="tipo" value="0">Público</label>
						      						</div>';
						      			}
						      		?>
								
						    </div>
						</div>
						<div id="form-contenido" class="form-group has-feedback">
						    <label class="control-label col-sm-3" for="contenido">Contenido</label>
						    <div class="col-sm-9">
					    		<textarea class="form-control" rows="5" id="contenido" placeholder="Escribe el contenido del tema.." required></textarea>
					    		<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    							<span id="span-contenido" class="help-block with-errors"></span>
						    </div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-3" for="crear"></label>
							<div class="col-sm-9">
								<button type="submit" id="crear" class="btn btn-primary">Crear</button>
							</div>
						</div>
					</form>
				</div>
			    	
			</div>
		</div>
		
</div>