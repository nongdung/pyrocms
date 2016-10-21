<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pyro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.3.2/react.min.js"></script>
    <script src="https://unpkg.com/react-dom@15.3.2/dist/react-dom.js"></script>
    <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
    <script src="https://unpkg.com/jquery@3.1.0/dist/jquery.min.js"></script>
	<script src="https://use.fontawesome.com/2b7ea856ca.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style>
		.properties-label {
			float:left;
			font-weight: bold;
			padding-right: 1%;
		}
		.another-label {
			float:left;
			font-weight: bold;
			padding-right: 5%;
		}
		.connect {
			text-align: center;
			padding-top: 20px; 
		}
		.detail {
			height: 35px;
		}
		.properties-detail {
			padding: 10px;
		}
		.btn {
			height: 35px;
    		margin: 10px;
		}
		img {
			width: 100%;
		}
		.img-product img {
			padding-bottom:10px;
		}
		.img-product {
			padding: 2px;
		}
		@media screen and (min-width: 768px) {
			.container-fluid{
				width:800px;
				margin: 0 auto;
			}
		}
		.carousel-inner > .item > img,
		.carousel-inner > .item > a > img {
		    width: 100%;
		    margin: auto;
		}
	</style>
</head>
<body>
	 	<div id="detail" class="row"></div>
    	<script type="text/babel" src="<?php echo base_url('addons/shared_addons/modules/products/js')?>/detail.js"></script>

</body>
</html>