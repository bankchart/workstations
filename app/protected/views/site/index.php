<div class='container'>
	<div class='well'>
		<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
		<hr/>
		<form class="form-horizontal" action='index.php?r=site/signup' method='post'>
			<div class="form-group">
				<label for="username" class="col-sm-2 control-label">Username :</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" name='username' id="username" placeholder="Enter Username">
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="col-sm-2 control-label">Password :</label>
				<div class="col-sm-5">
					<input type="password" class="form-control" name='password' id="password" placeholder="Enter Password">
				</div>
			</div>
			<div class="form-group">
				<label for="confirm-password" class="col-sm-2 control-label">Confirm-Password :</label>
				<div class="col-sm-5">
					<input type="password" class="form-control" name='confirm-password' id="confirm-password" placeholder="Enter Confirm-Password">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-5">
					<button type="submit" class="btn btn-default">Sign up</button>
				</div>
			</div>
		</form>
	</div>
</div>
