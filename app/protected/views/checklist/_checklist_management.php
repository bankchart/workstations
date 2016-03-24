<div class='well'>
    <h3 style='display: inline;'>My Checklist</h3>
    <button class='pull-right btn btn-default'>Add Checklist</button>
    <hr/>
    <div class='row'>
        <div class='col-sm-12'>
            <label>Show :</label>
            <select>
                <option>10</option>
                <option>15</option>
                <option>30</option>
                <option>50</option>
            </select>
            <div class='pull-right'>
                <form>
                    <input title='Search topic name.' placeholder='Search topic name.' class='form-control' type='text'/>
                </form>
            </div>
        </div>
    </div>
    <div class='table-responsive' style='margin-top: 10px;'>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style='width: 20px;'>
                        <input type='checkbox'/>
                    </th>
                    <th style='width: 20px;'>#</th>
                    <th>Topic name</th>
                    <th>Create date</th>
                    <th>Deadline</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type='checkbox'/>
                    </td>
                    <td>1</td>
                    <td>111111</td>
                    <td>111111</td>
                    <td>111111</td>
                    <td>
                        <select>
                            <option>choose</option>
                            <option>Complete</option>
                            <option>Cancel</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    </div><!-- end: .table-responsive -->
    <div class='row'>
        <div class='col-sm-12'>
            <div class='pull-right'>
                <label>page :</label>
                <select>
                    <option>1</option>
                </select>
            </div>
        </div>
    </div>
</div><!-- end: .well -->
<input type='hidden' name='menu-active' value='<?php echo $menu_active; ?>'/>
<script type='text/javascript'>
	$(document).ready(function(){
		$('ul.nav li').removeClass('active');
		$('#checklist').addClass('active');
	});
</script>
