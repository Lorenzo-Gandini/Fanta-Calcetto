<h1 class="text-center"><strong>Crea la tua squadra!</strong></h1>
<div class="mx-auto" style="width:65%">
	<form role="form" data-toggle="validator" method="POST" action="php/creaSq-exe.php">

		<div class="form-group">
			  <label><b>Nome</b></label>
			  	<input class="form-control" type="text" name="nomeSquadra" placeholder="Nome della tua squadra" data-required-error="Inserire nome" required/>
					<div class="help-block with-errors"></div>

		</div>
		<div class="form-group">
			  <label><b>Motto</b></label>
			  	<input class="form-control" type="text" name="mottoSquadra" placeholder="Motto della tua squadra" data-required-error="Inserire motto" required/>
					<div class="help-block with-errors"></div>

		</div>
		<div>
			<input type="submit" class="btn btn-primary" value="Continua"></input>
			<input type="reset" class="btn btn-danger btn-red" value="Cancella"></input>
		</div>

	</form>
</div>
