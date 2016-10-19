/* Comment Box */		
var CommentBox = React.createClass({			
	loadCommentsFromServer: function() {
	    $.ajax({
	    	url: this.props.url,
	      	dataType: 'json',
	      	cache: false,
	      	success: function(data) {
	        	this.setState({data: data});
	      	}.bind(this),
	      	error: function(xhr, status, err) {
	      		this.setState({data: comments});
	        	console.error(this.props.url, status, err.toString());
	      	}.bind(this)
	    });
  	},
 	handleCommentSubmit: function(comment) {
  		var comments = this.state.data;
		var newComments = comments.concat([comment]);
		this.setState({data: newComments});
	    $.ajax({
	    	url: this.props.url,
	     	dataType: 'json',
	      	type: 'POST',
	      	data: comment,
	      	success: function(data) {
	        	this.setState({data: data });
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
		return (
			<div className="commentBox">
		        <h2>Comments</h2>
		        <CommentList data={this.state.data} />
		        <CommentForm onCommentSubmit={this.handleCommentSubmit} />
	      	</div>
		);
	}
});
/* Comment List */
var CommentList = React.createClass({
	render: function() {
		var commentNodes = this.props.data.map(function(comment) {
	    	return (
		        <Comment key={comment.id}>
		        	{comment.comments}
		        </Comment>
	    	);
	    });
		return (
			<div className="commentList">
		        {commentNodes}
		    </div>
		);
	}
});
/* Comment Form */
var CommentForm = React.createClass({
	getInitialState: function() {
	    return {comment: ''};
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
    this.props.onCommentSubmit({comment: comment});
    this.setState({comment: ''});
},

render: function() {
	return (					
		<form className="commentForm" onSubmit={this.handleSubmit}>
	        <p><textarea rows="4" cols="50" placeholder="Say something..." 
	        		value={this.state.comment}
						onChange={this.handleTextChange}>
			</textarea> </p>
	        <input type="submit" value="Comment" />
	    </form>
	);
}
});
/* Comment */
var Comment = React.createClass({
	rawMarkup: function() {
	    var md = new Remarkable();
	    
	},
	render: function() {
	    return (
	      <div className="comment">
	         {this.props.children}     
	      </div>
	    );
	}
});

ReactDOM.render(
	<CommentBox url={'http://localhost/pyrocms/products/comment/2'}/>,
		document.getElementById('comment')
);

