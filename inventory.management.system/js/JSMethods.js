class JSMethods{

    sampleclick(){

        console.log("Good");
    }
    
    logout(){

        var element = document.getElementById('logout');
        var permission = confirm("Are you sure you want to logout the system?");

        if(permission){

            element.href="index.php?logout=";
        }
        else{

            element.href="index.php";
        }
    }

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

    removeItemFromSearch(id){

        var element = document.getElementById(id);
        var permission = confirm("Click ok to remove the item.");

        if(permission){

            element.href="search.php?remove=&Id="+id;
        }
        else{

            element.href="search.php";
        }
    }
}

var methods = new JSMethods();