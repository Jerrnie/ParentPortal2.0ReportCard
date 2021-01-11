
<!DOCTYPE html> 
<html> 
  
<head> 
    <title> 
      Show and Hide div elements using radio buttons 
    </title> 
    <script src= 
"https://code.jquery.com/jquery-1.12.4.min.js"> 
    </script> 
    <style type="text/css"> 
        .selectt { 
            color: #fff; 
            padding: 30px; 
            display: none; 
            margin-top: 30px; 
            width: 60%; 
            background: green 
        } 
          
        label { 
            margin-right: 20px; 
        } 
    </style> 
</head> 
  
<body> 
    <center> 
        <h1 style="color:green;">  
          GeeksforGeeks  
        </h1> 
        <h3>  
          Show and Hide div elements using radio buttons 
        </h3> 
        <div> 
            <label> 
                <input type="radio" name="colorRadio" 
                       value="C"> C</label> 
            <label> 
                <input type="radio" name="colorRadio" 
                       value="Cplus"> C++</label> 
            <label> 
                <input type="radio" name="colorRadio" 
                       value="Python"> Python</label> 
            <label> 
                <input type="radio" name="colorRadio" 
                       value="Java"> Java</label> 
        </div> 
        <div class="C selectt"> 
          <strong>C</strong> 
          is a procedural programming language</div> 
        <div class="Cplus selectt"> 
          <strong>C++</strong> 
          is a general purpose programming language</div> 
        <div class="Python selectt"> 
          <strong>Python</strong>  
          is a widely used general-purpose, high level 
          programming language.</div> 
        <div class="Java selectt"> 
          <strong>Java</strong>  
          is a most popular programming language for 
          many years.</div> 
          
        <script type="text/javascript"> 
            $(document).ready(function() { 
                $('input[type="radio"]').click(function() { 
                    var inputValue = $(this).attr("value"); 
                    var targetBox = $("." + inputValue); 
                    $(".selectt").not(targetBox).hide(); 
                    $(targetBox).show(); 
                }); 
            }); 
        </script> 
    </center> 
</body> 
  
</html> 