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
                    <th><?=User::model()->attributeLabels()['accept']?></th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody id='member-body-table'>
                <tr><td colspan='6' style='text-align: center;'>empty</td></tr>
            </tbody>
        </table>
    </div><!-- end: table-responsive -->
    <div class='row'>
        <div class='col-sm-12'>
            <button id='allow-btn' class='btn btn-default multiple-perform'>allow</button>
            <button id='remove-btn' class='btn btn-default multiple-perform'>remove</button>
            <button id='ban-btn' class='btn btn-default multiple-perform'>ban</button>
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
<!-- message modal (update user-authority ajax) -->
<div id='modal-alert' class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id='title-alert'>Modal title</h4>
            </div>
            <div class="modal-body" id='message-alert'>
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id='confirm-perform'>Yes, I do</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- message modal (update user-authority ajax) -->

<!-- message modal (multiple user-authority ajax) -->
<div id='multiple-modal-alert' class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id='multiple-title-alert'>Confirm your perform</h4>
            </div>
            <div class="modal-body" id='multiple-message-alert'>
                <p>
                    Do you want to perform multiple authority?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id='multiple-confirm-perform'>Yes, I do</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- message modal (multiple user-authority ajax) -->
<script type='text/javascript' src='<?php echo Yii::app()->request->baseUrl; ?>/js/manage-tb.js?v=1'></script>
