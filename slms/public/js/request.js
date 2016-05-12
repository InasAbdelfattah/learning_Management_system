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
                            HTMLtxt += "<option value="+ object.id+">" + object.course_name + "</option>";

                        });
                        HTMLtxt += '</select>';
                        myDiv.innerHTML = HTMLtxt;

                    }
                });


    });







});