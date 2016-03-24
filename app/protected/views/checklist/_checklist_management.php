<div class='container'>
    <div class='well'>
        <h3>Table...</h3>
        <hr/>
    </div>
</div>
<input type='hidden' name='menu-active' value='<?php echo $menu_active; ?>'/>
<script type='text/javascript'>
	$(document).ready(function(){
		$('ul.nav li').removeClass('active');
		$('#checklist').addClass('active');
	});
</script>
