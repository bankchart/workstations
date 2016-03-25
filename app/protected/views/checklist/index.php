<div class='well'>
    <h3 style='display: inline;'>Membership management</h3>
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
                    <input title='Search nickname or fullname.' placeholder='Search nickname or fullname.' class='form-control' type='text'/>
                </form>
            </div>
        </div>
    </div>
    <div class='table-responsive'>
        <table class="table table-bordered" style='margin-top: 10px;'>
            <thead>
                <tr>
                    <th style='width: 20px;'>
                        <input type='checkbox' class='all-checkbox-tb'/>
                    </th>
                    <th style='width: 20px;'>#</th>
                    <th>Nickname</th>
                    <th>Fullname</th>
                    <th>SignUp Date</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type='checkbox' class='checkbox-tb'/>
                    </td>
                    <td>1</td>
                    <td>111111</td>
                    <td>111111</td>
                    <td>111111</td>
                    <td>
                        <select>
                            <option>choose</option>
                            <option>Approve</option>
                            <option>Ban</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    </div><!-- end: table-responsive -->
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
</div>
<script type='text/javascript' src='<?php echo Yii::app()->request->baseUrl; ?>/js/manage-tb.js'></script>
