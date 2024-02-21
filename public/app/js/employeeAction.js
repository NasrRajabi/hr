

// عرض ملف الموظف 
function profile(button, row) {
   
    window.location.href = "/employee/profile/" + row.id;

 
  }

  function assignPosition (button, row){

    window.location.href = "/employee/assigne_position/" + row.employeeNo;
  }
