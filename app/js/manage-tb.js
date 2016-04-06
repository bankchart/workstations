$(document).ready(function(){

    var body_table_id = $('#member-body-table');
    var records_per_table = $('#records-per-table');
    var records_in_page = $('#records-in-page');
    var search_mem_name = $('#search-mem-name');
    var search_name_form = $('#search-name-form');
    var checkbox_tb = $('.checkbox-tb');
    var once_manage_user_before_perform = undefined;
    var once_manage_user_perform = undefined;
    var perform_btn = undefined;
    var manage_user_ddl = $('.manage-user');

    getMemberBodyTable(body_table_id, records_per_table,
        records_in_page, search_mem_name);

    $('body').on('click', '.all-checkbox-tb', function(){
        $('.checkbox-tb').prop('checked', $(this).prop('checked'));
    });

    $('body').on('click', '.checkbox-tb', function(){
        if(!$(this).prop('checked'))
            $('.all-checkbox-tb').prop('checked', false);
    });

    $('#records-per-table')
    .on('change', function(){
        search_mem_name.val('');
        records_in_page.val(1);
        getMemberBodyTable(
                body_table_id, records_per_table,
                records_in_page, search_mem_name);
        });

    $('#records-in-page')
    .on('change', function(){
        search_mem_name.val('');
        getMemberBodyTable(
                body_table_id, records_per_table,
                records_in_page, search_mem_name);
        });

    $('body').on('click', '.checkbox-tb', function(){ // it's ok.
        var id = this.id;
        var isCheck = $(this).prop('checked');
        $('#test').html('id : ' + id + ', isChecked : ' + isCheck);
    });

    $(search_name_form).on('submit', function(){
        getMemberBodyTable(body_table_id, records_per_table,
                        records_in_page, search_mem_name);
        return false;
    });

    $('body').on('change', '.manage-user', function(){
        var id = (this.id).split('-')[0];
        var perform = this.options[this.selectedIndex].text;
        var nickname = $('#'+id+'-nickname-field').html();
        var message = 'Do you want to <u>' + perform + ' ' + nickname + '</u> ?';
        once_manage_user_perform = this.id + '*' + this.value;
        $('#message-alert').html(message);
        $('#title-alert').html('Confirm your perform');
        $('#modal-alert').modal();
    });

    $('body').on('focus', '.manage-user', function(){
        once_manage_user_before_perform = this.id + '*' + this.value;
        console.log(once_manage_user_before_perform);
    });

    $('#modal-alert').on('hidden.bs.modal', function(){
        if(once_manage_user_before_perform !== undefined){
            var temp = once_manage_user_before_perform.split('*');
            $('#' + temp[0]).val(temp[1]);
        }
    });

    $('#confirm-perform').on('click', function(){
        var temp = once_manage_user_perform.split('*');
        var user_id = temp[0].split('-')[0];
        var auth_str = temp[1];
        $('#modal-alert').modal('hide');
        /* start: update user-authority ajax */
        $.ajax({
            url: 'index.php?r=checklist/updateuserauthorityajax',
            data: {
                user_id : user_id,
                auth_str : auth_str
            },
            type: 'post',
            success: function(data){
                once_manage_user_before_perform = undefined;
                if(data == 'deleted')
                    getMemberBodyTable(body_table_id, records_per_table,
                        records_in_page, search_mem_name);
            }
        });
        /* end: update user-authority ajax */
    });

    $('#multiple-confirm-perform').on('click', function(){
        var temp = [];
        $('.checkbox-tb').each(function(){
            if($('#' + this.id).prop('checked'))
                temp.push((this.id).split('-')[0]);
        });
        $('#multiple-modal-alert').modal('hide');
        /* start: update user-authority ajax */
        $.ajax({
            url: 'index.php?r=checklist/multiplemanagememberperformajax',
            data: {
                perform: perform_btn.split('-')[0],
                users_id: temp.join()
            },
            type: 'post',
            success: function(data){
                if(data == 'completed')
                    getMemberBodyTable(body_table_id, records_per_table,
                        records_in_page, search_mem_name);
            },
            complete: function(){
                perform_btn = undefined;
            }
        });
        /* end: update user-authority ajax */
    });

    $('body').on('click', '.newbie-perform', function(){
        var temp = (this.id).split('-');
        var user_id = temp[0];
        var perform = temp[temp.length-1];
        $.ajax({
            url: 'index.php?r=checklist/' + perform + 'newbieperformajax',
            data: {user_id : user_id},
            type: 'post',
            success: function(data){
                if(data == 'deleted' || data == 'accepted')
                    getMemberBodyTable(body_table_id, records_per_table,
                        records_in_page, search_mem_name);
            }
        });
    });

    $('.multiple-perform').on('click', function(){
        var countCheckbox = 0;
        $('.checkbox-tb').each(function(){
            if($('#' + this.id).prop('checked'))
                countCheckbox++;
        });
        if(countCheckbox>0){
            perform_btn = this.id;
            $('#multiple-modal-alert').modal();
        }
    });

    function getMemberBodyTable(id, records, page, mem_name, message='loading...', delay=700){
        var defaultHtml = "<td style='text-align: center;' colspan='7'>" + message + "</td>";
        id.html(defaultHtml);
        setTimeout(function(){
            $.ajax({
                url: 'index.php?r=checklist/managememberajax',
                type: 'post',
                data: {
                    'records' : records.val(),
                    'page' : page.val(),
                    'search-mem-name' : mem_name.val()
                },
                dataType: 'json',
                success: function(data){
                    id.html(data.tbody_member);
                    page.html(data.page_dropdown_list_html);
                    $('.all-checkbox-tb').prop('checked', false);
                }
            });
        }, delay);
    }

});
