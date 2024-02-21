function clearDelegationModel() {
    document.getElementsByName("end_date")[0].value = "";
    document.getElementsByName("start_date")[0].value = "";
    var list =  document.getElementsByClassName("form-check-input");
    for (let item of list) {
        item.checked = false
    }
}

function getSelectedOptionFromDL(name) {
    const options = document.getElementById(name).options;
    const optionsArray = [...options];
    
    selectedText = document.getElementsByName(name)[0]
    selectedOption = optionsArray.filter(button =>  button.value === selectedText.value)
    if (selectedOption.length) {   
        return selectedOption[0].dataset.value
    }
    return "";
}

function setDataListValues() {
    selectedOption = getSelectedOptionFromDL("os_dl")
    document.getElementsByName("c_os_id")[0].value = selectedOption

    selectedOption = getSelectedOptionFromDL("job_dl")
    document.getElementsByName("c_job_id")[0].value = selectedOption

    selectedOption = getSelectedOptionFromDL("role_dl")
    document.getElementsByName("c_role_id")[0].value = selectedOption

    return true;
}

document.addEventListener("DOMContentLoaded", function() {
    // assignOS view
    employee_no_input = document.getElementsByName("employee_no_input")[0]
    if (employee_no_input) {
        if(employee_no_input.value != "0") {
            getEmployeeOSHistory()
        }
        else {
            employee_no_input.value = ""
        }
    }    

    // delegate view
    employee_no_select = document.getElementsByName("employee_no_select")[0]
    if (employee_no_select) {
        selectedOption = getSelectedOptionFromDL("employee_no_select")
        if(selectedOption) {
            getEmployeeDelegationHistory(selectedOption.split("_")[1])
        }
        clearDelegationModel()
        employee_no_select.onkeyup = function(){  
            document.getElementById("delegateBtn").disabled = true;
            if(employee_no_select.value) {
                clearDelegationModel()
                selectedOption = getSelectedOptionFromDL("employee_no_select")
                if (selectedOption) {                        
                    emp_no = selectedOption.split("_")
                    document.getElementsByName("employee_no").forEach(function (item) {
                        item.value = emp_no[1]
                    });
                    document.getElementById("c_employee_id").value = emp_no[0]

                    document.getElementsByName("employee_name").forEach(function (item) {
                        item.value = employee_no_select.value
                    });

                    getEmployeeDelegationHistory(emp_no[1])
                } else {
                    body = document.getElementById("tableBody");
                    body.innerText = "";
                    // TODO_Aya: error: employee name not exist
                    console.log("employee name not exist");
                }
            } 
        };
    }  
});

function getGeneralManagment(element, os_list){   
    // TODO_AYA: check performance when os is complete
    while(element.node_level > 3) {
        element = os_list.find(obj => {
            return obj.id === element.parent_id
        });
    }   
    return element.name;
}
function getEmployeeDelegationHistory(emp_no) {
    if(emp_no) {
        post(`/delegate/get_user_delegation`, { "employee_no": emp_no }).then((response) => {
            if (response.ok) {
                response
                    .json()
                    .then((response) => { 
                        body = document.getElementById("tableBody");
                        body.innerText = "";

                        document.getElementsByName("employee_name").forEach(function (item) {
                            item.value = response[0].f_name + " " + response[0].l_name 
                        });
                        document.getElementsByName("employee_no").forEach(function (item) {
                            item.value = response[0].employee_no
                        });
                        document.getElementById("c_employee_id").value = response[0].id
                        delegateBtn = false;

                        if(response[1].length) {
                            response[1].forEach(function (element) {   
                                td1 = document.createElement("td");
                                td1.innerText = element.name;
                                td1.classList.add("text-center", "align-middle");

                                td3 = document.createElement("td");
                                td3.innerText = element.start_date;
                                td3.classList.add("text-center", "align-middle");

                                td4 = document.createElement("td");
                                td4.innerText = element.end_date??"-";
                                td4.classList.add("text-center", "align-middle");

                                td5 = document.createElement("td");
                                td5.innerText = element.job_title;
                                td5.classList.add("text-center", "align-middle");

                                btn = document.createElement("button");
                                btn.innerText = "الغاء/تعديل التفويض";
                                btn.classList.add("btn", "btn-danger", "text-dark");
                                btn.addEventListener('click', (e) => {
                                    document.getElementById("start_date").value =  element.start_date;
                                    document.getElementById("os_id").value = element.os_id;
                                    document.getElementById("d_id").value = element.id

                                    var modal  = new bootstrap.Modal(
                                        document.getElementById('confirmEditDelegation')
                                    );
                                    modal.show();
                                })
                                
                                if(element.end_date && element.end_date <= new Date().toISOString().slice(0, 10)) {
                                    btn.disabled = true;
                                } else {
                                    delegateBtn = true;
                                }
                                td6 = document.createElement("td");

                                // TODO_Aya: check 'edit_user_delegate' permission before append the edit btn  
                                td6.appendChild(btn)

                                tr = document.createElement("tr");
                                tr.appendChild(document.createElement("td"));
                                tr.appendChild(td1);
                                tr.appendChild(td5);
                                tr.appendChild(td3);
                                tr.appendChild(td4);
                                tr.appendChild(td6);
                                
                                body.appendChild(tr);
                            });
                        }     
                        document.getElementById("delegateBtn").disabled = delegateBtn;                  
                    });
            } else {
                body = document.getElementById("tableBody");
                body.innerText = "";
                document.getElementById("delegateBtn").disabled = true
                document.getElementsByName("employee_name").forEach(function (item) {
                    item.value = "";
                });
                document.getElementsByName("employee_no").forEach(function (item) {
                    item.value = "";
                });
                document.getElementById("c_employee_id").value = "";
            } 
        });
    }
}

function getEmployeeOSHistory() {
    employee_no = document.getElementById("employee_no_input")
    if(employee_no.value) {
        post(`/employee/get_user_os`, { "employee_no": employee_no.value }).then((response) => {
            if (response.ok) {
                response
                    .json()
                    .then((response) => { 
                        body = document.getElementById("tableBody");
                        body.innerText = "";

                        document.getElementById("assigneOsBtn").disabled = false;
                        document.getElementById("emp_no").value = response[0].employee_no
                        document.getElementById("name").value = response[0].f_name + " " + response[0].l_name 

                        document.getElementsByName("employee_name").forEach(function (item) {
                            item.value = response[0].f_name + " " + response[0].l_name 
                        });
                        document.getElementsByName("employee_no").forEach(function (item) {
                            item.value = response[0].employee_no
                        });
                        document.getElementById("c_employee_id").value = response[0].id
                        
                        if(response[1].length) {
                            response[1].forEach(function (element, index) {

                                td0 = document.createElement("td");
                                td0.innerText = index + 1;
                                td0.classList.add("text-center", "align-middle");


                                td1 = document.createElement("td");
                                td1.innerText = element.name;
                                td1.classList.add("text-center", "align-middle");

                                td2 = document.createElement("td");
                                td2.innerText = getGeneralManagment(element, response[2]);
                                td2.classList.add("text-center", "align-middle");

                                td3 = document.createElement("td");
                                td3.innerText = element.start_date;
                                td3.classList.add("text-center", "align-middle");

                                td4 = document.createElement("td");
                                td4.innerText = element.end_date??"-";
                                td4.classList.add("text-center", "align-middle");


                                td5 = document.createElement("td");
                                td5.classList.add("text-center", "align-middle");

                                td6 = document.createElement("td");
                                td6.innerText = element.job_title;
                                td6.classList.add("text-center", "align-middle");

                                btn = document.createElement("button");
                                btn.innerText = "الغاء التكليف";
                                btn.classList.add("btn", "btn-danger");
                                btn.addEventListener('click', (e) => {
                                    document.getElementById("c_id").value = element.id
                                    document.getElementById("start_date").value =  element.start_date;
                                    document.getElementById("c_os").value = element.name;

                                    var modal  = new bootstrap.Modal(
                                        document.getElementById('confirmEndAssignmentOS')
                                    );
                                    modal.show();
                                })

                                if(element.end_date && element.end_date <= new Date().toISOString().slice(0, 10)) {
                                    btn.disabled = true;
                                }

                                td5.appendChild(btn);

                                tr = document.createElement("tr");
                                tr.appendChild(td0);
                                tr.appendChild(td1);
                                tr.appendChild(td2);
                                tr.appendChild(td6);
                                tr.appendChild(td3);
                                tr.appendChild(td4);
                                tr.appendChild(td5);
                                
                                body.appendChild(tr);
                            });
                            employee_no.value = ""
                        }                        
                    });
            } else {
                body = document.getElementById("tableBody");
                body.innerText = "";
                document.getElementById("assigneOsBtn").disabled = true;
                document.getElementById("emp_no").value = "";
                document.getElementById("name").value = ""; 

                document.getElementsByName("employee_name").forEach(function (item) {
                    item.value = "";
                });
                document.getElementsByName("employee_no").forEach(function (item) {
                    item.value = "";
                });
                document.getElementById("c_employee_id").value = "";
            } 
        });
    }
}

function openModel(id){
    var modal  = new bootstrap.Modal(
        document.getElementById(id)
    );
    modal.show();
}