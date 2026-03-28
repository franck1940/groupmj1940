function makeUpdate(selectId, checkBoxId) {

    var checkBoxElement = $('#' + checkBoxId);
    var selectElement = $('#' + selectId);
    var valueCheck = checkBoxElement.is(':checked');
    var valueSelect = selectElement.is(':disabled');

    if (valueCheck) {

        if (valueSelect){
             selectElement.prop("disabled", false);
        }
    } else {
        selectElement.prop("disabled", true);
        $("input[id='projectTitle']").val("");
        $("textarea[id='projectDescription']").val("");
        var tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
        var d = (new Date(Date.now() - tzoffset)).toISOString().slice(0, -1);
        var arr = d.split(":");
        d = arr[0]+":"+ arr[1];
        $("input[id='projectCreateDate']").val(d);
        $("input[id='projectStartDate']").val("");
        $("input[id='projectEndDate']").val("");
    }
}

function loadProjectInfos(elementId, titleId, descId,createdateId ,strtId, endDateId, url) {
    let prjIdVal = $('#' + elementId).find(":selected").val();
    if (prjIdVal) {
        doPostOneData(url, prjIdVal, "loadProjectInfos()").then(function (data) {
            var obj = JSON.parse(data);
           // console.log(obj);
            $.each(obj, (index, val) => {
                $('#' + titleId).val(val.ProjectTitle);
                $('#' + descId).val(val.Description);
                $('#' + createdateId).val(val.CreateDate);
                $('#' + strtId).val(val.StartDate);
                $('#' + endDateId).val(val.EndDate);
            });
        });

    }
}


function editProject(containerId, ctsId) {
    $('#' + containerId).css("display", "");
    $('.' + ctsId).hide();
}

function deleteProject(projectId, url, projectTitle) {

    if (confirm("do you really want to delete this project with title: [" + projectTitle + "] ")) {
        doPostOneData(url, projectId, "deleteProject()").then(function (data) {
            console.log(data);
            alert("Delete content:[" + data + "]");
            location.href="allprojects";
            //backendmanagement/employeesActivities/allprojects
           // location.reload();
        });
    }
}


function cancelProjectForm(containerId, ctsId) {
    $('#' + containerId).css("display", "none");
    $('.' + ctsId).show();
}
