class Methods{

    remove(id){

        var element = document.getElementById(id);
        var permission = confirm("Click ok to remove the item.");
    
        if(permission){
    
            element.href="index.php?remove=&Id="+id;
        }
        else{
    
            element.href="index.php";
        }
    }

    cashToChange(i){
        var totalAmount = $('#totalAmount-content').html().substr(1);
        var cash = i.value;
        var change = cash - totalAmount;
        $('.change').html("&#8369;"+change.toFixed(2));
        
    }

    logout(i){

        var decision = confirm("Are you sure you want to logout the system?");
    
        if(decision){
    
            var today = new Date();
            var dateOut = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
            var timeOut = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    
            i.href="index.php?dateOut=" + dateOut + "&" + "timeOut=" + timeOut + "&" + "logout=";
    
        }
    
    }

    displayDateTime(){

        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();

        document.getElementById('date-in').value = date;
        document.getElementById('time-in').value = time;
    }
}

var methods = new Methods();