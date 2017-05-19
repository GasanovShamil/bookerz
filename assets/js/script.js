$(document).ready(function(){

    $("#sub").submit(function(event){
        event.preventDefault();

        var email = $("#inputEmail").val();
        var data = {'email': email};
        var url = base_url + "index.php/mail/sub";
        sendPostData("POST", data, "json", url);
    });

    function sendPostData(type = "POST", data, datatype, url, cache = "false")
    {
        $.ajax({
            type  : type,
            url   : url,
            dataType : datatype,
            data : data,
            cache: cache
        });
        return false;
    }
})
