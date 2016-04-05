<?php
    $no = $offset;
    foreach($model as $record){
        echo "
            <tr>
                <td><input class='checkbox-tb' type='checkbox'/></td>
                <td>$no</td>
                <td>$record->username</td>
                <td>$record->fullname</td>
                <td>-</td>
                <td>-</td>
            </tr>
        ";
        $no++;
    }
?>
