$(document).ready(function(){

    var body_table_id = $('#member-body-table');
    var records_per_table = $('#records-per-table');
    var records_in_page = $('#records-in-page');
    var search_mem_name = $('#search-mem-name');
    var search_name_form = $('#search-name-form');

    getMemberBodyTable(body_table_id, records_per_table,
        records_in_page, search_mem_name);

    $('body').on('click', '.all-checkbox-tb', function(){
        $('.checkbox-tb').prop('checked', $(this).prop('checked'));
    });

    $('body').on('click', '.checkbox-tb', function(){
        if(!$(this).prop('checked'))
            $('.all-checkbox-tb').prop('checked', false);
    });

    $('#records-per-table, #records-in-page')
    .on('change', function(){getMemberBodyTable(
                                            body_table_id, records_per_table,
                                            records_in_page, search_mem_name, 0);
                                        });
    $(search_name_form).on('submit', function(){
        getMemberBodyTable(body_table_id, records_per_table,
                        records_in_page, search_mem_name, 0);
        return false;
    });

    function getMemberBodyTable(id, records, page, mem_name, delay=2000){
        console.log(mem_name.val());
        setTimeout(function(){
            $.ajax({
                url: 'index.php?r=checklist/managememberajax',
                type: 'post',
                data: {
                    'records' : records.val(),
                    'page' : page.val(),
                    'search-mem-name' : mem_name.val()
                },
                success: function(data){
                    id.html(data);
                }
            });
        }, delay);
    }

});
