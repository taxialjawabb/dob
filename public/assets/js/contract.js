$(document).ready(function () {
    $("#driver_confirm").click(function (e) {
        e.preventDefault();
        let token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'post',
            url: "/driver/contract/send/code",
            data: {
                "_token": token,
                'id': "aaaaaaa",
                'date': "asdew"
            },
            success: function (data) {
                console.log(data);
            },
            error: function (e) {
                console.log('error');
                console.log(e);
            }
        });
    });
});
