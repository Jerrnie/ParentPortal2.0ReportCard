

var current = '';
function buildfucntion(clickedcategory){

    if (clickedcategory=='build'){
             var element = document.getElementById("build");
             element.classList.add("dsshidden");
             var element = document.getElementById("scratch");
             element.classList.add("dsshidden");
             var element = document.getElementById("dssback");
             element.classList.remove("dsshidden");
             var element = document.getElementById("gaming");
             element.classList.remove("dsshidden");
             var element = document.getElementById("office");
             element.classList.remove("dsshidden");
             current='gaming';
    }
    else if (clickedcategory=='dssback'){

        if (current=='gaming') {
             var element = document.getElementById("build");
             element.classList.remove("dsshidden");
             var element = document.getElementById("scratch");
             element.classList.remove("dsshidden");
             var element = document.getElementById("dssback");
             element.classList.add("dsshidden");
             var element = document.getElementById("gaming");
             element.classList.add("dsshidden");
             var element = document.getElementById("office");
             element.classList.add("dsshidden");
             current == 'build'
             }
    }

    

}