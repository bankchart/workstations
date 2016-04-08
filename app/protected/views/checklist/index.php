<div class='well'>
    <h3 style='display: inline;'>My checklist</h3>
    <button id='add-checklist-btn' class='pull-right btn btn-default'>Add Checklist</button>
    <hr/>
    <div class='row'>
        <div class='col-sm-12'>
            <label>Show :</label>
            <select id='records-per-table' name='records-per-page'>
                <?php
                    foreach(Yii::app()->params['defaultPerPageTable'] as $n)
                        echo "<option value='$n'>$n</option>";
                ?>
            </select>
            <div class='pull-right'>
                <form id='search-topic-form' name='search-topic-form' action='#' method='post'>
                    <input title='Search topic name.' placeholder='Search topic name.'
                        name='search-topic-name' id='search-topic-name' class='form-control'
                        type='text'/>
                </form>
            </div>
        </div>
    </div>
    <div class='table-responsive' style='margin-top: 10px;'>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style='width: 20px;'>
                        <input type='checkbox' class='all-checkbox-tb'/>
                    </th>
                    <th style='width: 20px;'>#</th>
                    <th><?=Checklist::model()->attributeLabels()['checklist_topic']?></th>
                    <th><?=Checklist::model()->attributeLabels()['create_datetime']?></th>
                    <th><?=Checklist::model()->attributeLabels()['deadline_datetime']?></th>
                    <th><?=ChecklistStatus::model()->attributeLabels()['checklist_status_name']?></th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody id='checklist-body-table'>
                <tr><td colspan='7' style='text-align: center;'><i>empty</i></td></tr>
            </tbody>
        </table>
    </div><!-- end: .table-responsive -->
    <div class='row'>
        <div class='col-sm-12'>
            <button class='btn btn-default multiple-checklist-status-btn'
                id='done-checklist-btn'>done</button>
            <button class='btn btn-default multiple-checklist-status-btn'
                id='cancel-checklist-btn'>cancel</button>
            <div class='pull-right'>
                <label>page :</label>
                <select id='records-in-page' name='records-in-page'>
                    <option value='1'>1</option>
                </select>
            </div>
        </div>
    </div>
</div><!-- end: .well -->

<!-- start: add new checklist form  ajax -->
<div id='add-checklist-modal' class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id='title-add-checklist-modal'>Add new a checklist</h4>
            </div>
            <div class="modal-body" id='body-add-checklist-modal'>
                <form id='add-checklist-form' name='add-checklist-form' action='#' method='post'>
                    <div class="form-group">
                        <label for="topic-cl">Topic :</label>
                        <input type="text" class="form-control"
                            id="topic-cl" name='topic-cl' placeholder="Enter your topic"/>
                    </div>
                    <div class="form-group">
                        <label for="detail-cl">Detail :</label>
                        <textarea rows='5' id='detail-cl'
                            name='detail-cl' placeholder='Enter your detail'
                            class='form-control'></textarea>
                    </div>
                    <div class="form-group">
                        <label for="deadline-cl">Deadline :</label><br/>
                        <input id="deadline-cl" name='deadline-cl'
                                placeholder='Choose datetime' class='form-control'
                                type="text" >
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id='add-checklist-btn-modal'>Add</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- end: add new checklist form ajax) -->

<!-- start: confirm manage checklist-status -->
<div id='confirm-manage-checklist-status' class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confirm change checklist status</h4>
            </div>
            <div id='message-checklist-status' class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id='change-checklist-status-btn-modal' type="button" class="btn btn-primary">Yes, I do</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- end: confirm manage checklist-status -->

<!-- start: view checklist-detail -->
<div id='checklist-detail-modal' class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id='title-checklist-modal' class="modal-title">Checklist detail</h4>
            </div>
            <div id='checklist-detail-body-modal' class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- end: view checklist-detail -->

<input type='hidden' name='menu-active' value='<?php echo $menu_active; ?>'/>
<script type='text/javascript'>
//	$(document).ready(function(){
		$('ul.nav li').removeClass('active');
		$('#checklist').addClass('active');
//	});
</script>
<script type='text/javascript' src='<?php echo Yii::app()->request->baseUrl; ?>/js/manage-checklist.js?v=2'></script>
