
function tableRowsDisableOrEnable(arrayOfInputEls, tableId, rowOffset) {
    var table = document.getElementById(tableId);
    var tr = table.getElementsByTagName("tr");

    isfilterEmpty = true;

    for (i = 1; i < tr.length; i++) {
        textfound = false;

        isAllInputEmpty = 0;
        td = tr[i].getElementsByTagName("td");

        for (j = 0; j < arrayOfInputEls.length; j++) {

            txtValue = td[j + rowOffset].textContent;
            txtValue = txtValue.trim().toUpperCase();

            isSearching = true;
            inputElement = arrayOfInputEls[j];
            filter = (inputElement) ? inputElement.val().toUpperCase() : "";

            if (filter.length > 0 && txtValue.indexOf(filter.trim()) > -1) {
                textfound = true;
                isfilterEmpty = false;
            }
        }
        if (!textfound) {
            for (j = 0; j < arrayOfInputEls.length; j++) {
                inputElement = arrayOfInputEls[j];
                filter = (inputElement) ? inputElement.val().toUpperCase() : "";
                if (filter.length == 0) {
                    isAllInputEmpty++;
                }
            }
            if (isAllInputEmpty == arrayOfInputEls.length) {
                isfilterEmpty = true;
            } else {
                isfilterEmpty = false;
            }
        }

        if (textfound) {
            tr[i].style.display = "";
        }
        if (isfilterEmpty) {
            tr[i].style.display = "";
        }
        if (!isfilterEmpty && !textfound) {
            tr[i].style.display = "none";
        }
    }

}


function usersTableFilter(tableId) {

    var firstname = $("input[name='firstname']")
    var lastname = $("input[name='lastname']")
    var email = $("input[name='email']");
    var phoneNumber = $("input[name='phoneNumber']")
    var houseNumber = $("input[name='houseNumber']")
    var streetname = $("input[name='streetName']")

    const arrayOfinputs = [
        firstname, lastname, email, phoneNumber,streetname, houseNumber
    ]
    tableRowsDisableOrEnable(arrayOfinputs, tableId, 0);
}

function projectTableFilter(tableId) {
    title = $("#title");
    ctDate = $("#ctDate");
    stDate = $("#stDate");
    edDate = $("#edDate");
    createBy = $("#createBy");
    const arrayOfinputs = [
        title, ctDate, stDate, edDate, createBy
    ]
    tableRowsDisableOrEnable(arrayOfinputs, tableId, 1);
}

function contentTableFilter(contentTableId) {
    menuTable = $("input[name='menuTitle']");
    contentTable = $("input[name='contentTitle']");
    ctText = $("input[name='contentText']");

    const arrayOfinputs = [menuTable, contentTable, ctText]
    tableRowsDisableOrEnable(arrayOfinputs, contentTableId, 0);
}
