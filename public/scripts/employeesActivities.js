function makeUpdate(selectId, checkBoxId) {

    var checkBoxElement = $('#' + checkBoxId);
    var selectElement = $('#' + selectId);
    var valueCheck = checkBoxElement.is(':checked');
    var valueSelect = selectElement.is(':disabled');
    
    if (valueCheck) {

        if (valueSelect) selectElement.prop("disabled", false);
    } else {
        selectElement.prop("disabled", true);
    }
}


function editProject(containerId,ctsId)
{
     $('#' + containerId).css("display","");
     $('.' + ctsId).hide();
}

function deleteProject(projectId, url ,projectTitle)
{
   
    if (confirm("do you really want to delete this project with title: [" + projectTitle + "] ")) {
        doPostOneData(url, projectId, "deleteContent()").then(function (data) {
            console.log(data);
            alert("Delete content:[" + data + "]");
            location.reload();
        });
    }
}


function cancelProjectForm(containerId,ctsId)
{
     $('#' + containerId).css("display","none");
     $('.' + ctsId).show();
}
