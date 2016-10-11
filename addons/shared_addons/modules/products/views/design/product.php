<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Detail</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="">
	<script src="https://use.fontawesome.com/2b7ea856ca.js"></script>
	<style>
		.properties-label {
			float:left;
			font-weight: bold;
			padding-right: 5%;
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
   			padding: 0px;
		}
		@media screen and (min-width: 768px) {
			.container-fluid{
				width:600px;
				margin: 0 auto;
			}
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		
		<div class="row">
			 {{ p_image:img }}
		</div> <!-- end img -->
	
		<div class="row">
			<div class="properties-detail">
				<div class="detail col-xs-12 col-md-12">
					<p class="properties-label"> Product Name :</p>
					<span class="properties-content"> {{ p_name }}</span>	
				</div>

				<div class="detail col-xs-6 col-md-6">
					<p class="properties-label"> Code :</p>
					<span class="properties-content">{{ p_id }} </span>	
				</div>
				<div class="detail col-xs-6 col-md-6">
					<p class="properties-label"> Price :</p>
					<span class="properties-content">{{ p_price }}</span>	
				</div>
				<div class="detail col-xs-6 col-md-6">
					<p class="properties-label"> Discount :</p>				
					{{ if discount }} 
						<span class="properties-content">{{ p_discount }}%</span>
					
					{{ else }} 
						<span class="properties-content"> 0%  </span> 
	    			{{ endif }}
				</div>
				<div class="detail col-xs-6 col-md-6">
					<p class="properties-label"> Rate :</p>
					<span class="properties-content">
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
						<i class="fa fa-star" aria-hidden="true"></i>
					</span>	
				</div>
				<div class="detail col-xs-12 col-md-12">
					<p class="properties-label"> Serving hour :</p>
					<span class="properties-content"> 7:00 AM - 7:00 PM </span>
				</div>
			</div>				
		</div>
		
		<div class="row">
			<div class="connect  btn-group  btn-group-justified">							
					<a class="btn btn-primary" href="#" role="button"><i class="fa fa-heart-o" aria-hidden="true"> Like </i></a>
			
					<a class="btn btn-success" href="#" role="button"><i class="fa fa-comment-o" aria-hidden="true"> Comment </i></a>
				
					<a class="btn btn-info" href="#" role="button"><i class="fa fa-share-alt" aria-hidden="true"> Share </i></a>
			</div>			 
		</div>
		
		<div class="row">
			<div class="properties-detail">
				<div class="col-xs-12 col-md-12"> 
					<h2>Long description:</h2>
					<span>{{ p_long_description }}</span>
				</div>
			</div>			
		</div>
		
		<div class="row">
			<div class="properties-detail">
				<div class="col-xs-12 col-md-12"> 
					<h2>Comment:</h2>
					<span>Font Awesome gives you scalable vector icons that can instantly be customized — size, color, drop shadow, and anything that can be done with the power of CSS.</span>
				</div>
			</div>
		</div>
		
		<div class="another-product-label">		
			<h2  class="col-xs-12 col-md-12">Các sản phẩm liên quan :</h2>
		</div>

		<div class="row">
			<div class="another-product col-xs-12 col-md-12">
				<div class="img-product col-xs-6 col-md-6">

					<img class="img-responsive" src="book.jpg">	

					<div class="col-xs-12 col-md-12">
						<p class="another-label"> Product Name </p>			
					</div>
					<div class="col-xs-12 col-md-12">
						<p class="another-label"> Price :</p>	
						<span class="another-content"> 50.000</span> 
					</div>
	
				</div>	<!-- end img-product -->
				<div class="img-product  col-xs-6 col-md-6">

					<img class="img-responsive" src="book.jpg">	

					<div class="col-xs-12 col-md-12">
						<p class="another-label"> Product Name </p>			
						
					</div>
					<div class="col-xs-12 col-md-12">
						<p class="another-label"> Price :</p>	
						<span class="another-content"> 50.000</span> 
					</div>
	
				</div>	<!-- end img-product -->			
			</div>
			<div class="another-product col-xs-12 col-md-12">
				<div class="img-product col-xs-6 col-md-6">

					<img class="img-responsive" src="book.jpg">	

					<div class="col-xs-12 col-md-12">
						<p class="another-label"> Product Name </p>			
					</div>
					<div class="col-xs-12 col-md-12">
						<p class="another-label"> Price :</p>	
						<span class="another-content"> 50.000</span> 
					</div>
	
				</div>	<!-- end img-product -->
				<div class="img-product col-xs-6 col-md-6">

					<img class="img-responsive" src="book.jpg">	

					<div class="col-xs-12 col-md-12">
						<p class="another-label"> Product Name </p>			
						
					</div>
					<div class="col-xs-12 col-md-12">
						<p class="another-label"> Price :</p>	
						<span class="another-content"> 50.000</span> 
					</div>
	
				</div>	<!-- end img-product -->			
			</div>
		</div>
		

	</div>	<!-- end container-fluid -->
</body>
</html>