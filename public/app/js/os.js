var modal1 = document.getElementById('assignOS');
modal1.addEventListener("show.bs.modal", function(e) {
    elementId = e.relatedTarget.value
    item = document.getElementById("assignOSModalLabel")
    item.innerText = "تعيين الموظف على الهيكلية/" + document.getElementById("elementName_"+elementId).text.trim()
    
    document.getElementById("c_os_id").value = elementId
    document.getElementById("c_os").value = document.getElementById("elementName_"+elementId).text.trim()
    
}, false);

// TODO_AYA: check if os is not empty before sending the emp_no
function getEmp(){
    employee_no = document.getElementById("employee_no")
    if(employee_no.value) {
        post(`/os/get_user`, { "employee_no": employee_no.value }).then((response) => {
            if (response.ok) {
                response
                    .json()
                    .then((response) => {
                        employee_no.value = ""
                        if(response[0].rowCount == 1) {
                            // cleare model
                            document.getElementsByName("start_date")[0].value = ""
                            document.getElementsByName("end_date")[0].value = ""

                            // open the confirmation model
                            document.getElementById("c_employee_name").value = response[0].result.f_name + " " + response[0].result.l_name
                            document.getElementById("c_employee_no").value = response[0].result.employee_no
                            document.getElementById("c_employee_id").value = response[0].result.id

                            if(response[1].rowCount > 0) {
                                empCurrentOS = document.getElementById('emp_current_os');
                                empCurrentOS.innerHTML = '';
                                response[1].result.forEach((item) => {
                                    var osElement = document.createElement('input');
                                    osElement.className  = "form-control"
                                    osElement.value = item.os_name
                                    osElement.disabled = true;											
                                    empCurrentOS.appendChild(osElement);
                                });
                            }

                            var modal  = new bootstrap.Modal(
                                    document.getElementById('confirmAssignOS')
                                );
                            modal.show();
                        } else {
                            // TODO_Aya: Display a correct error message.
                            alert("ارجو ادخال رقم صحيح")
                        }
                    });
            }
        });
    }			
}

//TODO_Aya: merge the following code with the one inside employee.js
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
    selectedOption = getSelectedOptionFromDL("job_dl")
    document.getElementsByName("c_job_id")[0].value = selectedOption

    selectedOption = getSelectedOptionFromDL("role_dl")
    document.getElementsByName("c_role_id")[0].value = selectedOption

    return true;
}
//