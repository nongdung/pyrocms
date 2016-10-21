var AnotherProduct = React.createClass({
	loadCommentsFromServer: function() {
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
		this.loadCommentsFromServer();
	   
	},
	render: function() {
		var Another_p = this.state.data.map(function(a){
			return (
			<div>
				<div className="another-product-label">		
					<h2  className="col-xs-12 col-md-12">Các sản phẩm liên quan:</h2>
				</div>
				<div className="img-product col-xs-6 col-md-6">

					<img className="img-responsive" src={a.path} />
					<div className="col-xs-12 col-md-12">
						<p className="another-label"> {a.p_name} </p>			
					</div>
					<div className="col-xs-12 col-md-12">
						<p className="another-label"> Price :</p>	
						<span className="another-content"> {a.p_price}</span> 
					</div>			
		
				</div>
			</div>		
			);
		});
		return (
	    	<div >
	        	{Another_p}
	    	</div>
	    );
		
	}
});
ReactDOM.render(
  <AnotherProduct url="http://localhost/pyrocms/products/detail/2"/>, document.getElementById('another')
);