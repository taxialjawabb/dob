$(document).on("click",".attached img", function () {
    var clickedBtnID = $(this); // or var clickedBtnID = this.id
    console.log(clickedBtnID.attr('src'));
    var source = clickedBtnID.attr('src');
    $("#document, #note").attr('src', source);
    // var text =$('#'+clickedBtnID+ ' > p').text();
    // var content = $('.' + clickedBtnID).html(); 
    // var img =$('#'+clickedBtnID+ ' img').attr('src');

    // $('#mymodalTitle').text(text);
    // $('.card-body .card-text').html(content);
    // $('#mymodal .card-img-top').attr('src',img);
    // $('#mymodal').modal();

 });