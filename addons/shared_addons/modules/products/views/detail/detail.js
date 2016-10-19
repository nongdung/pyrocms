var Detail = React.createClass({
	loadDetailFromServer: function() {
	    $.ajax({
	    	url: this.props.url ,
	    	dataType: 'json',
	    	cache: false,
	    	success: function(data) {
	        	this.setState({data: data});
	      	}.bind(this),
	      	error: function(xhr, status, err) {
	        	console.error(this.props.url, status, err.toString());
	      	}.bind(this)
	    });
	},
	getInitialState: function() {
	    return {data: []};
	},
	componentDidMount: function() {
		this.loadDetailFromServer();  
	},
	render: function() {
		var Info_p = this.state.data.map(function(a) {
	    	return (
	        	<Info  path={a.path}
	        		id={a.id}
					p_name={a.p_name} 
					p_id={a.p_id} 
					key={a.id} 
					p_price={a.p_price} 
					p_discount={a.p_discount}
					p_long_description={a.p_long_description} >
				</Info>
	    	);
	    }); /* end Info_p */
	    var Other_p = this.state.data.map(function(a) {
	    	return (
	        	<Other 
	        		id={a.id}
	        		path = {a.path}
					p_name={a.p_name} 
					p_id={a.p_id} 
					key={a.id} 
					p_price={a.p_price}  >
				</Other>
	    	);
	    });
		return (
			<div className="product">
		       {Info_p}
		       {Other_p}
	      	</div>
		);
	}
});	/* end Detail */

var Info = React.createClass({
	render: function(){
		return (
			<div className="row" >
				<img className="img-product img-responsive" src={this.props.path}/>
				<div className="properties-detail">
					<div className="detail col-xs-12 col-md-12">
						<p className="properties-label"> Product Name :</p>
						<span className="properties-content">{this.props.p_name}</span>	
					</div>

					<div className="detail col-xs-6 col-md-6">
						<p className="properties-label"> Code :</p>
						<span className="properties-content"> {this.props.p_id} </span>	
					</div>

					<div className="detail col-xs-6 col-md-6">
						<p className="properties-label"> Price :</p>
						<span className="properties-content"> {this.props.p_price} đ </span>	
					</div>

					<div className="detail col-xs-6 col-md-6">
						<p className="properties-label"> Discount :</p>
						<span className="properties-content"> {this.props.p_discount}%  </span>
					</div>

					<div className="detail col-xs-6 col-md-6">
						<p className="properties-label"> Rate :</p>
						<span className="properties-content">
							<i className="fa fa-star" aria-hidden="true"></i>
						</span>	
					</div>

					<div className="detail col-xs-12 col-md-12">
						<p className="properties-label"> Serving hour :</p>
						<span className="properties-content"> 7:00 AM - 7:00 PM </span>
					</div>				        					
				</div>	

				<div className="properties-detail">	
					<div class="detail col-xs-12 col-md-12"> 
						<h2>Long description:</h2>
						<span>{this.props.p_long_description}</span>
					</div>	
				</div>			
			</div>
		);
	}
}); /* end Info */

var Other = React.createClass({
  	render: function(){
    	return(
    		<div className="row">
	    		<h2> Sản phẩm liên quan </h2>
		      	<div className="other-product col-xs-12 col-md-12">
					<div className="img-other-product col-xs-6 col-md-6">

						<img  src={this.props.path} />	

						<div className="col-xs-12 col-md-12">
							<p className="another-label"> {this.props.p_name} </p>			
						</div>

						<div className="col-xs-12 col-md-12">
							<p className="another-label"> Price :</p>	
							<span className="another-content">{this.props.p_price}</span> 
						</div>

					</div>
		      	</div>
		    </div>
	    );
  	}
}); /* end Other */

ReactDOM.render(
	<Detail url={'http://localhost/pyrocms/products/detail/1'}/>,
	document.getElementById('detail')
);