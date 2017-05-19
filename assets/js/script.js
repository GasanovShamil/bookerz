$(document).ready(function(){

    $("#myBtnMdp").click(function(){
        $("#myModalMdp").modal();
    });
    $("#myBtnInfo").click(function(){
        $("#myModalInfo").modal();
    });

    $("#sub").submit(function(event){
        event.preventDefault();

        var email = $("#inputEmail").val();
        var data = {'email': email};
        var url = base_url + "index.php/mail/sub";
        sendAjaxData("POST", data, "json", url);
        $('#sub').trigger("reset");
    });

    function sendAjaxData(type = "POST", data, datatype, url, cache = "false")
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
});
