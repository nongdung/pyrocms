<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    
body{
    background-color:#DCDCDC;
}

.jumbotron .h1, .jumbotron h1 {
    color: #F8F8FF;
}

.dropdown.dropdown-lg .dropdown-menu {
        width: ;
    }

#adv-search{
     padding-top:0;
    padding-bottom:20px;
}
.dropdown.dropdown-lg .dropdown-menu {
    margin-top: -1px;
    padding: 6px 20px;
}
.input-group-btn .btn-group {
    display: flex !important;
    
}
.btn-group .btn {
    
    border-radius: 0;
    margin-left: -1px;
}
.btn-group .btn:last-child {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}
.btn-group .form-horizontal .btn[type="submit"] {
  border-top-left-radius: 4px;
  border-bottom-left-radius: 4px;
}
.form-horizontal .form-group {
    margin-left: 0;
    margin-right: 0;
}
.form-group .form-control:last-child {
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}

@media screen and (min-width: 768px) {
    .container{
        width: 600px;
        margin: 0 auto;
    }
    #adv-search {
        width: auto;
        margin: 0 auto;
    }
    .dropdown.dropdown-lg {
        position: static !important;
    }
    .dropdown.dropdown-lg .dropdown-menu {
        min-width: 500px;
    }
    }
    
    /* Remove the jumbotron's default bottom margin */
     .jumbotron {
         
      margin-bottom: 0;
      padding-top: 0px;
      padding-bottom: 0px;
      background-color:#DC143C;
    }
   
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }
  </style>
</head>
<body>

<!-- Menu -->
<div class="jumbotron">
  <div class="container text-center">
    <h1>Main Menu</h1>
    
  </div>
</div>

<!-- search box + filter-->
<div class="container">
   
	<div class="row">
		<div class="col-md-12">
            <div class="input-group" id="adv-search">
                <input type="text" class="form-control" placeholder="What do you need?..." />
                <div class="input-group-btn">
                    <div class="btn-group" role="group">
                        <div class="dropdown dropdown-lg">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <form class="form-horizontal" role="form">
                                    <div class="form-group">
                                    <label for="filter">Filter by</label>
                                    <select class="form-control">
                                        <option value="0" selected>All Snippets</option>
                                        <option value="1">Featured</option>
                                        <option value="2">Most popular</option>
                                        <option value="3">Top rated</option>
                                        <option value="4">Most commented</option>
                                    </select>
                                    </div>
                                     
                                    <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                </form>
                            </div>
                        </div>
                        <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </div>
                 </div>
            </div>
        </div>      
    </div>


<!-- list product-->
   <!-- Product One -->
    {{ products.entries }}    
    <div class="row">
        <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-xs-12">
                        <a href="{{ url:site }}products/detail/{{ id }}">
                           {{ p_image:img }}
                        </a>
                    </div>
                    <div class="col-xs-12">
                        
                        <h3>{{ p_name }}</h3>
                        <!-- <h4>Subheading</h4> -->
                        <p>{{ p_short_description }}</p>
                       
                       <p>Price: {{ p_price }} </p>
                        
                        <div class="btn-group btn-group-justified">
                            <a href="#" class="btn btn-default"><span class="glyphicon glyphicon-thumbs-up"></span></a>
                            <a href="#" class="btn btn-default"><span class="glyphicon glyphicon-comment"></span></a>
                            <a href="#" class="btn btn-default"><span class="glyphicon glyphicon-share-alt"></span></a>
                        </div>
                   
                    </div>
             </div>
        </div>
     </div>
     {{ /products.entries }} 
    <!-- /.row -->
    
    <div class="row text-center">
            <div class="col-lg-12">
                <ul class="pagination">
                    <li>
                        <a href="#">&laquo;</a>
                    </li>
                    <li class="active">
                        <a href="#">1</a>
                    </li>
                    <li>
                        <a href="#">2</a>
                    </li>
                    <li>
                        <a href="#">3</a>
                    </li>
                    <li>
                        <a href="#">4</a>
                    </li>
                    <li>
                        <a href="#">5</a>
                    </li>
                    <li>
                        <a href="#">&raquo;</a>
                    </li>
                </ul>
            </div>
        </div>
</div><br>

<br><br>

<footer class="container-fluid text-center">
  <p>Online Store Copyright</p>
  <form class="form-inline">Get deals:
    <input type="email" class="form-control" size="50" placeholder="Email Address">
    <button type="button" class="btn btn-danger">Sign Up</button>
  </form>
<footer>

</body>
</html>

