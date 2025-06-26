function getUserById(containerId, url) {
    const userContainer = $("#" + containerId).find(":selected");
    const value = userContainer.val();
    if (value) {
        $.post(url, {
            id: value
        }, function (data, status) {
            var obj = JSON.parse(data);
            console.log(obj);
            $("#firstname").val(obj.firstname);
            $("#lastname").val(obj.lastname);
            $("#email").val(obj.email);
            $("#phonenumber").val(obj.phonenumber);
            const birthday = new Date(obj.birthday.date);
            const day = birthday.getDate();
            const year = birthday.getFullYear();
            const month = birthday.getMonth();
            const date = year + (((month + 1) < 10) ? ("-0" + (month + 1)) : "-" + (month + 1)) + "-" + day;
            $("#birthday").val(date);
            $("#streetname").val(obj.StreetName);
            $("#housenumber").val(obj.HouseNumber);
            $("#city").val(obj.city);
            $("#zipcode").val(obj.zipcode);
            $("#country").val(obj.country);
            $("#gender").val(obj.gender);
            $("#title").val(obj.title);
        })
    }

}


function deleteUser(url, userEmail, rowIndex) {
    const el = $("#row" + rowIndex);


    if (confirm("Really delete user: - " + userEmail + "-?")) {
        if (el) {
            $.post(url, {
                id: rowIndex
            }, function (data, status) {
                console.log("deleteUser():" + status);
                console.log("status:" + status);
                alert("Delete user :[" + userEmail + "] " + data);
            })
        } else {
            alert("Targeted row element of  user[" + userEmail + "] missing in table");
        }

        location.reload();
    }

}


function searchUserEmail(url, containerId, emailEl) {
    const container = $("#" + containerId).find(":selected");
    const userId = container.val()
    if (userId) {
        $.post(url, {
            id: userId
        }, function (data, status) {
            $("#" + emailEl).val(data);
            console.log("searchEmail():" + status);
            console.log("searchEmail():status" + status);
        })
    }

}

function getUserRights(url, containerId) {
    const container = $("#" + containerId).find(":selected");
    const userId = container.val();
    if (userId) {
        $("[type=checkbox]").attr("checked", false);
        doPostOneData(url, userId, "getUserRights").then(function (data) {
            var obj = JSON.parse(data);
            $.each(obj, function (index, value) {
                $("#" + value).attr("checked", true);
            })

        });
    }
}

function doPostOneData(url, userId, functionName) {

    results = null;
    results = $.post(url, {
        id: userId
    }, function (data, status) {
        console.log(functionName + "()=>status:" + status);
        return data;
    }).then(function (x) {
        return x;
    });

    return results;
}