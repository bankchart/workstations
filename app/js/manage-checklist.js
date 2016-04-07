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
    var once_checklist_status_before_perform = undefined;
    var once_checklist_status_perform = undefined;
    var multiple_perform_btn = undefined;

    var first_value_records_per_table = records_per_table.val();
    var first_value_records_in_page = records_in_page.val() == '' ? 0 : records_in_page.val();

    var topic_cl = $("#topic-cl");
    var detail_cl = $('#detail-cl');
    var deadline_cl = $('#deadline-cl');

    getCheckListBodyTable(body_table_id, records_per_table, records_in_page,
                            search_topic_name);

    $('body').on('click', '.all-checkbox-tb', function(){
        $('.checkbox-tb').prop('checked', $(this).prop('checked'));
    });

    $('body').on('click', '.checkbox-tb', function(){
        if(!$(this).prop('checked'))
            $('.all-checkbox-tb').prop('checked', false);
    });

    $('#add-checklist-btn').on('click', function(){
        $('#add-checklist-modal').modal();
    });

    $('#add-checklist-modal').on('hidden.bs.modal', function(){
        document.getElementById('add-checklist-form').reset();
    });

    $('#search-topic-form').on('submit', function(){
        //records_per_table.val(first_value_records_per_table);
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

    $('body').on('change', '.manage-checklist', function(){
        var message = 'Do you want to change status to ' +
                        this.options[this.selectedIndex].text + '?';
        once_checklist_status_perform = this.id + '*' + $(this).val();
        $('#message-checklist-status').html(message)
        $('#confirm-manage-checklist-status').modal();
    });

    $('#change-checklist-status-btn-modal').on('click', function(){
        /* console.log('confirm-change-checklist-status : ' + once_checklist_status_perform);*/

        /* start: multiple perform checklist-status...coding ... ajax */
        if(multiple_perform_btn !== undefined){
            var count = 0;
            var checklists = [];
            $('.checkbox-tb').each(function(){
                if($(this).prop('checked'))
                    checklists.push(this.id);
            });
            $.ajax({
                url: 'index.php?r=checklist/multiplechangecheckliststatusajax',
                data: {
                    checklists : checklists.join(),
                    perform : multiple_perform_btn
                },
                type: 'post',
                success: function(data){
                    if(data == 'completed')
                        alert('Changed status');
                },
                complete: function(){
                    $('#confirm-manage-checklist-status').modal('hide');
                    getCheckListBodyTable(body_table_id, records_per_table, records_in_page,
                                            search_topic_name);
                }
            });
            return false;
        }
        /* end: multiple perform checklist-status */

        var temp = once_checklist_status_perform.split('*');
        var id = temp[0].split('-')[0];
        var status = temp[1];
        $.ajax({
            url: 'index.php?r=checklist/changecheckliststatusajax',
            data: {
                id : id,
                status : status
            },
            type: 'post',
            success: function(data){
                if(data == 'completed')
                    alert('Changed status');
                else
                    alert('Can\'t change status');
            },
            complete: function(){
                $('#confirm-manage-checklist-status').modal('hide');
                getCheckListBodyTable(body_table_id, records_per_table, records_in_page,
                                        search_topic_name);
            }
        });
    });

    $('body').on('focus', '.manage-checklist', function(){
        once_checklist_status_before_perform = this.id + '*' + $(this).val();
    });

    $('#confirm-manage-checklist-status').on('hidden.bs.modal', function(){
        if(once_checklist_status_before_perform !== undefined){
            var temp = once_checklist_status_before_perform.split('*');
            var checklist_status_id = $('#' + temp[0]);
            checklist_status_id.val(temp[1]);
        }
        multiple_perform_btn = undefined;
        once_checklist_status_perform = undefined;
    });

     $('body').on('click', '.view-checklist-detail', function(){
         getChecklistDetail((this.id).split('-')[0]);
     });

     $('.multiple-checklist-status-btn').on('click', function(){
         var count = 0;
         $('.checkbox-tb').each(function(){
             count += $(this).prop('checked') ? 1 : 0;
         });
         if(count > 0){
             multiple_perform_btn = $(this).html();
             var message = 'Do you want to change multiple status ' + '?';
             $('#message-checklist-status').html(message)
             $('#confirm-manage-checklist-status').modal();
        }
    });

    function getChecklistDetail(id){
        $.ajax({
            url: 'index.php?r=checklist/getchecklistdetail',
            data: {
                id : id
            },
            type: 'post',
            dataType: 'json',
            success: function(data){
                if(data.response == 'failed'){
                    alert('Not found your checklist detail.');
                }else{
                    $('#checklist-detail-body-modal').html(data.detail);
                    $('#checklist-detail-modal').modal();
                }
            }
        });
    }

    function getCheckListBodyTable(id, records, page, topic_name, message='loading...', delay=700){
        var defaultHtml = "<tr><td style='text-align: center;' colspan='7'><i>" +
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
                if(data == 'failed')
                    alert('Incorrect in Adding Checklist Fields');
            }
        });
    }/* end: addNewCheckListAjax Fn. */
}); /* end: document.ready */
