$(document).ready(function(){

    var body_table_id = $('#member-body-table');
    var records_per_table = $('#records-per-table');
    var records_in_page = $('#records-in-page');
    var search_mem_name = $('#search-mem-name');
    var search_name_form = $('#search-name-form');
    var checkbox_tb = $('.checkbox-tb');
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
                records_in_page, search_mem_name, 0);
        });

    $('#records-in-page')
    .on('change', function(){
        search_mem_name.val('');
        getMemberBodyTable(
                body_table_id, records_per_table,
                records_in_page, search_mem_name, 0);
        });

    $('body').on('click', '.checkbox-tb', function(){ // it's ok.
        var id = this.id;
        var isCheck = $(this).prop('checked');
        $('#test').html('id : ' + id + ', isChecked : ' + isCheck);
    });

    $(search_name_form).on('submit', function(){
        getMemberBodyTable(body_table_id, records_per_table,
                        records_in_page, search_mem_name, 0);
        return false;
    });

    $('body').on('change', '.manage-user', function(){
        var id = this.id;
        var value = $(this).val();
        $.ajax({
            url: 'index.php?r=checklist/managememberperformajax',
            type: 'post',
            data: {
                id: id,
                value: value
            },
            dataType: 'json',
            success: function(data){
                var objectPerform = data.objectPerform;
                var message = data.message;
                console.table(data);
            }
        });
    });

    function getMemberBodyTable(id, records, page, mem_name, delay=700){
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
                    page.html(data.page_dropdown_list_html)
                }
            });
        }, delay);
    }

});
