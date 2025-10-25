function isNumeric(str) {
    if (typeof str != "string") return false // we only process strings!  
    return !isNaN(str) && // use type coercion to parse the _entirety_ of the string (`parseFloat` alone does not do this)...
        !isNaN(parseFloat(str)) // ...and ensure strings of whitespace fail
}

function changeValidationMessage(elementName, message) {
    var element = document.getElementById(elementName);
    var val = element.value;
    var attr = element.getAttribute("name");
    if (attr == "phone") {
        if (!isNumeric(val) || val.length == 0 || val.length < 12) {
            element.setCustomValidity(message);
        }
    }
}

$(document).ready(function () {
    $("#mainCtsRight").hide();
});