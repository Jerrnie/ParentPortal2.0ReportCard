<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
.arrow {
  border: solid white;
  border-width: 0 3px 3px 0;
  display: inline-block;
  padding: 3px;
}
.navbar2 {
  overflow: hidden;
  background-color: #cd2122;
  width:220px;
  padding-top: 15px;
  font-family: Roboto;
  cursor: pointer;
  color: white;
  border: #ddd solid 2px;
}
.dropdown-contents .title{  
  text-align: left;
}
.navbar2 .menu {
  float: left;
  color: white;
  text-align: center;
  text-decoration: none;
  border: #ddd solid 1px;
  
}

.dropdown2 .navbar2 {
  float: left;
  overflow: hidden;
  color: white;

}
.dropdown2 .dropbtn2 {
  cursor: pointer;
  font-size: 15px; 
  border: none;
  color: white;
  padding: 5px 10px;
  background-color: inherit;
  
}

.navbar2:hover, .menu:hover, .dropdown2:hover .dropbtn2 {
  background-color: black;
  color:white;
}

.dropdown-contents {
  display: none;
  background-color: #f9f9f9;
  min-width: 160px;
  z-index: 1;
}

.dropdown-contents .menu {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
  font-size: 16px;
  font-family: Roboto;
}

.dropdown-contents .menu:hover {
  background-color: black;
  color: white;
  
}

.dropdown2:hover .dropdown-contents {
  display: block;
  
}
.down {
  transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
}

</style>
</head>
<body>

<div class="navbar2">
<div class="dropdown2"><button class="dropbtn2">All Catalog</button>
<div class="dropdown-contents">
<a class="menu" href="../pre-school-and-grade-school/"><strong>Pre-School &amp; Grade School</strong></a>
<a class="menu" href="../nursery/">Nursery</a>
<a class="menu" href="../kinder-1/">Kinder 1</a>
<a class="menu" href="../kinder-2/">Kinder 2</a>
<a class="menu" href="../grade-1/">Grade 1</a>
<a class="menu" href="../grade-2/">Grade 2</a>
<a class="menu" href="../grade-3/">Grade 3</a>
<a class="menu" href="../grade-4/">Grade 4</a>
<a class="menu" href="../grade-5/">Grade 5</a>
<a class="menu" href="../grade-6/">Grade 6</a>
<a class="menu" href="../junior-high-school/"><strong>Junior High school</strong></a>
<a class="menu" href="../grade-7/">Grade 7</a>
<a class="menu" href="../grade-8/">Grade 8</a>
<a class="menu" href="../grade-9/">Grade 9</a>
<a class="menu" href="../grade-10/">Grade 10</a>
<a class="menu" href="../senior-high-school/"><strong>Senior High School</strong></a>
<a class="menu" href="../grade-11/">Grade 11</a>
<a class="menu" href="../grade-12/">Grade 12</a>
</div>
</div>
</div>

</body>
</html>
