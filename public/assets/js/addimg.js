$(function(){
    // $('#profile-img-tag').hide();
    function readURL(input) {

        if (input.files && input.files[0]) {

            var reader = new FileReader();

            

            reader.onload = function (e) {

                $('#profile-img-tag').attr('src', e.target.result);
                $('#profile-img-tag').show();

            }

            reader.readAsDataURL(input.files[0]);

        }

    }

    $("#file").change(function(){

        readURL(this);

    });
    

});
