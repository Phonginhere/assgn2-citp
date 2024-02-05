
function manageFunction() {
    var input, filter, table, tr, td, i, j, txtValue, filterStaff;
    input = document.getElementById("manageInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    filterStaff = document.getElementById("filterStaff").value; // Get the selected filter option

    if (filterStaff === "default") {
        // Loop through all rows, starting from the second row (index 1) to skip the header row
        for (i = 1; i < tr.length; i++) {
            var found = false; // Flag to check if the row matches the filter

            // Loop through all columns (td elements) in the row, except for the first and last columns
            for (j = 1; j < tr[i].cells.length - 1; j++) {
                td = tr[i].cells[j];
                if (td) {
                    txtValue = td.textContent || td.innerText;

                    // Check if the column's text contains the filter text
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break; // Stop searching other columns in this row
                    }
                }
            }

            // Show or hide the row based on whether a match was found
            if (found) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    if (filterStaff === "name" || filterStaff === "applicant") {
        for (i = 0; i < tr.length; i++) {
            tdRef = tr[i].getElementsByTagName("td")[1]; // Get the first <td> in the row
            tdApp = tr[i].getElementsByTagName("td")[2]; // Get the second <td> in the row

            if (tdRef && tdApp) {
                txtValue = (filterStaff === "name") ? tdRef.textContent || tdRef.innerText : tdApp.textContent || tdApp.innerText;

                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }


}

function managestaffFunction(){
    var input, filter, table, tr, td, i, j, txtValue, filterStaff;
    input = document.getElementById("manageInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    filterStaff = document.getElementById("filterStaff").value; // Get the selected filter option

    if (filterStaff === "default") {
        // Loop through all rows, starting from the second row (index 1) to skip the header row
        for (i = 1; i < tr.length; i++) {
            var found = false; // Flag to check if the row matches the filter

            // Loop through all columns (td elements) in the row, except for the first and last columns
            for (j = 1; j < tr[i].cells.length - 1; j++) {
                td = tr[i].cells[j];
                if (td) {
                    txtValue = td.textContent || td.innerText;

                    // Check if the column's text contains the filter text
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break; // Stop searching other columns in this row
                    }
                }
            }

            // Show or hide the row based on whether a match was found
            if (found) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    if (filterStaff === "name" || filterStaff === "roles" || filterStaff === "status" || filterStaff === "added_date") {
        for (i = 0; i < tr.length; i++) {
            tdName = tr[i].getElementsByTagName("td")[1]; // Get the first <td> in the row
            tdRoles = tr[i].getElementsByTagName("td")[2]; // Get the second <td> in the row
            tdStus = tr[i].getElementsByTagName("td")[3]; // Get the second <td> in the row
            tdaddDt = tr[i].getElementsByTagName("td")[4]; // Get the second <td> in the row

            if (tdName && tdRoles && tdStus && tdaddDt) {
                txtValueOne = (filterStaff === "name") ? tdName.textContent || tdName.innerText : tdRoles.textContent || tdRoles.innerText;
                txtValueTwo = (filterStaff === "status") ? tdStus.textContent || tdStus.innerText : tdaddDt.textContent || tdaddDt.innerText;

                if (txtValueOne.toUpperCase().indexOf(filter) > -1 || txtValueTwo.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }


}

function managelogFunction(){
    var input, filter, table, tr, td, i, j, txtValue, filterLog;
    input = document.getElementById("manageInputlog");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTablelog");
    tr = table.getElementsByTagName("tr");
    filterLog = document.getElementById("filterLog").value; // Get the selected filter option

    if (filterLog === "default") {
        // Loop through all rows, starting from the second row (index 1) to skip the header row
        for (i = 1; i < tr.length; i++) {
            var found = false; // Flag to check if the row matches the filter

            // Loop through all columns (td elements) in the row, except for the first and last columns
            for (j = 0; j < tr[i].cells.length; j++) {
                td = tr[i].cells[j];
                if (td) {
                    txtValue = td.textContent || td.innerText;

                    // Check if the column's text contains the filter text
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break; // Stop searching other columns in this row
                    }
                }
            }

            // Show or hide the row based on whether a match was found
            if (found) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    if (filterLog === "name" || filterLog === "activity" || filterLog === "time") {
        for (i = 0; i < tr.length; i++) {
            tdName = tr[i].getElementsByTagName("td")[0]; // Get the first <td> in the row
            tdActv = tr[i].getElementsByTagName("td")[1]; // Get the second <td> in the row
            tdTime = tr[i].getElementsByTagName("td")[2]; // Get the third <td> in the row

            if (filterLog === "time") {
                if (tdTime){
                    txtValuetime = tdTime.textContent || tdTime.innerText;
                    if (txtValuetime.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }

            }else if (tdName && tdActv) {
                txtValue = (filterLog === "name") ? tdName.textContent || tdName.innerText : tdActv.textContent || tdActv.innerText;

                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
}


function manageljobFunction(){
    var input, filter, table, tr, td, i, j, txtValue, filterlJob;
    input = document.getElementById("manageInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTableljob");
    tr = table.getElementsByTagName("tr");
    filterlJob = document.getElementById("filterlJob").value; // Get the selected filter option

    if (filterlJob === "default") {
        // Loop through all rows, starting from the second row (index 1) to skip the header row
        for (i = 1; i < tr.length; i++) {
            var found = false; // Flag to check if the row matches the filter

            // Loop through all columns (td elements) in the row, except for the first and last columns
            for (j = 0; j < tr[i].cells.length; j++) {
                td = tr[i].cells[j];
                if (td) {
                    txtValue = td.textContent || td.innerText;

                    // Check if the column's text contains the filter text
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break; // Stop searching other columns in this row
                    }
                }
            }

            // Show or hide the row based on whether a match was found
            if (found) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    if (filterlJob ==="jobRef" || filterlJob === "staff" || filterlJob === "roles" || filterlJob === "issuedDate" || filterlJob === "status") {
        for (i = 0; i < tr.length; i++) {
            tdJref = tr[i].getElementsByTagName("td")[1]; // Get the 1st <td> in the row
            tdStaf = tr[i].getElementsByTagName("td")[2]; // Get the 2nd <td> in the row
            tdRole = tr[i].getElementsByTagName("td")[3]; // Get the 3rd <td> in the row
            tdIsdt = tr[i].getElementsByTagName("td")[4]; // Get the 4th <td> in the row
            tdStus = tr[i].getElementsByTagName("td")[5]; // Get the 5th <td> in the row

            if (filterlJob === "status") {
                if (tdStus){
                    txtValueStatus = tdStus.textContent || tdStus.innerText;
                    if (txtValueStatus.toUpperCase().indexOf(filter) > -1 || txtValueStatus.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }

            }else if (tdJref && tdStaf && tdRole && tdIsdt) {
                txtValueOne = (filterlJob === "jobRef") ? tdJref.textContent || tdJref.innerText : tdStaf.textContent || tdStaf.innerText;
                txtValueTwo = (filterlJob === "roles") ? tdRole.textContent || tdRole.innerText : tdIsdt.textContent || tdIsdt.innerText;

                if (txtValueOne.toUpperCase().indexOf(filter) > -1 || txtValueTwo.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
}

function managelSkillsFunction(){
    var input, filter, table, tr, td, i, j, txtValue, filterSkills;
    input = document.getElementById("manageInputSk");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTableskills");
    tr = table.getElementsByTagName("tr");
    filterSkills = document.getElementById("filterSkills").value; // Get the selected filter option

    if (filterSkills === "default") {
        // Loop through all rows, starting from the second row (index 1) to skip the header row
        for (i = 1; i < tr.length; i++) {
            var found = false; // Flag to check if the row matches the filter

            // Loop through all columns (td elements) in the row, except for the first and last columns
            for (j = 0; j < tr[i].cells.length; j++) {
                td = tr[i].cells[j];
                if (td) {
                    txtValue = td.textContent || td.innerText;

                    // Check if the column's text contains the filter text
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break; // Stop searching other columns in this row
                    }
                }
            }

            // Show or hide the row based on whether a match was found
            if (found) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    if (filterSkills ==="skills" || filterSkills === "purpose" || filterSkills === "createdDate") {
        for (i = 0; i < tr.length; i++) {
            tdSkills = tr[i].getElementsByTagName("td")[1]; // Get the 1st <td> in the row
            tdPurpose = tr[i].getElementsByTagName("td")[2]; // Get the 2nd <td> in the row
            tdCdate = tr[i].getElementsByTagName("td")[3]; // Get the 3rd <td> in the row

            if (filterSkills === "createdDate") {
                if (tdCdate){
                    txtValuecdate = tdCdate.textContent || tdCdate.innerText;
                    if (txtValuecdate.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }

            }else if (tdSkills && tdPurpose) {
                txtValue = (filterSkills === "skills") ? tdSkills.textContent || tdSkills.innerText : tdPurpose.textContent || tdPurpose.innerText;

                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
}

function managelSkillsAdminFunction(){
    var input, filter, table, tr, td, i, j, txtValue, filterSkills;
    input = document.getElementById("manageInputSk");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTableskills");
    tr = table.getElementsByTagName("tr");
    filterSkills = document.getElementById("filterSkills").value; // Get the selected filter option

    if (filterSkills === "default") {
        // Loop through all rows, starting from the second row (index 1) to skip the header row
        for (i = 1; i < tr.length; i++) {
            var found = false; // Flag to check if the row matches the filter

            // Loop through all columns (td elements) in the row, except for the first and last columns
            for (j = 0; j < tr[i].cells.length; j++) {
                td = tr[i].cells[j];
                if (td) {
                    txtValue = td.textContent || td.innerText;

                    // Check if the column's text contains the filter text
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break; // Stop searching other columns in this row
                    }
                }
            }

            // Show or hide the row based on whether a match was found
            if (found) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    if (filterSkills ==="skills" || filterSkills === "createdBy") {
        for (i = 0; i < tr.length; i++) {
            tdSkills = tr[i].getElementsByTagName("td")[0]; // Get the 1st <td> in the row
            tdcreatedBy = tr[i].getElementsByTagName("td")[1]; // Get the 2nd <td> in the row

             if (tdSkills && tdcreatedBy) {
                txtValue = (filterSkills === "skills") ? tdSkills.textContent || tdSkills.innerText : tdcreatedBy.textContent || tdcreatedBy.innerText;

                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
}

function managelBenefitsFunction(){
    var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("manageInputPros");
            filter = input.value.toUpperCase();
            table = document.getElementById("tableBenefits");
            tr = table.getElementsByTagName("tr");

                // Loop through all rows, starting from the second row (index 1) to skip the header row
                for (i = 1; i < tr.length; i++) {
                    var found = false; // Flag to check if the row matches the filter

                    // Loop through all columns (td elements) in the row, except for the first and last columns
                    for (j = 0; j < tr[i].cells.length; j++) {
                        td = tr[i].cells[j];
                        if (td) {
                            txtValue = td.textContent || td.innerText;

                            // Check if the column's text contains the filter text
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                found = true;
                                break; // Stop searching other columns in this row
                            }
                        }
                    }

                    // Show or hide the row based on whether a match was found
                    if (found) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
}

function managelDrawbacksFunction(){
    var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("manageInputCons");
            filter = input.value.toUpperCase();
            table = document.getElementById("tableDrawbacks");
            tr = table.getElementsByTagName("tr");

                // Loop through all rows, starting from the second row (index 1) to skip the header row
                for (i = 1; i < tr.length; i++) {
                    var found = false; // Flag to check if the row matches the filter

                    // Loop through all columns (td elements) in the row, except for the first and last columns
                    for (j = 0; j < tr[i].cells.length; j++) {
                        td = tr[i].cells[j];
                        if (td) {
                            txtValue = td.textContent || td.innerText;

                            // Check if the column's text contains the filter text
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                found = true;
                                break; // Stop searching other columns in this row
                            }
                        }
                    }

                    // Show or hide the row based on whether a match was found
                    if (found) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
}


//applicant
