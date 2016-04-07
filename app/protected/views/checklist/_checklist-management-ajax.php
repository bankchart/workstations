<?php
    $no = $offset + 1;
    $checklistStatusModel = ChecklistStatus::model()->findAll(array(
        'condition' => 'checklist_status_name = "done" || checklist_status_name = "cancel"'
    ));
    $status_id = array();
    foreach($checklistStatusModel as $record){
        array_push($status_id, $record->checklist_status_id . '-' . $record->checklist_status_name);
    }
    foreach($model as $record) :
        $label = 'success';
        $temp = $record->checklist_status->checklist_status_name;
        if($temp == 'fail')
            $label = 'danger';
        elseif($temp == 'cancel')
            $label = 'default';
        elseif($temp == 'doing')
            $label = 'primary';
?>
    <tr>
        <td>
            <?php
            echo ($temp == 'doing') ?
            "<input type='checkbox' class='checkbox-tb'/>" : '';
            ?>
        </td>
        <td><?=$no?></td>
        <td><?=$record->checklist_topic?></td>
        <td><?=$record->create_datetime?></td>
        <td><?=$record->deadline_datetime == '0000-00-00 00:00:00' ?
                            '-' : $record->deadline_datetime?>
        </td>
        <td>
            <div style='font-size: 13px;' class='label label-<?=$label?>'>
                <?=$record->checklist_status->checklist_status_name?>
            </div>
        </td>
        <td>
            <?php if($record->checklist_status->checklist_status_name == 'doing') : ?>
            <select id='<?=$record->checklist_id?>-manage-checklist' class='manage-checklist'>
                <option>choose</option>
                <?php
                    foreach($status_id as $n){
                        $temp = explode('-', $n);
                        echo "<option value='$temp[0]'>$temp[1]</option>";
                    }
                ?>
            </select>
            &nbsp;<i>or <a id='<?=$record->checklist_id?>-checklist-detail' class='view-checklist-detail' href='#'>view</a></i>
            <?php else : ?>
                <i><a id='<?=$record->checklist_id?>-checklist-detail' class='view-checklist-detail' href='#'>view</a></i>
            <?php endif; ?>
        </td>
    </tr>
<?php
    $no++;
    endforeach;
?>
