<?php
    $no = $offset;
    $manage = UserType::model()->findAll();
    foreach($model as $record){
        $selected = array();
        $selected[0] = $record->auth_id == 2 ? 'selected' : '';
        $selected[1] = $record->auth_id == -2 ? 'selected' : '';
        $ddl = '<i>newbie member</i> <a href="#">accept</a> or <a href="#">remove</a>';
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
                <td><input class='checkbox-tb' id='$record->user_id-checkbox-manage-user' type='checkbox'/></td>
                <td>$no</td>
                <td id='$record->user_id-nickname-field'>$record->nickname</td>
                <td>$record->fullname</td>
                <td>$record->signup</td>
                <td>
                    $ddl
                </td>
            </tr>
        ";
        $no++;
    }
?>
