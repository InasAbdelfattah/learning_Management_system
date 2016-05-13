$(function () {
    console.log('js started');
    $('#category').on('change', function () {
//        alert($('#category').val());
        catID = $('#category').val();
        var myDiv = document.getElementById('courses');
//        console.log(catID);
        $.ajax
                ({
                    url: catID,
                    type: 'GET',
                    data: {},
                    success: function (data)
                    {
                        console.log(data);
//                        console.log(data[0].course_name);
                        result = data;
                        var HTMLtxt = "<select name='course' class='form-control'>";
                        HTMLtxt += "<option value='0'>Please select category....</option>";
                        $.each(result, function (array, object) {
                            HTMLtxt += "<option value=" + object.id + ">" + object.course_name + "</option>";

                        });
                        HTMLtxt += '</select>';
                        myDiv.innerHTML = HTMLtxt;

                    }
                });


    });

 //////////  active  ////////////////
    $('body').on('click', '.active', function ()
    {
        var user = {}
        if ($(this).val() == 'active')
        {
            console.log('active');

            user.active = 0;
            $(this).val('nonactive');
        } else
        {

            console.log('nonactive');
            user.active = 1;
            $(this).val('active');
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
        if ($(this).val() == 'is_admin')
        {
            user.admin = 0;
            $(this).val('isnot_admin');
        } else
        {
            user.admin = 1;
            $(this).val('is_admin');
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



/////////////////////////////////////////////////////

///////////////////// loged /////////////////////////


$('body').on('click', '.loged', function ()
    {
        var user = {}
        if ($(this).val() == 'is_loged')
        {
            user.loged = 0;
            $(this).val('isnot_loged');
        } else
        {
            user.loged = 1;
            $(this).val('is_loged');
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