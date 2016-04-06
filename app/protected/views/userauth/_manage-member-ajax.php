<?php
    $no = $offset;
    $manage = UserType::model()->findAll();
    foreach($model as $record){
        $selected = array();
        $selected[0] = $record->auth_id == 2 ? 'selected' : '';
        $selected[1] = $record->auth_id == -2 ? 'selected' : '';
        $checkboxHtml = "<input class='checkbox-tb' id='$record->user_id-checkbox-manage-user'
                            type='checkbox'/>";
        if($record->auth_id == -1)
            $checkboxHtml = '';
        $ddl = "<i>newbie member</i> <a class='newbie-perform' id='$record->user_id-newbie-accept' href='#'>accept</a> or
                <a class='newbie-perform' id='$record->user_id-newbie-delete' href='#'>remove</a>";
        $signupDate = $record->signup == '0000-00-00 00:00:00' ? '-' : $record->signup;
        $acceptDate = $record->accept == '0000-00-00 00:00:00' ? '-' : $record->accept;
        if($record->auth_id != -1)
            $ddl = "
                <select id='$record->user_id-manage-user' class='manage-user'>
                    <option $selected[0] value='allow'>allow</option>
                    <option value='remove'>remove</option>
                    <option $selected[1] value='ban'>ban</option>
                </select>
            ";
        echo "
            <tr>
                <td>$checkboxHtml</td>
                <td>$no</td>
                <td id='$record->user_id-nickname-field'>$record->nickname</td>
                <td>$record->fullname</td>
                <td>$signupDate</td>
                <td>$acceptDate</td>
                <td>
                    $ddl
                </td>
            </tr>
        ";
        $no++;
    }
?>
