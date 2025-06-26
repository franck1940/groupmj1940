
function getRtOptionData(url, elementId) {

    $.post(url, function (data, status) {
        var obj = JSON.parse(data);
        $('#' + elementId).empty();
        $('#' + elementId).append($('<option>').val("").text(""));
        //{{ (item.id == selected)?'selected':'' }}
        $.each(obj, (el, value) => {
            x = JSON.parse(value)
            optionData = '<option value="' + x.id + '" {{ (item.id == selected)? "selected":"" }} >' + x.title + '</optin>';
            $('#' + elementId).append(optionData);
            console.log(x.id);
        });
        console.log("getOptionData():" + status);
    });
}

function getSbOptionData(url, elementId, rtelId, strId) {
    const rtVal = $("#" + rtelId).val();
    $('#' + strId).empty();
    $('#' + elementId).empty();
    if (rtVal) {
        $.post(url, {
            rootId: rtVal
        }, function (data, status) {
            var obj = JSON.parse(data);
            $('#' + elementId).empty();
            $('#' + elementId).append($('<option>').val("").text(""));
            $.each(obj, (el, value) => {
                x = JSON.parse(value)
                $('#' + elementId).append($('<option>')
                    .val(x.id).text(x.title));
                console.log(x.id);
            });

            console.log("getSbOptionData():" + status);
        });
    }
    $("#" + elementId).val($("#" + elementId).find(":selected").val()).change();
}

function showMenuSbSbMenuStructure(url, rdId, sbId, strId) {

    const rtVal = $("#" + rdId).find(":selected");
    const sbVal = $("#" + sbId).find(":selected");
    if (sbVal.val()) {
        $.post(url, {
            rootId: sbVal.val()
        }, function (data, status) {
            var obj = JSON.parse(data);
            $('#' + strId).empty();
            resp = '<ul id="' + rtVal.val() + '"><li  style="margin-left:10px;"> &#11208;<span id="t' + rtVal.val() + '">' +
                rtVal.text() + '</span> <img src="/public/images/pencil.ico" width="15px" height="15px"' +
                'id="mId' + rtVal.val() + '" onclick="' + "showInputField('ip" + rtVal.val() + "','el" + rtVal.val() + "','mId" + rtVal.val() + "')" + '" style="cursor: pointer;"/>' +
                '<div id="el' + rtVal.val() + '" style="display:none;">' +
                '<input type="text" id="ip' + rtVal.val() + '" value="' + rtVal.text() + '"/>' +
                '<button id="okbtn" onclick="' + "doUpdate('update','" + rtVal.val() + "','ip" + rtVal.val() + "','" + rtVal.text() + "','el" + rtVal.val() + "','formaction')" + '">OK</button>' +
                '<button  id="cancelbtn" onclick="' + "doCancel('el" + rtVal.val() + "','mId" + rtVal.val() + "')" + '">Cancel</button>' +
                '</div>' +
                '<img src="/public/images/icons8-trash-24.png"  width="15px" height="15px" onclick="' + "deleteMenu('delete','" + rtVal.val() + "','" + rtVal.text() + "','formaction')" + '" style="cursor: pointer;"/>';

            resp += '<ul id="' + sbVal.val() + '"><li><span style="margin-left:20px;">|_&#11208;<span id="t' + sbVal.val() + '">' +
                sbVal.text() + '</span></span>'
                + '<img src="/public/images/pencil.ico"  width="15px" height="15px"' +
                'id="mId' + sbVal.val() + '" onclick="' + "showInputField('ip" + sbVal.val() + "','el" + sbVal.val() + "','mId" + sbVal.val() + "')" + '" style="cursor: pointer;"/>' +
                '<div id="el' + sbVal.val() + '" style="display:none;">' +
                '<input type="text" id="ip' + sbVal.val() + '" value="' + sbVal.text() + '" required />' +
                '<button id="okbtn" onclick="' + "doUpdate('update','" + sbVal.val() + "','ip" + sbVal.val() + "','" + sbVal.text() + "','el" + sbVal.val() + "','formaction')" + '">OK</button>' +
                '<button  id="cancelbtn" onclick="' + "doCancel('el" + sbVal.val() + "','mId" + sbVal.val() + "')" + '">Cancel</button>' +
                '</div>' +
                '<img src="/public/images/icons8-trash-24.png" width="15px" height="15px" onclick="' + "deleteMenu('delete','" + sbVal.val() + "','" + sbVal.text() + "','formaction')" + '"  style="cursor: pointer;"/>'
                +
                '<ul>';
            $.each(obj, (el, value) => {
                x = JSON.parse(value)
                resp += '<li id="' + x.id + '">' +
                    '<span style="margin-left:40px;">|_<span id="t' + x.id + '">' +
                    x.title
                    + '</span><img src="/public/images/pencil.ico"  width="15px" height="15px"' +
                    'id="mId' + x.id + '" onclick="' + "showInputField('ip" + x.id + "','el" + x.id + "','mId" + x.id + "')" + '" style="cursor: pointer;"/>' +
                    '<div id="el' + x.id + '" style="display:none;">' +
                    '<input type="text" id="ip' + x.id + '" value="' + x.title + '" required/>' +
                    '<button id="okbtn" onclick="' + "doUpdate('update','" + x.id + "','ip" + x.id + "','" + x.title + "','el" + x.id + "','formaction')" + '">OK</button>' +
                    '<button  id="cancelbtn" onclick="' + "doCancel('el" + x.id + "','mId" + x.id + "')" + '">Cancel</button>' +
                    '</div>' +
                    '<img src="/public/images/icons8-trash-24.png"  width="15px" height="15px" onclick="' + "deleteMenu('delete','" + x.id + "','" + x.title + "','formaction')" + '" style="cursor: pointer;"/>'
                    + '</span></li>';

                console.log(x.id);
            });
            resp += '</ul></li></ul></li></ul>';
            $('#' + strId).append(resp);
            console.log("showMenuStruture():" + status);
        });
    }
}

function showInputField(inputId, containerId, mdfId) {
    $("#" + inputId).attr("type", "text");
    $("#" + containerId).attr("style", "display:inline;");
    $("#" + mdfId).attr("style", "display:none;");
}

function doCancel(elId, mdId) {
    $("#" + elId).attr("style", "display:none;");
    $("#" + mdId).attr("style", "display:'';");
}

function doUpdate(url, menuId, inputId, oldText, containerId, rspId) {
    const ipVal = $("#" + inputId).val();
    if (confirm("update old:[" + oldText + "] to new ->[" + ipVal + "]?") && ipVal) {
        $.post(url, {
            id: menuId,
            title: ipVal
        }, function (data, status) {
            console.log("doUpdate():" + status);
            console.log("doUpdate():" + data);
            if (data === 'successful')
                $("#" + rspId).attr("style", "color:green;").text("Update successful");

            if (data === 'failed')
                $("#" + rspId).attr("style", "color:red;").text("Update failed");

        });

        $("#" + containerId).attr("style", "display:none;");
        $("#t" + menuId).text(ipVal).change();
        $("#mId" + menuId).attr("style", "display:'';");
        console.log(containerId);
        // location.reload();
    }
}

function showInputField(inputId, containerId, mdfId) {
    $("#" + inputId).attr("type", "text");
    $("#" + containerId).attr("style", "display:inline;");
    $("#" + mdfId).attr("style", "display:none;");
}

function showMenuRtSbMenuStructure(url, rtSb, ctStrId) {
    const rtVal = $("#" + rtSb).find(":selected");
    if (rtVal.val()) {
        $.post(url, {
            rootId: rtVal.val()
        }, function (data, status) {
            var obj = JSON.parse(data);
            $('#' + ctStrId).empty();
            resp = '<ul id="' + rtVal.val() + '"><li  style="margin-left:10px;"> &#11208;<span id="t' + rtVal.val() + '">' + rtVal.text();
            resp += '</span>'
                + '<img src="/public/images/pencil.ico" width="15px" height="15px"' +
                'id="mId' + rtVal.val() + '" onclick="' + "showInputField('ip" + rtVal.val() + "','el" + rtVal.val() + "','mId" + rtVal.val() + "')" + '" style="cursor: pointer;"/>' +
                '<div id="el' + rtVal.val() + '" style="display:none;">' +
                '<input type="text" id="ip' + rtVal.val() + '" value="' + rtVal.text() + '" required/>' +
                '<button id="okbtn" onclick="' + "doUpdate('update','" + rtVal.val() + "','ip" + rtVal.val() + "','" + rtVal.text() + "','el" + rtVal.val() + "','formaction')" + '">OK</button>' +
                '<button  id="cancelbtn" onclick="' + "doCancel('el" + rtVal.val() + "','mId" + rtVal.val() + "')" + '">Cancel</button>' +
                '</div>' +
                '<img src="/public/images/icons8-trash-24.png" width="15px" height="15px"  onclick="' + "deleteMenu('delete','" + rtVal.val() + "','" + rtVal.text() + "','formaction')" + '" style="cursor: pointer;"/>'
                + '<ul>';
            $.each(obj, (el, value) => {
                x = JSON.parse(value);
                console.log(x.title);
                title = "deleteMenu('delete','" + x.id + "','" + x.title + "', 'formaction')";

                resp += '<li id="' + x.id + '">' +
                    '<span style="margin-left:20px;">|_<span id="t' + x.id + '">' +
                    x.title + '</span></span>'
                    + '<img src="/public/images/pencil.ico" width="15px" height="15px" ' +
                    'id="mId' + x.id + '" onclick="' + "showInputField('ip" + x.id + "','el" + x.id + "','mId" + x.id + "')" + '" style="cursor: pointer;"/>' +
                    '<div id="el' + x.id + '" style="display:none;">' +
                    '<input type="text" id="ip' + x.id + '" value="' + x.title + '" required/>' +
                    '<button id="okbtn" onclick="' + "doUpdate('update','" + x.id + "','ip" + x.id + "','" + x.title + "','el" + x.id + "','formaction')" + '">OK</button>' +
                    '<button  id="cancelbtn" onclick="' + "doCancel('el" + x.id + "','mId" + x.id + "')" + '">Cancel</button>' +
                    '</div>' +
                    '<img src="/public/images/icons8-trash-24.png" width="15px" height="15px"  style="cursor:pointer;"  onclick="' + title + '" >' +

                    '</li>';

                console.log(x.id);
            });
            resp += '</ul></li></ul>';
            $('#' + ctStrId).append(resp);
            console.log("showMenuStruture():" + status);
        });

    }
}

function showOnlyRtMenuStructure(url, ctStrId) {
    $.post(url, function (data, status) {
        var obj = JSON.parse(data);
        $('#' + ctStrId).empty();
        resp = '<ul>';
        $.each(obj, (el, value) => {
            x = JSON.parse(value);
            console.log(x.title);
            title = "deleteMenu('delete','" + x.id + "','" + x.title + "', 'formaction')";

            resp += '<li id="' + x.id + '">' +
                '<span style="margin-left:20px;"> &#11208;<span id="t' + x.id + '">' +
                x.title + '</span></span>'
                + '<img src="/public/images/pencil.ico" width="15px" height="15px" ' +
                'id="mId' + x.id + '" onclick="' + "showInputField('ip" + x.id + "','el" + x.id + "','mId" + x.id + "')" + '" style="cursor: pointer;"/>' +
                '<div id="el' + x.id + '" style="display:none;">' +
                '<input type="text" id="ip' + x.id + '" value="' + x.title + '" required/>' +
                '<button id="okbtn" onclick="' + "doUpdate('update','" + x.id + "','ip" + x.id + "','" + x.title + "','el" + x.id + "','formaction')" + '">OK</button>' +
                '<button  id="cancelbtn" onclick="' + "doCancel('el" + x.id + "','mId" + x.id + "')" + '">Cancel</button>' +
                '</div>' +
                '<img src="/public/images/icons8-trash-24.png" width="15px" height="15px"  style="cursor:pointer;"  onclick="' + title + '" >' +

                '</li>';

            console.log(x.id);
        });
        resp += '</ul>';
        $('#' + ctStrId).append(resp);
        console.log("showMenuStruture():" + status);
    });
}


function deleteMenu(url, mId, title, rspId) {
    if (confirm("Do you really want to delete this Menu:-" + title + "-?")) {
        $.post(url, {
            id: mId
        }, function (data, status) {
            $("#" + mId).remove();
            console.log("deleteMenu():" + status);
            console.log("deleteMenu():" + data);
            if (data === 'successful')
                $("#" + rspId).attr("style", "color:green;").text("Delete successful");

            if (data === 'failed')
                $("#" + rspId).attr("style", "color:red;").text("Delete failed");

            //location.reload();

        });

    }

}