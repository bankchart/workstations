<?php
    $no = $offset;
    $manage = UserType::model()->findAll();
    foreach($model as $record){
        $selected = array();
        $selected[0] = $record->auth_id == 2 ? 'selected' : '';
        $selected[1] = $record->auth_id == -2 ? 'selected' : '';
        echo "
            <tr>
                <td><input class='checkbox-tb' id='$record->user_id' type='checkbox'/></td>
                <td>$no</td>
                <td>$record->nickname</td>
                <td>$record->fullname</td>
                <td>$record->signup</td>
                <td>
                    <select id='$record->user_id' class='manage-user'>
                        <option value='-1'>--choose--</option>
                        <option $selected[0] value='allow'>allow</option>
                        <option value='remove'>remove</option>
                        <option $selected[1] value='ban'>ban</option>
                    </select>
                </td>
            </tr>
        ";
        $no++;
    }
?>
