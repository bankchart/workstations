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
?>
    <tr>
        <td><input type='checkbox'/></td>
        <td><?=$no?></td>
        <td><?=$record->checklist_topic?></td>
        <td><?=$record->create_datetime?></td>
        <td><?=$record->deadline_datetime == '0000-00-00 00:00:00' ?
                            '-' : $record->deadline_datetime?>
        </td>
        <td><?=$record->checklist_status->checklist_status_name?></td>
        <td>
            <select>
                <option>choose</option>
                <?php
                    foreach($status_id as $n){
                        $temp = explode('-', $n);
                        echo "<option value='$temp[0]'>$temp[1]</option>";
                    }
                ?>
            </select>
            &nbsp;<i>or <a href='#'>view</a></i>
        </td>
    </tr>
<?php
    $no++;
    endforeach;
?>
