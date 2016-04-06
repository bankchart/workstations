$(document).ready(function(){
    $('#deadline-cl').datetimepicker({
        format:'d-m-Y H:i',
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

    $('#add-checklist-btn').on('click', function(){
        $('#add-checklist-modal').modal();
    });

    $('#add-checklist-modal').on('hidden.bs.modal', function(){
        document.getElementById('add-checklist-form').reset();
    });

    function getCheckListBodyTable(id, records, page, topic_name, message='loading...', delay=700){
        var defaultHtml = "<td style='text-align: center;' colspan='6'>" + message + "</td>";
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
                    id.html(data.tbody_member);
                    page.html(data.page_dropdown_list_html);
                    $('.all-checkbox-tb').prop('checked', false);
                }
            });
        }, delay);
    }
});
