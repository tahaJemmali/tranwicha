$(document).on('click', '#add-to-basket', function(event){
    event.preventDefault();
    $.ajax({
        url: $(this).attr('href'),
        type: 'GET',
        data: {"quantity": $("#quantity").val(), 'class': $(this).data('class')},
        success: function(data, response) {
            console.log(response);
        }
    });
});