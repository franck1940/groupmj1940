//import { doPostOneData } from './UserActions.js';
function showContentsOfMenu(menuId, url, displayContainer) {
    menuelement = $('#' + menuId).find(":selected");
    value = menuelement.val();
    if (value) {
        doPostOneData(url, value, "showContentsOfMenu()").then(function (data) {
            $("#" + displayContainer).empty();
            var obj = JSON.parse(data);
            console.log(obj);
            $.each(obj, (index, val) => {
                // menu = JSON.parse(val.menuid);
                // templates = JSON.parse(val.templates);
                //  console.log(el);
                console.log(val.templates.templateName);
                // imgRghtTextLft(displayContainer,index,val.title,val.contentText,val.picture);
                // textUpImgDown(displayContainer,index,val.title,val.contentText,val.picture);
                imgRghtTextLft(displayContainer, index, 'insertPgContent', val);



            });
        }
        );

    }

}

function imgRghtTextLft(baseContainerId, index, url, json) {
    $("#" + baseContainerId).append("<div  id='divEl" + index + "' style=' overflow:hidden;width:70%; height:50%; margin-left:10%; position:relative; border:0px solid red;' ></div>");
    $("#divEl" + index).append("<div id='divEl" + index + "L' style='width:40%; height:auto;  float:left; border:0px solid yellow;'></div>");
    $("#divEl" + index).append("<div id='divEl" + index + "R' style='width:20%; height:auto; margin-right:20%; margin-top:0%; float:right; border:0px solid blue;'></div>");
    $("#divEl" + index + "L").append("<h2 style='margin-left:3%;'>" + json.title + "</h2>");
    $("#divEl" + index + "L").append("<p style='margin-left:3%;'>" + json.contentText + "</p>");
    $("#divEl" + index + "R").append("<img  style='margin-top:5%;' width='100px' height='100px' src=/public/contentimages/" + json.picture + "><br><br>");


    $("#" + baseContainerId).append("<form action='" + url + "' id='fCtUpdate" + index + "' method='post' enctype='multipart/form-data' style='display:none;'>");
    $("#fCtUpdate" + index).append("<label for='menu'>Menu</label><br>");
    $("#fCtUpdate" + index).append("<input type='text' name='allmenu' value='" + json.menuid.id + "' readonly> <br>");
    $("#fCtUpdate" + index).append("<label for='title'>Content template</label><br>");
    $("#fCtUpdate" + index).append("<input type='text' name='htmlTemplates' value='" + json.templates.templateName + "'> <br>");
    $("#fCtUpdate" + index).append("<label for='title'>Title</label><br>");
    $("#fCtUpdate" + index).append("<input type='text' name='title' value='" + json.title + "'> <br>");
    $("#fCtUpdate" + index).append("<input type='hidden' name='action' value='" + json.id + "'>");
    $("#fCtUpdate" + index).append("<label for='contenteditor'>Content Desc.</label><br>");
    $("#fCtUpdate" + index).append("<textarea name='contenteditor' id='contenteditor' rows='10' cols='70'>" + json.contentText + "</textarea><br>");
    $("#fCtUpdate" + index).append("<label for='picture'>Picture:</label><br>");
    $("#fCtUpdate" + index).append("<input type='file' id='picture' name='picture'/><br><br></br>");
    $("#fCtUpdate" + index).append("<input type='submit' value='Update content'/><br><br>");
    $("#fCtUpdate" + index).append("<p style='font-size:36px; color:#00008B; margin-left:20px;font-size:20px;cursor: pointer;'  onclick=cancelFom('fCtUpdate" + index + "','divEl" + index + "','ctViewMonitoring" + index + "')> &#10229; Back</p><br><br>");

    $("#" + baseContainerId).append("<div id='ctViewMonitoring" + index + "' />");
    $("#ctViewMonitoring" + index).append("<img src='/public/images/pencil.ico' width='24px' height='24px' onclick=reworkContent('fCtUpdate" + index + "','divEl" + index + "','ctViewMonitoring" + index + "') style='cursor: pointer;'/>")
    $("#ctViewMonitoring" + index).append("<img src='/public/images/icons8-trash-24.png' width='24px' height='24px' onclick=deleteContent(" + json.id + ",'deleteContent','" + (json.title).replace(/\s/g, '') + "') style='cursor: pointer;'/><br><br>");
    $("#" + baseContainerId).append("<hr  style='border:1px solid #000; width:60%;margin-top:10%;'>");

}

function textUpImgDown(baseContainerId, index, url, json) {
    $("#" + baseContainerId).append("<div  id='divEl" + index + "' style=' overflow:hidden;width:70%; height:50%; margin-left:10%; position:relative; border:0px solid red;' ></div>");
    $("#divEl" + index).append("<div id='divEl" + index + "U' style='width:70%; height:auto; border:0px solid yellow;'></div>");
    $("#divEl" + index).append("<div id='divEl" + index + "D' style='width:70%; height:auto; margin-right:20%; margin-top:0%; border:0px solid blue;'></div>");
    $("#divEl" + index + "U").append("<h2 style='margin-left:3%;'>" + json.title + "</h2>");
    $("#divEl" + index + "U").append("<p style='margin-left:3%;'>" + json.contentText + "</p>");
    $("#divEl" + index + "D").append("<img  style='margin-top:5%;' width='100px' height='100px' src=/public/contentimages/" + json.picture + "><br><br>");

    $("#" + baseContainerId).append("<form action='" + url + "' id='fCtUpdate" + index + "' method='post' enctype='multipart/form-data' style='display:none;'>");
    $("#fCtUpdate" + index).append("<label for='menu'>Menu</label><br>");
    $("#fCtUpdate" + index).append("<input type='text' name='allmenu' value='" + json.menuid.id + "' readonly> <br>");
    $("#fCtUpdate" + index).append("<label for='title'>Content template</label><br>");
    $("#fCtUpdate" + index).append("<input type='text' name='htmlTemplates' value='" + json.templates.templateName + "'> <br>");
    $("#fCtUpdate" + index).append("<label for='title'>Title</label><br>");
    $("#fCtUpdate" + index).append("<input type='text' name='title' value='" + json.title + "'> <br>");
    $("#fCtUpdate" + index).append("<input type='hidden' name='action' value='" + json.id + "'>");
    $("#fCtUpdate" + index).append("<label for='contenteditor'>Content Desc.</label><br>");
    $("#fCtUpdate" + index).append("<textarea name='contenteditor' id='contenteditor' rows='10' cols='70'>" + json.contentText + "</textarea><br>");
    $("#fCtUpdate" + index).append("<label for='picture'>Picture:</label><br>");
    $("#fCtUpdate" + index).append("<input type='file' id='picture' name='picture'/><br><br></br>");
    $("#fCtUpdate" + index).append("<input type='submit' value='Update content'/><br><br>");
    $("#fCtUpdate" + index).append("<p style='font-size:36px; color:#00008B; margin-left:20px;font-size:20px;cursor: pointer;'  onclick=cancelFom('fCtUpdate" + index + "','divEl" + index + "','ctViewMonitoring" + index + "')> &#10229; Back</p><br><br>");

    $("#" + baseContainerId).append("<div id='ctViewMonitoring" + index + "' />");
    $("#ctViewMonitoring" + index).append("<img src='/public/images/pencil.ico' width='24px' height='24px' onclick=reworkContent('fCtUpdate" + index + "','divEl" + index + "','ctViewMonitoring" + index + "') style='cursor: pointer;'/>")
    $("#ctViewMonitoring" + index).append("<img src='/public/images/icons8-trash-24.png' width='24px' height='24px' onclick=deleteContent(" + json.id + ",'deleteContent','" + (json.title).replace(/\s/g, '') + "')  style='cursor: pointer;'/><br><br>");
    $("#" + baseContainerId).append("<hr  style='border:1px solid #000; width:60%;margin-top:10%;'>");

}

function titleUpImgMiddelTextDown(baseContainerId, index, url, json) {
    $("#" + baseContainerId).append("<div  id='divEl" + index + "' style=' overflow:hidden;width:70%; height:50%; margin-left:10%; position:relative; border:0px solid red; margin-top:5%;' ></div>");
    $("#divEl" + index).append("<div id='divEl" + index + "U' style='width:70%; height:auto; border:0px solid yellow; word-break: break-all;'></div>");
    $("#divEl" + index).append("<div id='divEl" + index + "D' style='width:100%; height:auto; margin-right:20%; margin-top:1%; border:0px solid blue; word-break: break-all;'></div>");
    $("#divEl" + index + "U").append("<h2 style='margin-left:3%;'>" + json.title + "</h2>");
    $("#divEl" + index + "D").append("<p style='margin-left:3%;'>" + json.contentText + "</p>");
    $("#divEl" + index + "U").append("<img  style='margin-top:5%;' width='200px' height='200px' src=/public/contentimages/" + json.picture + "><br><br>");
    //$("#" + baseContainerId).append("<p style='font-size:36px; color:#00008B; margin-left:20px;font-size:20px;cursor: pointer;'  onclick=reworkCancel()> &#10229; Back</p>");

    $("#" + baseContainerId).append("<form action='" + url + "' id='fCtUpdate" + index + "' method='post'  enctype='multipart/form-data'  style='display:none;'>");
    $("#fCtUpdate" + index).append("<label for='menu'>Menu</label><br>");
    $("#fCtUpdate" + index).append("<input type='text' name='allmenu' value='" + json.menuid.id + "' readonly> <br>");
    $("#fCtUpdate" + index).append("<label for='title'>Content template</label><br>");
    $("#fCtUpdate" + index).append("<input type='text' name='htmlTemplates' value='" + json.templates.templateName + "'> <br>");
    $("#fCtUpdate" + index).append("<label for='title'>Title</label><br>");
    $("#fCtUpdate" + index).append("<input type='text' name='title' value='" + json.title + "'> <br>");
    $("#fCtUpdate" + index).append("<input type='hidden' name='action' value='" + json.id + "'>");
    $("#fCtUpdate" + index).append("<label for='contenteditor'>Content Desc.</label><br>");
    $("#fCtUpdate" + index).append("<textarea name='contenteditor' id='contenteditor' rows='10' cols='70'>" + json.contentText + "</textarea><br>");
    $("#fCtUpdate" + index).append("<label for='picture'>Picture:</label><br>");
    $("#fCtUpdate" + index).append("<input type='file' id='picture' name='picture'/><br><br></br>");
    $("#fCtUpdate" + index).append("<input type='submit' value='Update content'/><br><br>");
    $("#fCtUpdate" + index).append("<p style='font-size:36px; color:#00008B; margin-left:20px;font-size:20px;cursor: pointer;'  onclick=cancelFom('fCtUpdate" + index + "','divEl" + index + "','ctViewMonitoring" + index + "')> &#10229; Back</p><br><br>");

    $("#" + baseContainerId).append("<div id='ctViewMonitoring" + index + "' />");
    $("#ctViewMonitoring" + index).append("<img src='/public/images/pencil.ico' width='24px' height='24px' onclick=reworkContent('fCtUpdate" + index + "','divEl" + index + "','ctViewMonitoring" + index + "') style='cursor: pointer;'/>")
    $("#ctViewMonitoring" + index).append("<img src='/public/images/icons8-trash-24.png' width='24px' height='24px' onclick=deleteContent(" + json.id + ",'deleteContent','" + (json.title).replace(/\s/g, '') + "')  style='cursor: pointer;'/><br><br>");
    $("#" + baseContainerId).append("<hr  style='border:1px solid #000; width:60%;margin-top:10%;'>");
}

function cancelFom(formId, divId, ctViewMonitoring) {
    $("#" + formId).attr("style", "display:none;");
    $("#" + divId).attr("style", "display:'';");
    $("#" + ctViewMonitoring).attr("style", "display:'';");

}

function deleteContent(contentId, url, ctTitle) {
    // alert(contentId);
    if (confirm("do you really want to delete this content with title: [" + ctTitle + "] ")) {
        doPostOneData(url, contentId, "deleteContent()").then(function (data) {
            console.log(data);
            alert("Delete content:[" + data + "]");
            location.reload();
        });
    }
}

function reworkContent(formId, divId, ctViewMonitoring) {
    $("#" + formId).attr("style", "display:'';");
    $("#" + divId).attr("style", "display:none;");
    $("#" + ctViewMonitoring).attr("style", "display:none;");


}