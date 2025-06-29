function checkAll() {
    let val = document.getElementById("checkall").checked;
    const arrySelectedObjec = document.getElementsByName("cbname");

    //alert(val);
    // document.getElementsByName("cbname").checked = val;
    arrySelectedObjec.forEach(function (item) {
        item.checked = val;
    });
    // alert(arrySelectedObjec.length);
    //document.getElementById("checkallusers").submit();
    // document.getElementById("checkall").value=val;
}


function checkallLogins() {

    const val = document.getElementById("selectAllLogins").checked;
    const arrySelectedObjec = document.getElementsByName("cbname");
    arrySelectedObjec.forEach(function (item) {
        item.checked = val;
    });
}

function deleteAllLogins() {

    const val = document.getElementById("allLogins").value;
    $("#allLogins").append('<input type="hidden" name="deleteAlllogin" value="' + val + '" />');
    if (val) {
        document.getElementById("allLogins").submit();
    }
}

function typingPasswordCheck() {
    const val1 = document.getElementById("password1").value;
    const val2 = document.getElementById("password2").value;
    // const result = val1.localeCompare(val2);
    document.getElementById("pwcmp").style.display = 'none';
    document.getElementById("sumbitchangepw").disabled = false;
    if (val1.trim() !== val2.trim()) {
        document.getElementById("pwcmp").style.display = "";
        document.getElementById("pwcmp").style.color = 'red';
        document.getElementById("pwcmp").innerHTML = "both passwords are different!"
        document.getElementById("sumbitchangepw").disabled = true;

    }

}
/**
 * 
 * @param {*} id 
 * @param {*} position 
 */
function deleteThislogin(id, position) {

    const val = document.getElementById("select" + position).value;
    $("#allLogins").append('<input type="hidden" name="deleteThisLogin" value="' + id + '" />');

    if (val) {
        document.getElementById("allLogins").submit();
    }
}




function callRootSubMenu() {
    const val = document.getElementById("rootmenu").value;
    $("#rootsbsbmenu").append('<input type="hidden" name="callrootsb" value="' + val + '" />');
    if (val) {
        document.getElementById("rootsbsbmenu").submit();
    }

}


function deleteAll() {

    let val = document.getElementById("select1").checked;

    if (val) {
        document.getElementById("checkallusers").submit();
    } else {
        alert(" ERROR\n\nPlease selects all checkboxes!")
    }
}

function selectSearchData() {

    const val = document.getElementById("selectedtitle").value;

    $("#updateUR").append('<input type="hidden" name="sendbyfunc" value="' + val + '" />');
    if (val) {
        document.getElementById("updateUR").submit();
    }

}


function checkUserCurrentRight() {
    const val = document.getElementById("loginname").value;
    $("#insertuserright").append('<input type="hidden" name="rf" value="' + val + '" />');
    if ($val) {
        document.getElementById("insertuserright").submit();
    }
}

function getUserToBeUpdate() {
    const x = document.getElementById("selectedUser").value;
    $("#updateuser").append('<input type="hidden" name="userToUpdate" value="' + x + '" />');
    if (x) {
        document.getElementById("updateuser").submit();

    }
}

