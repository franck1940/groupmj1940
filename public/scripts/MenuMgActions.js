
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

$(function () {
    $("p").click(function () {
        let id = $(this).attr("id");
        let name = $(this).attr("name");
        // var lenId = (id) ? id.length : 0;

        var isIdContainsP2 = (name != null) && (id.includes("_p2") || name.includes("_p2"));

        var numberIdP1 = -1, numberIdP2 = -1;

        var arr = id.split(".");

        if (isIdContainsP2) {
            numberIdP2 = (name.split("."))[1];
        } else {
            numberIdP1 = arr[1];
        }

        var childrensP1 = $("[id*=childMenu_p1" + numberIdP1 + "]");
        var childrensP2 = $("[id*=childMenu_p2" + numberIdP2 + "]");

        var childrens_br_p1 = $("[id*=childMenu_br_p1" + numberIdP1 + "]");
        var childrens_br_p2 = $("[id*=childMenu_br_p2" + numberIdP2 + "]");

        $("#link_p1." + numberIdP1).addClass("parentMenu_a_p1");

        $(".link_p2." + numberIdP2).addClass("parentMenu_a_p2");

        if (!isIdContainsP2) {
            childrensP2 = $("[id*=childMenu_p2" + numberIdP1 + "]");
            childrens_br_p2 = $("[id*=childMenu_br_p2" + numberIdP1 + "]");
            // alert(childrensP2.length);
            $.each(childrensP1, function (index, value) {

                var isVisible = $(value).is(':visible');
                var isDisplayNone = false;

                if (!isVisible) {
                    //$(value).show();
                    $(value).css("display", "inline");
                    $("[id='" + id + "']").addClass("parentMenu_a_plus");
                    // $(".link_p2." + numberIdP1).addClass("parentMenu_a_plus");
                }
                if (isVisible) {
                    $("[id='" + id + "']").removeClass("parentMenu_a_plus");
                    // $(".link_p2." + numberIdP1).removeClass("parentMenu_a_plus");
                    $(value).css("display", "none");
                    isDisplayNone = true;
                }

            });


            $.each(childrens_br_p1, function (index, value) {

                var isVisible = $(value).is(':visible');

                if (!isVisible && id.includes("link_p1.")) {
                    $(value).css("display", "block");
                    //$(value).show();
                    $("[id='" + id + "']").addClass("parentMenu_a_plus");
                    // $("#link_p2." + numberIdP1).addClass("parentMenu_a_plus");
                }
                if (isVisible && id.includes("link_p1.")) {
                    // $(value).hide();
                    $(value).css("display", "none");
                    $("[id='" + id + "']").removeClass("parentMenu_a_plus");
                    //$("#link_p2." + numberIdP1).removeClass("parentMenu_a_plus");

                }
            });

            if (childrensP2.length > 0) {
                $(".link_p2." + numberIdP2).addClass("parentMenu_a_p2");
                name = "link_p2." + numberIdP1;
            }

            $.each(childrensP2, function (index, value) {
                var isVisible = $(value).is(':visible');

                if (isVisible) {
                    // $("#link_p1" + numberId).removeClass("parentMenu_a_plus");
                    $("[name='" + name + "']").removeClass("parentMenu_a_plus");
                    // $(value).hide();
                    $(value).css("display", "none");

                }
            });

            $.each(childrens_br_p2, function (index, value) {
                var isVisible = $(value).is(':visible');
                if (isVisible && name.includes("link_p2.")) {
                    $("[name='" + name + "']").removeClass("parentMenu_a_plus");
                    //$(value).hide();
                    $(value).css("display", "none");
                }
            });

        } else {

            $.each(childrensP2, function (index, value) {

                var isVisible = $(value).is(':visible');
                if (!isVisible && name.includes("link_p2.")) {
                    // $(value).show();
                    $(value).css("display", "inline");
                    //$("#link_P1" + numberId).addClass("parentMenu_a_plus");
                    $("[name='" + name + "']").addClass("parentMenu_a_plus");
                }

                if (isVisible) {
                    // $("#link_p1" + numberId).removeClass("parentMenu_a_plus");
                    $("[name='" + name + "']").removeClass("parentMenu_a_plus");
                    // $(value).hide();
                    $(value).css("display", "none");

                }
            });

            $.each(childrens_br_p2, function (index, value) {
                var isVisible = $(value).is(':visible');
                if (!isVisible && name.includes("link_p2.")) {
                    $("[name='" + name + "']").addClass("parentMenu_a_plus");
                    // $(value).show();
                    $(value).css("display", "inline");

                }
                if (isVisible && name.includes("link_p2.")) {
                    $("[name='" + name + "']").removeClass("parentMenu_a_plus");
                    //$(value).hide();
                    $(value).css("display", "none");


                }
            });

        }

    });
});

