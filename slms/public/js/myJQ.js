$(function(){
	
    $('#delete').click(function(event) {
        event.preventDefault();

        $.ajax({
                url: 'validatem.php?action=update',
                type: 'GET',
                data: useredit,
                success: function (response) {
                        console.log(response);

                },
                error: function (error) 
                {
                        console.log(error);
                }
        })

    });