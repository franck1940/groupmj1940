function searchHtml(selectorId, url, title, fieldForBId, fieldDescBId) {
    const htmlTplSelectorEl = $("#" + selectorId).find(":selected");
    const value = htmlTplSelectorEl.val();
    $("#" + fieldForBId).val("").change();
    $("#" + fieldDescBId).val("");
    $("#" + title).val("");
    if (value) {
        doPostOneData(url, value, "searchHtml()").then(function (data) {
            var obj = JSON.parse(data);
            $("#" + fieldForBId).val(obj.frontOrBackend).change();
            $("#" + fieldDescBId).val(obj.description);
            $("#" + title).val(obj.templateName);
        });
    }
}

function deleteHtml(htmlId, text, url) {
    if (htmlId) {
        if (confirm("Really delete :[" + text + "] ?")) {
            doPostOneData(url, htmlId, "deleteHtml()").then(function (data) {
                console.log(data);
                location.reload();
            })

        }
    }

}

function reworkHtml(divId, formId) {
    document.getElementById(formId).style.display = "";
    document.getElementById(divId).style.display = "none";
    document.getElementById("sbmessage").innerHTML = "";
}

function reworkCancel(divId, formId) {
    document.getElementById(formId).style.display = "none";
    document.getElementById(divId).style.display = "inline-block";
}
