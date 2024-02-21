function getVacbalance() {

    let vacation_type = document.getElementById("vacation_type").value;
    let employee_id = document.getElementById("employee_id").value;
     
    post('/vacation/getManTOEmpVacBal', {vacation_type: vacation_type, employee_id: employee_id})
        .then(response => {
            if (response.ok) { 										
                response.json().then(response => set_balance_data(response))
            }
        })

}

function set_balance_data(data){
    console.log(data);
    if(data['rowCount'] === 0){
        document.getElementById("start_balance").value = '';
        document.getElementById("current_balance").value = '';
        document.getElementById("spent_balance").value = '';
    }else{
        document.getElementById("start_balance").value = data['result'].start_balance;
        document.getElementById("current_balance").value = data['result'].current_balance;
        document.getElementById("spent_balance").value = (data['result'].start_balance - data['result'].current_balance);
    }
    get_ann_vac_type();

}


function get_ann_vac_type() {

    var vacation_type = document.getElementById("vacation_type").value;

    if (vacation_type == 1) {        
    document.getElementById("annual_div").className = "d-block";
    }else{
        document.getElementById("annual_div").className = "d-none";
    }
}


function addClassNameListener(elemId, callback) {
var elem = document.getElementById("annual_div");
var lastClassName = elem.className;
 var className = elem.className;
    if (className !== lastClassName) {
        callback();   
        lastClassName = className;
    }
// get_ann_vac_type();
}

function cal_days() {

    let start_date = document.getElementById("start_date").value;
    let end_date = document.getElementById("end_date").value;
    let current_balance = document.getElementById("current_balance").value;

    document.getElementById("day_count").value = '';

    let day_count = 0;
   

    //if(start_date.length !== 0 && end_date.length !== 0 ){
        
        let date1 = Date.parse (start_date);
        let date2 = new Date (end_date);
        let now = new Date();

       // document.getElementById("day_count").value = (Math.round((date2 - date1) / (1000 * 60 * 60 * 24))) + 1 ;


        document.getElementById("invalid-dates").style.display = 'none';
      //  if(start_date.length !== 0 && end_date.length !== 0 ){


            if((Math.round((date1 - now) / (1000 * 60 * 60 * 24))) < 0) {
                 document.getElementById("invalid-dates").style.display = 'block';
                document.getElementById("invalid-dates").innerHTML ='خطأ في تاريح البداية';   

            }else{
                document.getElementById("day_count").value = '';
                day_count = (Math.round((date2 - date1) / (1000 * 60 * 60 * 24))) + 1 ;

                if (day_count > 0) {

                    if(current_balance.length !==0 && current_balance < day_count){
                        document.getElementById("day_count").value = day_count;
                        document.getElementById("invalid-dates").style.display = 'block';
                        document.getElementById("invalid-dates").innerHTML ='الرصيد اقل من عدد ايام الاجازة';
                    }else{
                        document.getElementById("day_count").value = day_count;
                    }
                
                }else if (day_count <= 0){
                    document.getElementById("invalid-dates").style.display = 'block';
                    document.getElementById("invalid-dates").innerHTML = 'خطأ في ادخال التواريخ';

                }
            }
       // }
  }

