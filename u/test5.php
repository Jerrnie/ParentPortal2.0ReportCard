<style>
ul {
  list-style: none;
  padding: 0;
  margin: 0;  
}

ul li {
  display: block;
  position: relative;
  float: left;
  background: red;
  width: 215px;
}

li ul { display: none; }

ul li  .secondary-title{
  display: block;
  padding: 1em;
  text-decoration: none;
  white-space: nowrap;
  color: #fff;
}

ul li .secondary-title:hover { background: black; color:white; cursor: pointer; }

li:hover > ul {
  display: block;
  position: absolute;
}

li:hover li { float: none; }

li:hover .secondary-title { background: white; color:black; border: #ddd solid 1px; }

li:hover li .secondary-title:hover { background: black; color:white; }

.main-navigation li ul li { border-top: 0; }

ul ul ul {
  left: 100%;
  top: 0;
}
ul:before,
ul:after {
  content: " "; /* 1 */
  display: table; /* 2 */
}

ul:after { clear: both; }
</style>
<ul class="main-navigation">  
  <li><a class="secondary-title">All Catalog</a>
    <ul>
    <li><a class="secondary-title" href="#">Pre-School & Grade School</a>
        <ul>
          <li><a class="secondary-title" href="#">Resets</a></li>
          <li><a class="secondary-title" href="#">Grids</a></li>
          <li><a class="secondary-title" href="#">Frameworks</a></li>
        </ul>
      </li>
      <li><a class="secondary-title" href="#">CSS</a>
        <ul>
          <li><a class="secondary-title" href="#">Junior High School</a></li>
          <li><a class="secondary-title" href="#">Grids</a></li>
          <li><a class="secondary-title" href="#">Frameworks</a></li>
        </ul>
      </li>
      <li><a class="secondary-title" href="#">Senior High School</a>
        <ul>
          <li><a class="secondary-title" href="#">Ajax</a></li>
          <li><a class="secondary-title" href="#">jQuery</a></li>
        </ul>
      </li>
    </ul>
  </li>  
</ul>