var Detail = React.createClass({
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
  	handleCommentSubmit: function(comment) {
  		var comments = this.state.data;
	    var newComments = comments.concat([comment]);
	    this.setState({data: newComments});

    	$.ajax({
	    	url: this.props.urlData,
	    	dataType: 'json',
	    	type: 'get',
	    	data: comment,
	    	success: function(data) {
	        	this.setState({data: data});
	    	}.bind(this),
	    	error: function(xhr, status, err) {
	    		this.setState({data: comments});
	        	console.error(this.props.urlData, status, err.toString());
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
		var Slide_p = this.state.data.map(function(a) {
	    	return (
	        	<Slide 
					p_image = {a.path} >
				</Slide>
	    	);
	    });
	    var Info_p = this.state.data.map(function(a) {
	    	return (
	        	<Info 
	        		id={a.id}
					p_name={a.p_name} 
					p_id={a.p_id} 
					key={a.id} 
					p_price={a.p_price} 
					p_discount={a.p_discount}
					p_long_description={a.p_long_description} >
				</Info>
	    	);
	    });
	    var Other_p = this.state.data.map(function(a) {
	    	return (
	        	<Other 
	        		id={a.id}
	        		p_image = {a.path}
					p_name={a.p_name} 
					p_id={a.p_id} 
					key={a.id} 
					p_price={a.p_price}  >
				</Other>
	    	);
	    });
		return (
			<div className="Infomation_p">
				<div className="row">
		        	{Slide_p}
		        </div>
		       
		        <div className="row">
		        	{Info_p}
		        </div>

		        <div className="row">
		        	{Other_p}
		        </div>	        
			</div>
		);	
	}
});
	// slide
	var Slide = React.createClass({
		render: function(){
			return(			
				<div id="myCarousel" className="carousel slide" data-ride="carousel">
				 
					<ol className="carousel-indicators">
					    <li data-target="#myCarousel" data-slide-to="0" className="active"></li>
					    <li data-target="#myCarousel" data-slide-to="1"></li>
					    <li data-target="#myCarousel" data-slide-to="2"></li>
					    <li data-target="#myCarousel" data-slide-to="3"></li>
					</ol>

					<div className="carousel-inner" role="listbox">
					    <div class="item">
					    	<img src={this.props.p_image} alt="Chania" />
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
		}
	});
	// info product
	var Info = React.createClass({
		render: function(){
			return (
				<div className="row" >
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

				        <Connect/>				        

						<div class="detail col-xs-12 col-md-12"> 
							<h2>Long description:</h2>
							<span>{this.props.p_long_description}</span>
						</div>		

						<Comment urlData="http://localhost/pyrocms/products/comment/" onCommentSubmit={this.handleCommentSubmit} />			
					</div>	
								
				</div>
			);
		}
	});
	// Connect
	var Connect = React.createClass({
	  	render: function(){
	    	return(
		      	<div className="row">
					<div className="connect  btn-group  btn-group-justified">							
							<a className="btn btn-primary" href="#" role="button"><i className="fa fa-heart-o" aria-hidden="true"> Like </i></a>
					
							<a className="btn btn-success" href="#" role="button"><i className="fa fa-comment-o" aria-hidden="true"> Comment </i></a>
						
							<a className="btn btn-danger" href="#" role="button"><i className="fa fa-share-alt" aria-hidden="true"> Share </i></a>
					</div>			 
				</div>
		    );
	  	}
	});
	// Comment
	var Comment = React.createClass({
		getInitialState: function() {
		    return { comment: ''};
		},
		handleTextChange: function(e) {
		    this.setState({comment: e.target.value});
		},
		handleSubmit: function(e) {
		    e.preventDefault();
		    var comment = this.state.comment.trim();
		    if (!comment) {
		      return;
		    }
		    this.props.onCommentSubmit({comment:comment});
		    this.setState({comment:''});
		},
	  	render: function(){
	    	return(
		      	<div className="row">
					<div class="properties-detail">
						<div class="col-xs-12 col-md-12"> 
							<h2>Comment:</h2>
							<form className="comment" onSubmit={this.handleSubmit}>
						    	<textarea rows="5" cols="100" value={this.state.comment}
         									onChange={this.handleTextChange} className="commentText">
         						</textarea>
						        <input className="btn-success" type="submit" value="Comment" />
						    </form>
						</div>
					</div>			 
				</div>
		    );
	  	}
	});
	// other products
	var Other = React.createClass({
	  	render: function(){
	    	return(
		      	<div className="another-product col-xs-12 col-md-12">
					<div className="img-product col-xs-6 col-md-6">

						<img className="img-responsive" src={this.props.p_image} />	

						<div className="col-xs-12 col-md-12">
							<p className="another-label"> {this.props.p_name} </p>			
						</div>
						<div className="col-xs-12 col-md-12">
							<p className="another-label"> Price :</p>	
							<span className="another-content">{this.props.p_price}</span> 
						</div>
	
					</div>
		      	</div>
		    );
	  	}
	});
ReactDOM.render(
  <Detail url="http://localhost/pyrocms/products/detail/1"/>, document.getElementById('detail')
);