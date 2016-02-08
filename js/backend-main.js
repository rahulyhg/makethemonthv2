$(document).ready(function(){
    $('.main-content').css('min-height',$(window).height()-$('footer').height()-$('header').height()-40+'px');
    $('.has-filter span').click(function(){
        $(this).fadeOut(100);
        var el = $(this).parent('div').find('.filter');
        setTimeout(function(){
            $(el).fadeIn(200);
        },120)
    })
    $('.reset-filter').click(function(){
        $(this).parents('.has-filter').find('.filter').fadeOut(100);
        var el = $(this).parents('.has-filter').find('span');
        setTimeout(function(){
            $(el).fadeIn(200);
        },120)
    })
})
$(document).ready(function(){
    var filter = {};
    $('.reset-filter').click(function(){
        $(this).parents('.has-filter').find('.filter').fadeOut(100);
        if($(this).attr('id') == 'filter-type'){
            delete filter.type;
        }else{
            delete filter.city;
        }
        var el = $(this).parents('.has-filter').find('span');
        setTimeout(function(){
            $(el).fadeIn(200);
        },120)
        get_filer_questions(filter);
    })
    $('#filter-type').change(function(){
        filter.type = this.value;
        get_filer_questions(filter);
    })
    $('#filter-city').change(function(){
        filter.city = this.value;
        get_filer_questions(filter);
    })
})
function get_filer_questions(array){
    loading_bg();
    $('.pages').fadeOut(400);
    if(jQuery.isEmptyObject(array)){
        window.location.reload();
    }else{
        $.ajax({
            url:site_url+'ajax/get_filter',
            type:"POST",
            data:{'filters':array},
            success:function(response){
                done_loading();
                if(response){
                    $('#question-content').html(response);
                }else{
                    $('#question-content').html('<li>Nothing Found!</li>');
                }
            }
        })
    }
}
$(window).resize(function(){
    $('.main-content').css('min-height',$(window).height()-$('footer').height()-$('header').height()-40+'px');
})
function loading_bg(){
    $('.overlay-loading').fadeIn(200);
}
function done_loading(){
    $('.overlay-loading').fadeOut(200);
}
$(document).on('click','.show_help',function(){
    if($(this).is(':checked')){
        $('#'+$(this).attr('name')).fadeIn();
    }else{
        $('#'+$(this).attr('name')).fadeOut();
    }
});
$(function() {
    var min = $( "#from-date").val();
    var max = $( "#to-date").val();
    $( "#from-date" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        minDate:min,
        dateFormat: "yy-mm-dd",
        onClose: function( selectedDate ) {
            $( "#to-date" ).datepicker( "option", "minDate", selectedDate );
        }
    });
    $( "#to-date" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        maxDate:max,
        dateFormat: "yy-mm-dd",
        onClose: function( selectedDate ) {
            $( "#from-date" ).datepicker( "option", "maxDate", selectedDate );
        }
    });
});