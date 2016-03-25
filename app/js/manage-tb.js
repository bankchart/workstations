$(document).ready(function(){
    $('body').on('click', '.all-checkbox-tb', function(){
        $('.checkbox-tb').prop('checked', $(this).prop('checked'));
    });

    $('body').on('click', '.checkbox-tb', function(){
        if(!$(this).prop('checked'))
            $('.all-checkbox-tb').prop('checked', false);
    });
});
