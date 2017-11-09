  $('#radioBtn a').on('click', function(){
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#'+tog).prop('value', sel);
    
    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
});

$('.list-group-item').on('click',function(){
   $('li').removeClass('active');
    $(this).addClass('active');
        });
$('.list-group-item').hover(function()
                    {
                        $(this).addClass("active");                       
                    },
                    function()
                    {
                       $(this).removeClass("active");
                    } );               

     