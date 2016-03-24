<div class='well'>
    <h3 style='display: inline;'>Change password</h3>
    <hr/>
    <?php if(isset($_GET['result'])): ?>
        <?php
        if($_GET['result'] == 'failed')
            echo "<div class='alert alert-danger'>Incorrect your setting.</div>";
        elseif($_GET['result'] == 'success')
            echo "<div class='alert alert-success'>Your setting completed.</div>";
        ?>
    <?php endif; ?>
    <form class="form-horizontal" action='index.php?r=checklist/savenewpassword' method='post'>
        <div class="form-group">
            <label class='col-sm-3 control-label' for='old-password'>Old-password :</label>
            <div class="col-sm-5">
                <input placeholder='Enter Old-password' type='password' class='form-control' id='old-password' name='old-password' />
            </div>
        </div>
        <div class="form-group">
            <label class='col-sm-3 control-label' for='new-password'>New-password :</label>
            <div class="col-sm-5">
                <input placeholder='Enter New-password' type='password' class='form-control' id='new-password' name='new-password' />
            </div>
        </div>
        <div class="form-group">
            <label class='col-sm-3 control-label' for='confirm-new-password'>Confirm New-password :</label>
            <div class="col-sm-5">
                <input placeholder='Enter Confirm New-password' type='password' class='form-control' id='confirm-new-password' name='confirm-new-password' />
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                <button type="submit" class="btn btn-default">Change</button>
            </div>
        </div>
    </form>
</div>

<input type='hidden' id='change-password' value='<?php echo $menu_active; ?>' />
<script type='text/javascript'>
	$(document).ready(function(){
		$('ul.nav li').removeClass('active');
		$('#account').addClass('active');
	});
</script>
