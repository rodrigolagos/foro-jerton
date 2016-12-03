<div class="container col-md-offset-3 col-md-6 col-xs-offset-1 col-xs-10" id="formulario-editar-comentario">
		<div class="row">
			<div class="panel panel-default">
				<div style="padding: 15px" class="panel-heading">
			    	<h3 class="panel-title">Editar Comentario</h3>
				</div>
				<div class="panel-body">
					<form id="form-editar-comentario" class="form form-horizontal" role="form">
						<div id="form-contenido" class="form-group has-feedback">
						    <label class="control-label col-sm-3" for="contenido">Contenido</label>
						    <div class="col-sm-9">
					    		<textarea class="form-control" rows="5" id="contenido" required><?php echo $comentario['contenido']; ?></textarea>
					    		<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    							<span id="span-contenido" class="help-block with-errors"></span>
						    </div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-3" for="crear"></label>
							<div class="col-sm-9">
								<button type="submit" id="crear" class="btn btn-primary btn-editar-comentario" coment="<?php echo $comentario['id']; ?>">Editar</button>
							</div>
						</div>
					</form>
				</div>
			    	
			</div>
		</div>
		
</div>