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
                    }
                });


    });







});