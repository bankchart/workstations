<div class='well'>
	<h3>Contact us</h3>
	<hr/>
	<?php
		if(isset($_GET['result'])){
			$result = $_GET['result'];
			if($result == 'incorrect_email')
				echo "
				<div class='alert alert-danger'>Incorrect email.</div>
				";
			elseif($result == 'empty_fullname_of_message')
				echo "
				<div class='alert alert-danger'>Empty fullname or message.</div>
				";
			elseif($result == 'incorrect_captcha_code')
				echo "
				<div class='alert alert-danger'>Incorrect captch code.</div>
				";
			elseif($result == 'wait'){}
			else
				echo "
				<div class='alert alert-success'>Send message completed.</div>
				";
		}
	?>
	<form class='form-horizontal' method='post' action='index.php?r=site/sendmessagecontact'>
		<div class='form-group'>
			<label class='col-sm-2 control-label' for='email-contact'>Email :</label>
			<div class='col-sm-5'>
				<input type='email' class='form-control' name='email-contact' id='email-contact'
				 	placeholder='Enter email'/>
			</div>
		</div>
		<div class='form-group'>
			<label class='col-sm-2 control-label' for='fullname-contact'>Fullname :</label>
			<div class='col-sm-5'>
				<input class='form-control' name='fullname-contact' id='fullname-contact'
					placeholder='Enter fullname'/>
			</div>
		</div>
		<div class='form-group'>
			<label class='col-sm-2 control-label' for='message-contact'>Message :</label>
			<div class='col-sm-5'>
				<textarea cols='30' name='message-contact' id='message-contact'
					placeholder='Enter message' class='form-control'></textarea>
			</div>
		</div>
		<div class='form-group'>
			<label class='col-sm-2 control-label' for='captcha-contact'>Captcha :</label>
			<div class='col-sm-5'>
				<?php $this->widget('CCaptcha'); ?>
				<br/>
				<input placeholder='Please verify that you are human' class='form-control'
				style='margin-top: 5px; max-width: 250px;' type='text' name='captcha-code-contact' />
			</div>
		</div>
		<div class='form-group'>
			<div class='col-sm-offset-2 col-sm-5'>
				<button type='submit' class='btn btn-default'>Submit</button>
			</div>
		</div>
	</form>
</div>

<input type='hidden' id='mene-active' value='<?php echo $menu_active; ?>'/>
<script type='text/javascript'>
	$(document).ready(function(){
		$('ul.nav li').removeClass('active');
		$('#contact').addClass('active');
	});
</script>
