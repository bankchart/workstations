<div class='well'>
	<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
	<hr/>
	<?php
		if(isset($signUpStatus)){
			if($signUpStatus == 'failed')
				echo "
				<div class='row'>
					<div class='col-sm-12'>
						<div class='alert alert-danger'>
							The username or password is incorrect.
						</div>
					</div>
				</div>
				";
		}
	?>
	<form class="form-horizontal" action='index.php?r=site/signup' method='post'>
		<div class="form-group">
			<label class='col-sm-2 control-label' for='username'>Username :</label>
			<div class="col-sm-5">
				<input type="text" class="form-control" name='username' id="username" placeholder="Enter Username">
			</div>
		</div>
		<div class="form-group">
			<label class='col-sm-2 control-label' for='password'>Password :</label>
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
		<div class='form-group'>
			<label class='col-sm-2 control-label'>Captcha :</label>
			<div class='col-sm-5'>
			<?php
				$this->widget('CCaptcha');
			?>
			<br/>
			<input placeholder='Please verify that you are human' class='form-control'
			style='margin-top: 5px; max-width: 250px;' type='text' name='captcha-code' />
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-5">
				<button type="submit" class="btn btn-default">Sign up</button>
			</div>
		</div>
	</form>
</div>
