var Detail = React.createClass({
    componentDidMount: function() {
        this.loadDetailFromServer();  
        this.loadUserId(); 
        
    },
    
    loadcommentcount: function(){
        axios({
            url:this.props.url.ajaxcommentcount,  
            method:'post',
            data:{pro_id:this.props.product_id}
        })
        .then(function (response) {
            this.props.setCommentcount(response.data);
        }.bind(this))
        .catch(function (error) {
            console.log(error);
        }.bind(this),);
    },
    
    loadUserId:function(){
        axios({
            url:this.props.url.ajaxuserdata
        })
        .then(function (response) {
            this.props.setUserId(response.data);
            this.loadproductId();
        }.bind(this))
        .catch(function (error) {
            console.log(error);
            this.loadproductId();
        }.bind(this),);
        
    },
    loadproductId:function(){
        axios({
                url:this.props.url.ajaxproductid
            })
            .then(function (response) {
                this.props.setProduct_id(response.data);
                this.loadLikedata();
                this.loadCommentFromServer();
                this.loadcommentcount();
            }.bind(this))
            .catch(function (error) {
                console.log(error);
                this.loadLikedata();
            }.bind(this),);
    },
    loadLikedata:function(e){
        axios({
            url:this.props.url.ajaxlike,
            method:'post',
            data:{user_id:this.props.user_id,pro_id:this.props.product_id}
        })
        .then(function (response) {
            this.props.setLike(response.data);
            
        }.bind(this))
        .catch(function (error) {
            console.log(error);
        }.bind(this),);
        
   
    },
    loadDetailFromServer: function() {
            console.log(window.location.href);
            axios({
                url:this.props.url.ajaxdetail
            })
            .then(function (response) {
                this.props.setProduct(response.data);
                console.log(response.data);
            }.bind(this))
            .catch(function (error) {
                console.log(error);
                this.loadLikedata();
            }.bind(this),);
            
            
    },
    loadCommentFromServer: function(){
        document.getElementById("imgloadmorecomment").style.display = '';

        var pro_id = this.props.product_id;
        var limit = 3;
        var offset=0;

        axios({
            url: this.props.url.ajaxcomment, 
            method:'post',
            data: {pro_id:pro_id,limit:limit,offset:offset},
            
        })
        .then(function (response){
            this.props.setComments(response.data,offset,pro_id);
            document.getElementById("imgloadmorecomment").style.display = 'none';
            if(response.data.length>2){
                var loadmore = document.getElementById("loadmorecommentbutton");
                loadmore.style.display = '';
            } 
        }.bind(this))
        .catch(function (error){
            console.log(error);
            //document.getElementById("imgloadmorecomment"+this.props.id).style.display = 'none';
        }.bind(this),)
    },
    render: function(){
    return(

    <div className="Detail">
    <Detaillist/>

    </div>
            );
	}
});

var Detaillist = React.createClass({
   
    render:function(){
        var imgloadmorecomment = {display: "none"};
        var commentcount = this.props.commentcount;
        var style = {color: "grey",paddingLeft:5};
        return(
       <div className="row">
        {this.props.data.map((a)=>{
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
                                <StarRate/>
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
                            {this.props.like.map((b)=>{  return(
                            <LikeButton  pro_id={a.id} key='1' likecount={b.likecount} usercount={b.usercount} />
                                )
                            })} 
                                        <a name={a.id} 
                                        className="btn btn-default" 
                                        role="button"
                                        data-parent="#accordion" 
                                        data-toggle="collapse" 
                                        href={"#collapse"+a.id} 
                                        aria-expanded="true" 
                                        aria-controls={"collapse"+a.id}  
                                        >
                                        <span className="glyphicon glyphicon-comment"></span>
                                        { commentcount.map((b)=>{return  <span key="2" style={style}>{b.commentcount}</span>} )}                    
                                      </a>

                                        <a className="btn btn-danger" href="" role="button"><span className="glyphicon glyphicon-share-alt"></span></a>
                        </div>	
                        
                </div>
                <div className="col-xs-12 col-md-12 text-center" id="imgloadmorecomment" style={imgloadmorecomment}>
                            <img className="imgloadmore" src="addons/shared_addons/modules/products/img/ezgif2.gif" />
                        </div>
                <CommentBox id_product={a.id}/> 
                
                </div>
        )})}



        </div>	
       )
   } 
});
//var StarRating = require('react-star-rating');

var StarRate = React.createClass({

  render: function () { 

    return (
        <fieldset className="rating">
            <input type="radio" id="star5" name="rating" value="5" /><label className= "full" htmlFor="star5" title="Awesome - 5 stars"></label>
            <input type="radio" id="star4half" name="rating" value="4 and a half" /><label className="half" htmlFor="star4half" title="Pretty good - 4.5 stars"></label>
            <input type="radio" id="star4" name="rating" value="4" /><label className= "full" htmlFor="star4" title="Pretty good - 4 stars"></label>
            <input type="radio" id="star3half" name="rating" value="3 and a half" /><label className="half" htmlFor="star3half" title="Meh - 3.5 stars"></label>
            <input type="radio" id="star3" name="rating" value="3" /><label className= "full" htmlFor="star3" title="Meh - 3 stars"></label>
            <input type="radio" id="star2half" name="rating" value="2 and a half" /><label className="half" htmlFor="star2half" title="Kinda bad - 2.5 stars"></label>
            <input type="radio" id="star2" name="rating" value="2" /><label className= "full" htmlFor="star2" title="Kinda bad - 2 stars"></label>
            <input type="radio" id="star1half" name="rating" value="1 and a half" /><label className="half" htmlFor="star1half" title="Meh - 1.5 stars"></label>
            <input type="radio" id="star1" name="rating" value="1" /><label className= "full" htmlFor="star1" title="Sucks big time - 1 star"></label>
            <input type="radio" id="starhalf" name="rating" value="half" /><label className="half" htmlFor="starhalf" title="Sucks big time - 0.5 stars"></label>
        </fieldset>

    );

  }

});


var LikeButton = React.createClass({
    getInitialState: function(){
        return {
            usercount:parseInt(this.props.usercount),
            likecount:parseInt(this.props.likecount)
        }
    }, 
    Likeclick: function(){        
        if(this.state.usercount === 2){
           alert("You need to log in first");
           window.location.replace("/pyrocms/users/login");
        }
        if(this.state.usercount === 0){
            var usercount = this.state.usercount+1;
            var likecount = this.state.likecount+1;
            this.setState({usercount:usercount,likecount:likecount});
            this.handleLikeclickadd();
            return;
        }
        if(this.state.usercount === 1){
            var usercount = this.state.usercount-1;
            var likecount = this.state.likecount-1;
            this.setState({usercount:usercount,likecount:likecount});
            this.handleLikeclickremove();
            return;
        }
        
    },
    
    handleLikeclickadd:function(){
        console.log(this.props.pro_id);
        axios({
            url: this.props.url.ajaxlike, 
            method:'post',
            data: {addlike:'asd',pro_id:this.props.pro_id,user_id:this.props.user_id}
        })
        .then(function (response){ 
            
        }.bind(this))
        .catch(function (error){
            console.log(error);
        }.bind(this),)
    },
    handleLikeclickremove: function(){
        axios({
            url: this.props.url.ajaxlike, 
            method:'post',
            data: {removelike:'asd',pro_id:this.props.pro_id,user_id:this.props.user_id}
        })
        .then(function (response){ 

        }.bind(this))
        .catch(function (error){
            console.log(error);
        }.bind(this),)
    },
    
    render: function(){
        if(this.state.usercount === 0 || this.state.usercount === 2){
            var style = {color: "black",paddingRight:5};
        }
        if(this.state.usercount === 1){
            var style = {color: "red",paddingRight:5};
        }
        
        return(
            <a className="btn btn-primary" onClick={this.Likeclick}>
                <span id={"like"+this.props.pro_id} className="glyphicon glyphicon-heart-empty" style={style}></span>
                <span>{this.state.likecount}</span>
            </a>
        )
    }
});

var CommentBox = React.createClass({
    getInitialState: function(){
        return {
          pro_id: '0',com_id:'0', disabled: false,comment:''
        }
    },
    handleShowReply: function(e){console.log(e);
        document.getElementById("imgloadmoreReply"+e.target.name).style.display = '';
        var anchor = document.getElementById(e.target.id);
        anchor.style.display="none";
        var com_id = e.target.name;
        var pro_id = this.props.id_product;
        this.setState({ pro_id:pro_id,com_id:com_id, disabled: true});
        if(!com_id || !pro_id){
          return;
        }
        this.handleReply({pro_id:pro_id,com_id:com_id});
        this.setState({pro_id:'0',com_id:'0'});
        console.log(com_id);
    },
    
    handleReply: function(e){
        var com_id = e.com_id;
        var limit = 3;
        var offset=0;
        var pro_id = e.pro_id;
        axios({
            url: this.props.url.ajaxreply, 
            method:'post',
            data: {pro_id:pro_id,com_id:com_id,limit:limit,offset:offset},
           
        })
        .then(function (response){ 
            var a = this.props.reply;
            var b = a.concat(response.data);
            this.props.setReply(b,limit,offset,com_id);
            document.getElementById("imgloadmoreReply"+com_id).style.display = 'none';
            if(response.data.length>2){
            var loadmore = document.getElementById("reply"+com_id);
            loadmore.style.display = '';}
        }.bind(this))
        .catch(function (error){
            
            console.log(error);
            document.getElementById("imgloadmoreReply"+com_id).style.display = 'none';
        }.bind(this),)
    },
    
    handleLoadmorecomment:function(e){
     var pro_id = this.props.id_product;
     
     var obj = {
          "productid": this.props.comment.datacomment
        };
        
           function getCount(group) {
            var count = 0;
            for (var i = 0; i < obj.productid.length; i++) {
                if (obj.productid[i].product_id_c === group) {
                    count++;
                }
            }
            return count;
        }
        var x = getCount(pro_id);
        console.log(getCount(pro_id));
        var offset = x;
    axios({
        url: this.props.url.ajaxcomment, 
        method:'post',
        data: {limit:3,pro_id:pro_id,offset:offset},
        
    })
    .then(function (response){
        var a = response.data;
        var b = a.concat(this.props.comment.datacomment);
        console.log(b);
        this.props.setComments(b,offset,pro_id=this.props.comment.pro_id);
        if(a.length<3){
            var loadmore = document.getElementById("loadmorecommentbutton");
                loadmore.style.display = 'none';
        }
    }.bind(this))
    .catch(function (error){
        console.log(error);
            if (error.response.status=404) {
                var loadmore = document.getElementById("loadmorecommentbutton");
                loadmore.style.display = 'none';
            }
    }.bind(this),) 
    },
    
    render: function(){ 
        var anchor = {display: "none"};
        var imgloadmoreReply = {display: "none"};
        var style = {padding:19}
        return(
           <div className="commentbox" >
            <a id="loadmorecommentbutton" onClick={this.handleLoadmorecomment} style={anchor}> Load older comment...</a>  
            {this.props.data.map((a)=>{  return(
                <div className="well col-xs-12" key={a.id} style={style}>
                <a>
                    <img className="comment-avatar" src="addons/shared_addons/modules/products/img/avartar.jpg" />
                </a>   
                <div className="asdfghjkl col-xs-3">MinhNguyen:</div>
                    
                <div className="col-xs-9">
                    {a.comments}
                    <div className="">
                    <a
                    id={a.id}
                    name ={a.id}
                    role="button" 
                    data-parent="#accordion" 
                    data-toggle="collapse" 
                    href={"#collapseone"+a.id}
                    aria-expanded="false" 
                    aria-controls={"collapseone"+a.id} 
                    onClick={this.handleShowReply}
                    >reply </a>
                    <span className="commentTime">{
                    Date.timeBetween(new Date(parseInt(a.created)), new Date())
                    }</span>
                </div>
                </div>
                
                
               
                <div className="col-xs-12">
                        <div className="col-xs-12 col-md-12 text-center" id={"imgloadmoreReply"+a.id} style={imgloadmoreReply}>
                            <img className="imgloadmore" src="addons/shared_addons/modules/products/img/ezgif.gif" />
                        </div>
                    <ReplyBox id_product={this.props.id_product} comment_id = {a.id}/>  
                    
                </div>
                </div>)
            })} 
            
             <CommentForm id_product={this.props.id_product}/>  

          </div>       
        )
    }
});
var ReplyBox = React.createClass({
    handleLoadmorereply:function(e){
     var pro_id = this.props.id_product;
     var com_id = this.props.comment_id;
     var obj = {
          "commentid": this.props.reply
        };
           function getCount(group) {
            var count = 0;
            for (var i = 0; i < obj.commentid.length; i++) {
                if (obj.commentid[i].reply_id === group) {
                    count++;
                }
            }
            return count;
        }
    var x = getCount(com_id);
    console.log(getCount(com_id));
    var offset = x;
    var limit = 3;
    axios({
       url: this.props.url.ajaxreply, 
        method:'post',
        data: {limit:limit,pro_id:pro_id,offset:offset,com_id:com_id},
        
    })
    .then(function (response){
        var a = response.data;
        var b = a.concat(this.props.reply);
        this.props.setReply(b,limit,offset,com_id);
        //var x = Object.keys(this.props.comment.datacomment.product_id_c==="1").length;
        console.log(a);
    }.bind(this))
    .catch(function (error){
        console.log(error);
            if (error.response.status=404) {
                var loadmore = document.getElementById("reply"+this.props.comment_id);
                loadmore.style.display = 'none';
                console.log(this.props.comment_id);
            }
    }.bind(this),) 
    },
    render: function(){
        var anchorstyle = {display: "none"}; 
        return(
            <div className="commentbox collapse" id={"collapseone"+this.props.comment_id}>
               <a id={"reply"+this.props.comment_id} onClick={this.handleLoadmorereply} style={anchorstyle}> Load older reply...</a> 
               {this.props.reply.map((a)=>{ if(this.props.comment_id == a.reply_id){ return(
                <div className="well reply col-xs-12" key={a.id}>
                    <a>
                        <img className="comment-avatar" src="addons/shared_addons/modules/products/img/avartar.jpg" />
                    </a>
                    <div className="asdfghjkl">MinhNguyen:</div>
                        <div className="">
                        {a.comments}
                        </div>
                        
                        <div className="commentTimeReply">{
                        Date.timeBetween(new Date(parseInt(a.created)), new Date())
                        }</div>
                </div>
                )}
                  })}
                <ReplyForm id_product={this.props.id_product} comment_id = {this.props.comment_id}/>

            </div>
      );
      
    }
});
var ReplyForm = React.createClass({
    getInitialState: function(){
      return {
        comment: '',pro_id:'',com_id:''
      }
    },
    
    handleTextChange: function(e){
      this.setState({comment: e.target.value});
    },
    
    handleSubmitReply: function(e){
        e.preventDefault();
        if(this.props.user_id===''){
            alert("You need to log in first");
            window.location.replace("/pyrocms/users/login");
        }
        else{
            var comment = this.state.comment.trim();
            if(!comment){
              return;
            }
            this.onhandleSubmitReply({comment:comment,pro_id:this.props.id_product,com_id:this.props.comment_id});

            this.setState({comment:'',pro_id:'',com_id:''});
        }
    },
    
    onhandleSubmitReply:function(e){
        var comment = e.comment;
        var pro_id = e.pro_id;
        var limit = 1;
        var com_id = e.com_id;
        axios({
        url: this.props.url.ajaxreply, 
        method:'post',
        data: {limit:limit,comment:comment,asd:1, pro_id:pro_id,offset:0,com_id:com_id},
        
        })
        .then(function (response){
            var a = this.props.reply;
            var b = a.concat(response.data);
            this.props.addReply(b);
            console.log(response.data);
        }.bind(this))
        .catch(function (error){
            this.props.addReply(comment);
            console.log(error);
        }.bind(this),)
    },
    

    render: function(){
      return(
       <form className="commentForm" onSubmit={this.handleSubmitReply}>
            <div className="commentFormReply input-group col-xs-12">
                <input 
                type="text" className="form-control" 
                placeholder="Write reply ....." 
                value={this.state.comment}
                onChange={this.handleTextChange}
                required
                />

            </div>
        </form>
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
      this.setState({comment: e.target.value});
    },

    handleSubmitComment: function(e){
        e.preventDefault();
        if(this.props.user_id===''){
            alert("You need to log in first");
            window.location.replace("/pyrocms/users/login");
        }
        else{
            console.log('432432');
            var comment = this.state.comment.trim();
            if(!comment){
              return;
            }
            this.onhandleSubmitComment({comment:comment,pro_id:this.props.id_product});
            this.setState({comment:'',pro_id:''});
            console.log(this.state);
        }
    },
    
    onhandleSubmitComment:function(e){
        var comment = e.comment;
        var pro_id = e.pro_id;
        var limit = 1;

        axios({
        url: this.props.url.ajaxcomment, 
        method:'post',
        data: {limit:limit,comment:comment,asd:1, pro_id:pro_id,offset:0},
        
        })
        .then(function (response){
            var a = this.props.comment.datacomment;
            var b = a.concat(response.data);
            this.props.addComment(b);
            console.log(response.data);
        }.bind(this))
        .catch(function (error){
            this.props.addComment(comment);
            console.log(error);
        }.bind(this),)
    },

    render: function(){
      var style ={    
          paddingLeft: 15,
          paddingRight:15
        };
        return(
       <form className="commentForm" onSubmit={this.handleSubmitComment}>
        <div className="commentForm input-group col-xs-12" style={style}>
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


var createStore = Redux.createStore;
var Provider = ReactRedux.Provider;
var connect = ReactRedux.connect;
var applyMiddleware = Redux.applyMiddleware;
var base_url = window.location.href;
var url = base_url.split("/").splice(0, 5).join("/");

var initialState = {
    url:{
        ajaxdetail: url+"/ajaxdetail",
        ajaxuserdata: url+"/apis/ajaxuserdata",
        ajaxlike: url+"/apis/ajaxlikedetail",
        ajaxproductid: url+"/apis/ajaxproductid",
        ajaxcomment: url+"/apis/ajaxcomment",
        ajaxreply: url+'/apis/ajaxreply',
        ajaxcommentcount: url+"/apis/ajaxcommentcount"
     },
    producta: [],
    query:{
        limit:3,
        offset:0,
        cat_id:'',
        f_id:'1'
    },
    product_id: '',
    comment:{
        datacomment:[],
        C_limit:3,
        C_offset:0,
        pro_id:''
    },
    reply:{
        datareply:[],
        re_limit:3,
        re_offset:0,
        com_id:''
    },
    user_id:'',
    like:[],
    commentcount:[]
};

var reducer = function(state,action){
    if(state === undefined) {
        return initialState;
    }
    var newState = state;
        switch(action.type){
            case 'set_UserId':
            newState = Object.assign({},state,{
                user_id: action.data
            });
            break;
            case 'set_Product_id':
                newState = Object.assign({},state,{
                    product_id:action.data
                });
            break;
            case 'set_Like':
            newState = Object.assign({},state,{
                like: action.data
            });
            break;
            
            case 'set_Product':
                newState = Object.assign({}, state,{producta: action.data});
            break; 
            case 'set_Comments':
            newState = Object.assign({},state,{
                comment:{
                    datacomment: action.data,
                    C_limit: state.comment.C_limit,
                    C_offset: action.offset,
                    pro_id: action.pro_id
                }
            });
            break;
            case 'set_Reply':
            newState = Object.assign({},state,{
                reply:{
                    datareply: action.data,
                    re_limit: action.limit,
                    re_offset: action.offset,
                    com_id:action.com_id
                }
            });break;
            case 'add_Reply':
                newState = Object.assign({},state,{
                    reply:{
                        datareply: action.data
                    }
            }); break;
            case 'add_Comment':
            newState = Object.assign({},state,{
            comment:{
                datacomment: action.data
            }
            });break;
            case 'set_Commentcount' :
                newState = Object.assign({},state,{
                    commentcount:action.data
            });break;
    }
  
    return newState;
};

var store = createStore(reducer, initialState);

var DetailState = function(state){
    return{
        url: state.url,
        product_id: state.product_id,
        user_id: state.user_id
    }
};
var DetailDispatch = function(dispatch){
    return{
        setProduct: function(data){
            dispatch({
                type: "set_Product",
                data:data
            })
        },
        setProduct_id:function(data){
            dispatch({
               type: "set_Product_id",
               data:data
               
            })
        },
        setUserId: function(user_id){
            dispatch({
                type: 'set_UserId',
                data: user_id   
            })
            
        },
        setLike: function(data){
            dispatch({
                type:'set_Like',
                data: data
            })
        },
        setComments: function(data,offset,pro_id){
            dispatch({
                type: "set_Comments",
                data: data,
                offset:offset,
                pro_id:pro_id
            })
            
        },
        setReply: function(data,limit,offset,com_id){
            dispatch({
                type: 'set_Reply',
                data:data,
                limit:limit,
                offset:offset,
                com_id:com_id
            })
            console.log(store.getState());
        },
        setCommentcount: function(data){
            dispatch({
                type:'set_Commentcount',
                data: data
            })
        }
    }
};
Detail = connect(DetailState,DetailDispatch)(Detail);


var DetaillistState = function(state){
    return{
        data:state.producta,
        like:state.like,
        commentcount: state.commentcount
    }
};

Detaillist = connect(DetaillistState)(Detaillist);


var LikeButtonState = function(state){
    return{
        data: state.like, 
        user_id: state.user_id,
        url: state.url
    }  
};
LikeButton = connect(LikeButtonState)(LikeButton)

var CommentBoxState = function(state){
    return{
        data: state.comment.datacomment,
        comment: state.comment,
        url: state.url,
        reply: state.reply.datareply,
       
    }
}
CommentBox = connect( CommentBoxState, DetailDispatch)(CommentBox)
var CommentFormState = function(state){
    return{
        comment:state.comment,
        url:state.url ,  
        user_id: state.user_id
    }
};

var CommentFormDispatch = function(dispatch){
    return{
        addComment: function(data){
            dispatch({
                type: 'add_Comment',
                data:data
            })
        },
        
    }
};
CommentForm=connect(CommentFormState,CommentFormDispatch)(CommentForm)

var ReplyBoxState = function(state){
    return{
        reply: state.reply.datareply,
        url: state.url
    }
}


ReplyBox = connect(ReplyBoxState)(ReplyBox)

var ReplyFormState = function(state){
    return{
        url: state.url,
        reply:state.reply.datareply,
        user_id:state.user_id
    }
}

var ReplyFormDispatch = function(dispatch){
    return{
        addReply: function(data){
            dispatch({
                type:'add_Reply',
                data:data
            })
        }
    }
}

ReplyForm = connect(ReplyFormState,ReplyFormDispatch)(ReplyForm)

ReactDOM.render(
	<Provider store={store}>
            <Detail />
        </Provider>,
	document.getElementById('detail')
);