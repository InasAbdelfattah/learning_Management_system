$(function () {
    console.log('js started');

    //////////  active  ////////////////
    $('body').on('click', '.active', function ()
    {
        var user = {}
        if ($(this).val() == 'active')
        {
            console.log('active');

            user.active = 0;
            $(this).val('nonactive');
            $(this).removeClass('correctCss');
            $(this).addClass('falseCss');

        } else
        {

            console.log('nonactive');
            user.active = 1;
            $(this).val('active');
            $(this).removeClass('falseCss');
            $(this).addClass('correctCss');
        }
        row_id = $(this).data('rowid');
        console.log(row_id);
        $.ajax
                ({
                    url: row_id,
                    type: 'POST',
                    data: user,
                    success: function (data)
                    {
                        console.log(data);
                    }

                });

    });

///////////////////////////////////////////////////
//////////////////// admin ///////////////////////

    $('body').on('click', '.admin', function ()
    {
        var user = {}
        delet_id = $(this).data('deletid');
        if ($(this).val() == 'is_admin')
        {
            user.admin = 0;
            $(this).val('isnot_admin');
            $(this).removeClass('correctCss');
            $(this).addClass('falseCss');
            $('#delete'+delet_id).prop("disabled", false);
        } else
        {
            user.admin = 1;
            $(this).val('is_admin');
            $(this).removeClass('falseCss');
            $(this).addClass('correctCss');
            $('#delete'+delet_id).attr("disabled","disabled");
        }
        
        console.log(delet_id);

        row_id = $(this).data('rowid');
        console.log(row_id);
        $.ajax
                ({
                    url: row_id,
                    type: 'POST',
                    data: user,
                    success: function (data)
                    {
                        console.log(data);
                    }

                });

    });



/////////////////////////////////////////////////////

///////////////////// loged /////////////////////////


    $('body').on('click', '.loged', function ()
    {
        var user = {}
        if ($(this).val() == 'is_loged')
        {
            user.loged = 0;
            $(this).val('isnot_loged');
            $(this).removeClass('correctCss');
            $(this).addClass('falseCss');
        } else
        {
            user.loged = 1;
            $(this).val('is_loged');
            $(this).removeClass('falseCss');
            $(this).addClass('correctCss');
        }
        row_id = $(this).data('rowid');
        console.log(row_id);
        $.ajax
                ({
                    url: row_id,
                    type: 'POST',
                    data: user,
                    success: function (data)
                    {
                        console.log(data);
                    }

                });

    });





//////////////////////////////////////////////////////




///////////////////// delete /////////////////////////


    $('body').on('click', '.delete', function ()
    {

        row_id = $(this).data('rowid');
        console.log(row_id);
        $.ajax
                ({
                    url: row_id,
                    type: 'POST',
                    data: {},
                    success: function (data)
                    {
                        console.log(data);

                    }

                });
        $(this).parent().parent().remove();

    });





//////////////////////////////////////////////////////








});
