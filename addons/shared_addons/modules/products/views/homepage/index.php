<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>React Tutorial</title>
    <!-- Not present in the tutorial. Just for basic styling. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url("addons/shared_addons/modules/products")?>/css/mystyle.css" />
    <script src="https://unpkg.com/react@15.3.0/dist/react.js"></script>
    <script src="https://unpkg.com/react-dom@15.3.0/dist/react-dom.js"></script>
    <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
    <script src="https://unpkg.com/jquery@3.1.0/dist/jquery.min.js"></script>
    <script src="https://unpkg.com/remarkable@1.6.2/dist/remarkable.min.js"></script>
  
  </head>
  <body>
    <div class="jumbotron">
      <div class="container text-center">
        <h1>Main Menu</h1>
      </div>
    </div>
    
    <div id="product"></div>
    <script type="text/babel" src="<?php echo base_url("addons/shared_addons/modules/products")?>/views/homepage/main.js"></script>
    
   
   
  </body>
</html>

