$(document).ready(function(){
    $('#deadline-cl').datetimepicker({
        format:'Y-m-d H:i',
        step:15
        // onSelectTime:function(datetext){
        //     var d = new Date();
        //     var datetext = ("0" + d.getDate()).slice(-2) + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" +
        //                     d.getFullYear() + " " + ("0" + d.getHours()).slice(-2) + ":" +
        //                     ("0" + d.getMinutes()).slice(-2) + ":" +("0" + d.getSeconds()).slice(-2);
        //
        //     console.log('datetime text : ' + datetext);
        //     $('#deadline-cl').val(datetext);
        // }
    });

    var body_table_id = $('#checklist-body-table');
    var records_per_table = $('#records-per-table');
    var records_in_page = $('#records-in-page');
    var search_topic_name = $('#search-topic-name');
    var search_topic_form = $('#search-topic-form');

    var first_value_records_per_table = records_per_table.val();
    var first_value_records_in_page = records_in_page.val() == '' ? 0 : records_in_page.val();

    var topic_cl = $("#topic-cl");
    var detail_cl = $('#detail-cl');
    var deadline_cl = $('#deadline-cl');

    getCheckListBodyTable(body_table_id, records_per_table, records_in_page,
                            search_topic_name);

    $('#add-checklist-btn').on('click', function(){
        $('#add-checklist-modal').modal();
    });

    $('#add-checklist-modal').on('hidden.bs.modal', function(){
        document.getElementById('add-checklist-form').reset();
    });

    $('#search-topic-form').on('submit', function(){
        records_per_table.val(first_value_records_per_table);
        records_in_page.val(first_value_records_in_page);
        getCheckListBodyTable(body_table_id, records_per_table, records_in_page,
                                search_topic_name);
        return false;
    });

    $('#add-checklist-form').on('submit', function(){
        addNewCheckListAjax(topic_cl, detail_cl, deadline_cl);
        $("#add-checklist-modal").modal('hide');
        getCheckListBodyTable(body_table_id, records_per_table, records_in_page,
                                search_topic_name);
        return false;
    });

    $('#add-checklist-btn-modal').on('click', function(){
        $('#add-checklist-form').submit();
    });

    records_per_table.on('change', function(){
        records_in_page.val(1);
        getCheckListBodyTable(body_table_id, $(this), records_in_page,
                                search_topic_name);
    });

    records_in_page.on('change', function(){
        getCheckListBodyTable(body_table_id, records_per_table, $(this),
                                search_topic_name);
    });

    function getCheckListBodyTable(id, records, page, topic_name, message='loading...', delay=700){
        var defaultHtml = "<tr><td style='text-align: center;' colspan='6'><i>" +
                            message + "</i></td></tr>";
        id.html(defaultHtml);
        setTimeout(function(){
            $.ajax({
                url: 'index.php?r=checklist/checklistmanagementajax',
                type: 'post',
                data: {
                    'records-per-page' : records.val(),
                    'page' : page.val(),
                    'search-topic-name' : topic_name.val()
                },
                dataType: 'json',
                success: function(data){
                    if(data.is_empty == 'empty'){
                        id.html(defaultHtml.replace(message, data.is_empty));
                    }else{
                        id.html(data.checklist_body_table);
                    }
                    page.html(data.page_html);
                }
            });
        }, delay);
    }/* end: getCheckListBodyTable Fn. */

    function addNewCheckListAjax(topic, detail, deadline){
        $.ajax({
            url: 'index.php?r=checklist/addchecklistajax',
            type: 'post',
            data: {
                topic: topic.val(),
                detail: detail.val(),
                deadline: deadline.val()
            },
            success: function(data){
                console.log(data);
            }
        });
    }/* end: addNewCheckListAjax Fn. */
}); /* end: document.ready */
