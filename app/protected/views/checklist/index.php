<div class='well'>
    <h3 style='display: inline;'>Membership management</h3>
    <hr/>
    <div class='row'>
        <div class='col-sm-12'>
            <label>Show :</label>
            <select id='records-per-table'>
                <?php
                    foreach(Yii::app()->params['defaultPerPageTable'] as $value)
                        echo "<option value='$value'>$value</option>";
                ?>
            </select>
            <div class='pull-right'>
                <form id='search-name-form' action='#'>
                    <input title='Search nickname or fullname.' name='search-mem-name'
                        id='search-mem-name' placeholder='Search nickname or fullname.'
                        class='form-control' type='text'/>
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
                    <th><?=User::model()->attributeLabels()['nickname']?></th>
                    <th><?=User::model()->attributeLabels()['fullname']?></th>
                    <th><?=User::model()->attributeLabels()['signup']?></th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody id='member-body-table'>
                <!--tr>
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
                </tr-->
                <tr>
                        <td colspan='6' style='text-align: center;'>loading...</td>
                </tr>
            </tbody>
        </table>
    </div><!-- end: table-responsive -->
    <div class='row'>
        <div class='col-sm-12'>
            <div class='pull-right'>
                <label>page :</label>
                <select id='records-in-page'>
                    <?php
                        for($i=1;$i<=$pages;$i++)
                            echo "<option value='$i'>$i</option>";
                    ?>
                </select>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript' src='<?php echo Yii::app()->request->baseUrl; ?>/js/manage-tb.js'></script>
