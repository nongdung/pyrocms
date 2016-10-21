var Slide =  React.createClass({
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
    var Image = this.state.data.map(function(a) {
	      return (
	        <div id="myCarousel" className="carousel slide" data-ride="carousel">

			<ol className="carousel-indicators">
			    <li data-target="#myCarousel" data-slide-to="0" className="active"></li>
			    <li data-target="#myCarousel" data-slide-to="1"></li>
			    <li data-target="#myCarousel" data-slide-to="2"></li>
			    <li data-target="#myCarousel" data-slide-to="3"></li>
			</ol>

			<div className="carousel-inner" role="listbox">
			    <div className="item active">
			    	<img src={a.path} />
				</div>
				<div className="item">
			    	<img src={a.path} />
				</div>
				<div className="item">
			    	<img src={a.path} />
				</div>
				<div className="item">
			    	<img src={a.path} />
				</div>	
			</div>

			<a className="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			   <span className="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			   <span className="sr-only">Previous</span>
			</a>
			<a className="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			   <span className="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			   <span className="sr-only">Next</span>
			</a>
		</div>
	      );
	    });
	    return (
	    	<div >
	        	{Image}
	    	</div>
	    );
  	}	
});

ReactDOM.render(
  <Slide url="http://localhost/pyrocms/products/detail/4"/>, document.getElementById('slide')
);