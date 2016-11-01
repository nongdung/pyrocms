var Detail = React.createClass({
	getInitialState: function() {
		return {data: [],query:{limit:3,offset:0},comment:[]};
	},
	loadDetailFromServer: function() {
		console.log(window.location);
		$.ajax({
		url: this.props.url ,
		dataType: 'json',
		cache: false,
		success: function(data) {
			this.setState({data: data});
			console.log('loadDetailFromServer');
			console.log(data);
		}.bind(this),
		error: function(xhr, status, err) {
			console.error(this.props.url, status, err.toString());
		}.bind(this)
		});
	},
	loadCommentFromServer: function(){
		$.ajax({
			url: 'http://localhost/pyrocms/products/comment',
			dataType: 'json',
			cache: false,
			type: 'POST',
			data: this.state.query,
			success: function(data) {
				this.setState({data: this.state.data, query: this.state.query,comment:data});
				console.log('loadCommentsFromServer');
				console.log(this.state);
			}.bind(this),
			error: function(xhr, status, err) {
				console.error('http://localhost/pyrocms/products/comment', status, err.toString());
			}.bind(this)
		});
	},
	
	componentDidMount: function() {
		this.loadDetailFromServer();  
		this.loadCommentFromServer();
	},
	handleSubmitComment:function(e){
		var comment = e.comment;
		var pro_id = e.pro_id;
		var limit = 1;
		console.log(e);
		$.ajax({
			url:'http://localhost/pyrocms/products/comment',
			dataType:'json',
			type: 'POST',
			data: {limit:limit,comment:comment,asd:1, pro_id:pro_id},
			success: function(newdata){
				var a = newdata;
				var b = a.concat(this.state.comment);
				this.setState({data: this.state.data,query: this.state.query,comment:b});
				console.log(this.state);
			}.bind(this),
			error: function(xhr, status, err){
				this.setState({comment:comment});
				console.error(window.location+'/ajaxcomment', status, err.toString());
			}.bind(this)
		});
	},
	handleLoadmorecomment:function(e){
		console.log('your loadmore is working fine');
		var pro_id = e.pro_id;
		var limit = this.state.query.limit;
		console.log(limit);
		$.ajax({
			url:'http://localhost/pyrocms/products/comment',
			dataType:'json',
			type: 'POST',
			data: {limit:3,offset:this.state.query.offset+limit},
			success: function(newdata){
				var a = this.state.comment;
				var b = a.concat(newdata);
				this.setState({data:this.state.data,query: this.state.query,comment:b});
				console.log(this.state);
			}.bind(this),
			error: function(xhr, status, err){
				console.error(this.props.url, status, err.toString());
			}.bind(this)
		});
		console.log(e);
	},

	render: function(){
		return(
			
			<div className="Detail">
			
				<div className="row">
				{this.state.data.map((a)=>{
				return(
					<div className="main" key={a.id}>
					<div className="col-xs-12">
						<div className="item">
								<img src={a.path} alt="Chania"/>
						</div>
					</div>
					<div className="col-xs-12">
						<p className="properties-label"> Product Name :</p>
						<span className="properties-content"> {a.p_name}</span>	
					</div>
					<div className="col-xs-12">
						<div className="col-xs-6 col-md-6">
							<p className="properties-label"> Code :</p>
							<span className="properties-content"> {a.p_id} </span>	
						</div>
						<div className="col-xs-6 col-md-6">
							<p className="properties-label"> Price :</p>
							<span className="properties-content"> {a.p_price} </span>	
						</div>

						<div className="col-xs-6 col-md-6">
							<p className="properties-label"> Discount :</p>
							<span className="properties-content"> {a.p_discount} </span>
						</div>
						<div className="col-xs-6 col-md-6">
							<p className="properties-label"> Rate :</p>
							<span className="properties-content">
								<i className="fa fa-star" aria-hidden="true"></i>
								<i className="fa fa-star" aria-hidden="true"></i>
								<i className="fa fa-star" aria-hidden="true"></i>
								<i className="fa fa-star" aria-hidden="true"></i>
								<i className="fa fa-star" aria-hidden="true"></i>
							</span>	
						</div>
					</div>

					<div className="col-xs-12 col-md-12">
						<p className="properties-label"> Serving hour :</p>
						<span className="properties-content"> 7:00 AM - 7:00 PM </span>
					</div>

					<div className="col-xs-12 col-md-12"> 
						<h2>Long description:</h2>
						<span>{a.p_long_description}</span>
					</div>	
				
					<div className="col-xs-12 col-md-12">
				
						<div className="connect  btn-group  btn-group-justified">							
								<a className="btn btn-primary" href="#" role="button"><i className="fa fa-heart-o" aria-hidden="true"> Like </i></a>
						
								<a name={a.id} 
								className="btn btn-default" 
								role="button"
								data-parent="#accordion" 
								data-toggle="collapse" 
								href={"#collapse"+a.id} 
								aria-expanded="false" 
								aria-controls={"collapse"+a.id}  
								>
									<span className="glyphicon glyphicon-comment"></span></a>

								<a className="btn btn-danger" href="#" role="button"><i className="fa fa-share-alt" aria-hidden="true"> Share </i></a>
						</div>			 
					</div>

					
					<CommentBox comment={this.state.comment} 
					id_product={a.id} 
					handleSubmitComment={this.handleSubmitComment}
					handleLoadmorecomment={this.handleLoadmorecomment}
					/>
					</div>
				)})}
					
					
					
				</div>	
	</div>
		);
	}
});

var CommentBox = React.createClass({
	getInitialState: function(){
		return {
		comment: '',pro_id: ''
		}
  	},
	onhandleSubmitComment:function(e){
		
		this.setState({comment:e.comment,pro_id:this.props.id_product});
		var comment = e.comment;
		var pro_id = e.pro_id;
		this.props.handleSubmitComment({comment:comment,pro_id:pro_id});
	
	},

	handleLoadmorecomment:function(){
		this.props.handleLoadmorecomment({pro_id:this.props.id_product});
	},
	render: function(){
		return(
        
         <div className="commentbox collapse" id={"collapse"+this.props.id_product}>
            <CommentForm onhandleSubmitComment={this.onhandleSubmitComment} id_product={this.props.id_product}/>
            {this.props.comment.map((a)=> {return(
                <div className="well" key={a.com_id}>
                  <div>
                  {a.comments}
                  </div>
                  <a
                  role="button" 
                  data-parent="#accordion" 
                  data-toggle="collapse" 
                  href={"#collapseone"+a.id}
                  aria-expanded="false" 
                  aria-controls={"collapseone"+a.id} 
                    >reply</a>
                  <ReplyBox comment_id = {a.id}/>  
                </div>)
            })} 
            
            <button className="loadmore btn btn-default" onClick={this.handleLoadmorecomment}> Load more comment...</button>    
          </div>  
    );
	}
});

var CommentForm = React.createClass({
  getInitialState: function(){
    return {
      comment: '',pro_id:''
    }
  },

  handleTextChange: function(e){
    this.setState({comment: e.target.value})
  },

  handleSubmitComment: function(e){
    e.preventDefault();
    var comment = this.state.comment.trim();
    if(!comment){
      return;
    }
    this.props.onhandleSubmitComment({comment:comment,pro_id:this.props.id_product});
    this.setState({comment:'',pro_id:''});
    
  },
  
  render: function(){
	const divstyle={ 
		padding:15
	};
    return(
     <form className="commentForm" onSubmit={this.handleSubmitComment}>
      <div className="commentForm input-group col-xs-12" style={divstyle}>
            <input 
            type="text" className="form-control" 
            placeholder="Say something in your mind ....." 
            value={this.state.comment}
            onChange={this.handleTextChange}
            required
            />
            <span className="input-group-btn">
                <button className="btn btn-danger" type="submit" value="Comment">
                    <span className="glyphicon glyphicon-hand-up"></span>
                </button>
            </span>
        </div>
        </form>
    );
  }
});
var ReplyBox = React.createClass({
  render: function(){
    return(
      <div className="commentbox collapse" id={"collapseone"+this.props.comment_id}>
          <div className="well">
          asdfasdfasdfasdf
          </div>
      </div>
    );
  }
});
ReactDOM.render(
	<Detail url={'http://localhost/pyrocms/products/ajaxdetail'}/>,
	document.getElementById('detail')
);