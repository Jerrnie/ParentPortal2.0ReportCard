

var clickedcategory = '';
function sidebarfunction(clickedcategory){

    if (clickedcategory=='history'){
            var element = document.getElementById("option2");
            element.classList.add("active");
            var element = document.getElementById("option6");
            element.classList.remove("active");
            var element = document.getElementById("option1");
            element.classList.remove("active");
            var element = document.getElementById("option3");
            element.classList.remove("active");
            var element = document.getElementById("option4");
            element.classList.remove("active");
            var element = document.getElementById("option5");
            element.classList.remove("active");
            $('#panelhistory').show();
            $('#panebuild').hide();
            $('#panelinfo').hide();
            $('#panelsetting').hide();
            $('#paneloder').hide();
            $('#panelpayment').hide();
    }
    else if (clickedcategory=='setting'){
            var element = document.getElementById("option3");
            element.classList.add("active");
            var element = document.getElementById("option6");
            element.classList.remove("active");
            var element = document.getElementById("option1");
            element.classList.remove("active");
            var element = document.getElementById("option2");
            element.classList.remove("active");
            var element = document.getElementById("option4");
            element.classList.remove("active");
            var element = document.getElementById("option5");
            element.classList.remove("active");
            $('#panelsetting').show();
            $('#panebuild').hide();
            $('#panelinfo').hide();
            $('#panelhistory').hide();
            $('#paneloder').hide();
            $('#panelpayment').hide();


    }
    else if (clickedcategory=='order'){
            var element = document.getElementById("option4");
            element.classList.add("active");
            var element = document.getElementById("option6");
            element.classList.remove("active");
            var element = document.getElementById("option1");
            element.classList.remove("active");
            var element = document.getElementById("option3");
            element.classList.remove("active");
            var element = document.getElementById("option2");
            element.classList.remove("active");
            var element = document.getElementById("option5");
            element.classList.remove("active");
            $('#paneloder').show();
            $('#panebuild').hide();
            $('#panelinfo').hide();
            $('#panelsetting').hide();
            $('#panelhistory').hide();
            $('#panelpayment').hide();

    }else if(clickedcategory =='payment'){
            var element = document.getElementById("option6");
            element.classList.add("active");
            var element = document.getElementById("option5");
            element.classList.remove("active");
            var element = document.getElementById("option1");
            element.classList.remove("active");
            var element = document.getElementById("option2");
            element.classList.remove("active");
            var element = document.getElementById("option3");
            element.classList.remove("active");
            var element = document.getElementById("option4");
            element.classList.remove("active");
            $('#panelinfo').hide();
            $('#panelhistory').hide();
            $('#panelsetting').hide();
            $('#paneloder').hide();
            $('#panebuild').hide();
            $('#panelpayment').show();
    }
    else if (clickedcategory=='build') {
            var element = document.getElementById("option5");
            element.classList.add("active");
            var element = document.getElementById("option6");
            element.classList.remove("active");
            var element = document.getElementById("option1");
            element.classList.remove("active");
            var element = document.getElementById("option2");
            element.classList.remove("active");
            var element = document.getElementById("option3");
            element.classList.remove("active");
            var element = document.getElementById("option4");
            element.classList.remove("active");
            $('#panelinfo').hide();
            $('#panelhistory').hide();
            $('#panelsetting').hide();
            $('#paneloder').hide();
            $('#panebuild').show();
            $('#panelpayment').hide();

    }

    else{
            var element = document.getElementById("option1");
            element.classList.add("active");
            var element = document.getElementById("option2");
            element.classList.remove("active");
            var element = document.getElementById("option3");
            element.classList.remove("active");
            var element = document.getElementById("option4");
            element.classList.remove("active");
            var element = document.getElementById("option5");
            element.classList.remove("active");
            $('#panelinfo').show();
             $('#panebuild').hide();
            $('#panelhistory').hide();
            $('#panelsetting').hide();
            $('#paneloder').hide();
    }

}