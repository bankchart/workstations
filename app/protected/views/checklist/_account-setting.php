<div class='container'>
    <div class='well'>
        <h3 style='display: inline;'>Account setting</h3>
        <button onclick='location.href="index.php?r=checklist/changepasswordform"' class='pull-right btn btn-default'>Change password</button>
        <hr/>

        <form class="form-horizontal" action='index.php?r=checklist/saveaccount' method='post'>
            <div class="form-group">
                <label class='col-sm-2 control-label'>Username :</label>
                <div class="col-sm-5">
                    <input type='text' disabled class='form-control' value='<?php echo $model->username; ?>' />
                </div>
            </div>
            <div class="form-group">
                <label class='col-sm-2 control-label'>Fullname :</label>
                <div class="col-sm-5">
                    <input type='text' disabled class="form-control" value='<?php echo $model->fullname; ?>'>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for='nickname'>Nickname :</label>
                <div class="col-sm-5">
                    <input value='<?php echo $model->nickname; ?>' type="text" class="form-control" name='nickname' id="nickname" placeholder="Enter Nickname">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-5">
                    <button type="submit" class="btn btn-default">Save</button>
                </div>
            </div>
        </form>

    </div>
</div>
<input type='hidden' id='account' value='<?php echo $menu_active; ?>' />
<script type='text/javascript'>
	$(document).ready(function(){
		$('ul.nav li').removeClass('active');
		$('#account').addClass('active');
	});
</script>
