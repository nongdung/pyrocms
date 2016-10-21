var Des = React.createClass({
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
		var Des_p = this.state.data.map(function(a){
			return (
				<div className="properties-detail">
					<div className="col-xs-12 col-md-12"> 
						<h2>Long description:</h2>
						<span>{a.p_long_description}</span>
					</div>
				</div>		
			);
		});
		return (
		    <div >
		        {Des_p}
		    </div>
		);		
	}
});
ReactDOM.render(
  <Des url="http://localhost/pyrocms/products/detail/4"/>, document.getElementById('description')
);