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
            const date = year + (((month + 1) < 10) ? ("-0" + (month + 1)) : "-" + (month + 1)) + ((day < 10) ? ("-0" + day) : ("-" + day));
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
            });
            location.reload();
        } else {
            alert("Targeted row element of  user[" + userEmail + "] missing in table");
        }


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
        console.log("()=>Data==:" + data);
        return data;
    }).then(function (x) {
        return x;
    });

    return results;
}

$(function () {

    //Set value
    var setSubmit = [];
    //DOM input element
    var submitButton = $("input[type=submit]");
    var birthdayElement = $("#birthday");
    var genderElement = $("#gender");
    var titleElement = $("#title");

    //Error Elemnt
    var error_message = $("#error_message");

    error_message.hide();

    submitButton.on('keydown focus', function () {
        checkBirthdayRestriction();
        //birthdayElement.attr("max", maxDate());
        checkGender();
        checkTitle();
        setSubmit.forEach(x => {
            if (x.state) {
                console.log("x.state=" + x.state);
                error_message.show();
                error_message.attr("style", "color:red; font-size:14pX;");
                error_message.html(x.message);
                submitButton.attr("disabled", x.state);
            }

        });
    });

    birthdayElement.on('click keydown blur focus change', function () {
        checkBirthdayRestriction();
        //birthdayElement.attr("max", maxDate());
    });
    genderElement.on('click keydown blur focus change', function () {
        checkGender();
    });
    titleElement.on('click keydown blur focus change', function () {
        checkTitle();
    });

    function checkBirthdayRestriction() {
        var value = birthdayElement.val();
        var date = new Date();

        var year = date.getFullYear();

        var birthdayYear = new Date(value).getFullYear();

        const diff = (year - birthdayYear);
        submitButton.attr("disabled", false);
        if (value) {
            if (diff < 15 || diff > 80) {
                error_message.show();
                error_message.attr("style", "color:red; font-size:14pX;");
                error_message.html("Birthday of a member schould be between 15 and 70");
                submitButton.attr("disabled", true);
                setSubmit[0] = { state: true, message: "Birthday of a member schould be between 15 and 70" };
                console.log("checkBirthdayRestriction()");
            } else {
                error_message.html("");
                setSubmit[0] = { state: false, message: "" };
            }
        }

    }

    function maxDate() {
        var date = new Date();
        return (date.getFullYear() - 14) + "-01-01";
    }

    function checkGender() {
        var value = genderElement.val();
        submitButton.attr("disabled", false);
        if (value) {
            if (value != "Male" && value != "Female") {
                error_message.show();
                error_message.attr("style", "color:red; font-size:14pX;");
                error_message.html("Gender should be Male or Female");
                submitButton.attr("disabled", true);
                setSubmit[1] = { state: true, message: "Gender should be Male or Female" };
                console.log("checkGender()");
            } else {
                error_message.html("");
                setSubmit[1] = { state: false, message: "" };
            }
        }
    }


    function checkTitle() {
        var value = titleElement.val();
        submitButton.attr("disabled", false);
        if (value) {
            if (value != "Dr." && value != "Pr. Dr." && value != "Prof." && value != "Mr." && value != "Mrs" && value != "Ing.") {
                error_message.show();
                error_message.attr("style", "color:red; font-size:14pX;");
                error_message.html("Title  should be : Dr., Pr. Dr., Prof., Mr., Ing., Mrs");
                submitButton.attr("disabled", true);
                setSubmit[2] = { state: true, message: "Title  should be : Dr., Pr. Dr., Prof., Mr.,Ing.,Mrs" }
                console.log("checkTitle()");
            } else {
                error_message.html("");
                setSubmit[2] = { state: false, message: "" };
            }
        }
    }
});


