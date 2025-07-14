function getUserOnline(url, containerId) {
    const container = $("#" + containerId);
    doPostOneData(url, 0, "getUserOnline()").then(function (data) {
        var obj = JSON.parse(data);
        console.log(obj);
        $("#" + containerId).empty();
        container.append("<table id='onlineUserList' style='border:1px solid #000; margin-top:2%; height:auto;'></table>");
        $.each(obj, (index, val) => {
            $("#onlineUserList").append("<tr id='row" + index + "' ></tr>");
            $("#row" + index).append("<td>" + val.username + "</td>");
           $("#row" + index).append("<td style='color:green;'>online </td>");
            console.log(val.username);
        });

    });


}