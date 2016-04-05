<?php
    $no = $offset;
    foreach($model as $record){
        $selected = $record->auth_id != -1 ? 'selected' : '';
        echo "
            <tr>
                <td><input class='checkbox-tb' id='$record->user_id' type='checkbox'/></td>
                <td>$no</td>
                <td>$record->nickname</td>
                <td>$record->fullname</td>
                <td>$record->signup</td>
                <td>
                    <select class='manage-user'>
                        <option value='-1'>--choose--</option>
                        <option $selected value='allow'>allow</option>
                        <option value='remove'>remove</option>
                        <option value='ban'>ban</option>
                    </select>
                </td>
            </tr>
        ";
        $no++;
    }
?>
