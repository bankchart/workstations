<?php
    $no = $offset + 1;
    foreach($model as $record) :
?>
    <tr>
        <td><input type='checkbox'/></td>
        <td><?=$no?></td>
        <td><?=$record->checklist_topic?></td>
        <td><?=$record->create_datetime?></td>
        <td><?=$record->deadline_datetime == '0000-00-00 00:00:00' ?
                            '-' : $record->deadline_datetime?></td>
        <td>
            <select>
                <option>choose</option>
                <option value='done'>done</option>
                <option value='cancel'>cancel</option>
            </select>
            &nbsp;<i>or <a href='#'>view</a></i>
        </td>
    </tr>
<?php
    $no++;
    endforeach;
?>
