var ProductList = React.createClass({
    componentDidMount: function() {
        this.loadProductFromServer();
        this.loadCategoryFromServer();
        this.loadUserId();  
    },
    
    loadUserId:function(){
        
        axios({
            url:this.props.url.ajaxuserdata
        })
        .then(function (response) {
            this.props.setUserId(response.data);
            this.loadLikedata();
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
            data:{user_id:this.props.user_id}
        })
        .then(function (response) {
            this.props.setLike(response.data);
            
        }.bind(this))
        .catch(function (error) {
            console.log(error);
        }.bind(this),);
        
   
    },
    
    loadProductFromServer: function() {    
        axios({
            url:this.props.url.ajaxlist,
            //url:"http://localhost/pyrocms-pyrocms/products/apis/ajaxlist",
            method:'post',
            data: this.props.query,  
        })
        .then(function (response) {
            //console.log(response);
            this.props.setProducts(response.data);
        }.bind(this))
        .catch(function (error) {
            console.log(error);
        }.bind(this),);
        
    },

    loadCategoryFromServer: function(){
        axios({
            url:this.props.url.ajaxcategories,
            method:'post',
            data:{}
        })
        .then(function (response){
            this.props.setCategories(response.data);
            
        }.bind(this))
        .catch(function (error){
            console.log(error);
           
        }.bind(this),)
       
    },
    
    handleProductloadmore: function(e) {
        e.preventDefault();
        var limit = 3;
        var offset = this.props.query.offset+limit;
        axios({
            url: this.props.url.ajaxlist,
            method:'post',
            data: {limit:limit, offset: offset,cat_id:this.props.query.cat_id,f_id:this.props.query.f_id},
            
        })
        .then(function (response){
            var a = this.props.data;
            var b = a.concat(response.data);
            this.props.loadmoreProducts(b,offset);
        }.bind(this))
        .catch(function (error){
            console.log(error);
            if (error.response.status=404) {
                alert( "This is all Products for this Category. Choose your favorite and share with your friends about us." );
                document.getElementById('loadmorepro').style.visibility = 'hidden';
                

            } 
        }.bind(this),)
        
    },

    render: function(){
    return(
        <div className="main">
            <div className="row">
                <div className="filter col-xs-12">
                    <Categories />
                    <Filters />
                </div>
            </div>
            
            {this.props.data.map((a)=>{
            return <Products  
             p_name={a.p_name} id={a.id} key={a.id} p_price={a.p_price} p_short_description={a.p_short_description} p_image={a.path}/>
            })}
            
            <div className="row text-center">
                <button id="loadmorepro" className="loadmore btn btn-default" onClick={this.handleProductloadmore}> Load more...</button>
            </div>
        </div>
      );
    }
});

var Products = React.createClass({
    getInitialState: function(){
        return {
          pro_id: '0', disabled: false,comment:''
        }
    },
    handleShowComment: function(e){
        this.setState({ pro_id:e.target.name, disabled: true});
        var pro_id = e.target.name;
        if(!pro_id){
          var pro_id = this.props.id;
        }
        this.handleComment({pro_id:pro_id});
        this.setState({pro_id:'0'});
        console.log(pro_id);
    },
    handleComment:function(e){
    
    var pro_id = e.pro_id;
    var limit = 3;
    var offset=0;

    axios({
        url: this.props.url.ajaxcomment, 
        method:'post',
        data: {pro_id:pro_id,limit:limit,offset:offset},
        transformRequest: [function (data) {
        var obj = jQuery.param(data);
        return obj;
      }],
    })
    .then(function (response){
        var a = this.props.comment.datacomment;
        var b = a.concat(response.data);
        this.props.setComments(b,offset,pro_id);
        if(response.data.length>2){
            var loadmore = document.getElementById(this.props.id);
            loadmore.style.display = '';}
    }.bind(this))
    .catch(function (error){
        console.log(error);
    }.bind(this),)

    },
    render: function(){
        return(
            <div className="product">
            
                <div className="row">
                    <div className="ls col-xs-12" >

                        <div className="image col-xs-12">
                            <a href={window.location+'/detail/'+ this.props.id}>
                               <img src={this.props.p_image} />
                            </a>
                        </div>

                        <div className="detail col-xs-6 col-md-6 ">
                            <p className="properties-label"> <a href={window.location+'/detail/'+ this.props.id}> {this.props.p_name} </a> </p>   
                        </div>
                        <div className="detail col-xs-6 col-md-6">
                            <div className="pull-right">
                                <p className="properties-label col-xs-6"> Price :</p>
                                <span className="price properties-content col-xs-6"> {this.props.p_price} </span>   
                            </div>
                        </div>
                        <div className="detail col-xs-12 col-md-12"> 
                            <span className="properties-label-des"> Short description:</span>
                            <p>{this.props.p_short_description}</p>
                            <a href="{window.location+'/detail/'+ this.props.id}"> Read more </a>
                        </div>

                        <div className="btn-group btn-group-justified ">
                        {this.props.like.map((a)=>{ if(this.props.id === a.pro_id){ return(
                            <LikeButton  pro_id={a.pro_id} key={a.pro_id} likecount={a.likecount} usercount={a.usercount} />
                            )}
                        })}  
                            <a 
                            name={this.props.id} 
                            className="btn btn-default" 
                            role="button"
                            data-parent="#accordion" 
                            data-toggle="collapse" 
                            href={"#collapse"+this.props.id} 
                            aria-expanded="false" 
                            aria-controls={"collapse"+this.props.id} 
                            onClick={this.handleShowComment} 
                            disabled={this.state.disabled}
                            >
                              <span className="glyphicon glyphicon-comment"></span></a>
                            <a href="#" className="btn btn-default"><span className="glyphicon glyphicon-share-alt"></span></a>
                        </div>        
                        <CommentBox id_product={this.props.id}/> 
 
                    </div>
                </div>
             
            </div>
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
           window.location = "http://localhost/pyrocms/users/login";
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
            var style = {color: "black"};
        }
        if(this.state.usercount === 1){
            var style = {color: "red"};
        }
        
        return(
            <a className="btn btn-default" onClick={this.Likeclick}>
                <span id={this.props.pro_id} className="glyphicon glyphicon-heart" style={style}></span>
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
            if(response.data.length>2){
            var loadmore = document.getElementById("reply"+com_id);
            loadmore.style.display = '';}
        }.bind(this))
        .catch(function (error){
            
            console.log(error);
            
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
        this.props.setComments(b,offset,pro_id=this.props.comment.pro_id);
        
    }.bind(this))
    .catch(function (error){
        console.log(error);
            if (error.response.status=404) {
                var loadmore = document.getElementById(this.props.id_product);
                loadmore.style.display = 'none';
            }
    }.bind(this),) 
    },
    
    render: function(){ 
        var anchor = {display: "none"};
        return(
           <div className="commentbox collapse" id={"collapse"+this.props.id_product}>
            <a id={this.props.id_product} onClick={this.handleLoadmorecomment} style={anchor}> Load older comment...</a>  
            {this.props.data.map((a)=>{ if(this.props.id_product == a.product_id_c){ return(
                <div className="well col-xs-12" key={a.id}>
                    <div className="asdfghjkl">MinhNguyen:</div>
                    <div className="col-xs-12">

                    {a.comments}
                    </div>
                    <div className="col-xs-6">
                     
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
                          
                          >reply</a>
                      
                    </div>
                    <div className="col-xs-12">
                        <ReplyBox id_product={this.props.id_product} comment_id = {a.id}/>  
                    </div>
                </div>)}
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
                <div className="well col-xs-12" key={a.id}>
                    <div className="asdfghjkl">MinhNguyen:</div>
                        <div className="col-xs-6">
                        {a.comments}
                        </div>
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
      var comment = this.state.comment.trim();
      if(!comment){
        return;
      }
      this.onhandleSubmitReply({comment:comment,pro_id:this.props.id_product,com_id:this.props.comment_id});
      
      this.setState({comment:'',pro_id:'',com_id:''});
      
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
            <div className="commentForm input-group col-xs-12">
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
      var comment = this.state.comment.trim();
      if(!comment){
        return;
      }
      this.onhandleSubmitComment({comment:comment,pro_id:this.props.id_product});
      this.setState({comment:'',pro_id:''});
      console.log(this.state);
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
      return(
       <form className="commentForm" onSubmit={this.handleSubmitComment}>
        <div className="commentForm input-group col-xs-12">
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


var Categories = React.createClass({
    getInitialState: function() {
         return {
             cat_id: ''
         }
     },
  
    handleSubmit:function(e){
        this.setState({cat_id: e.target.value}); 
        e.preventDefault();
        var cat_id = e.target.value;
        this.handleCategoryChange({cat_id: cat_id});
        this.setState({cat_id: e.target.value});
    },

    handleCategoryChange: function(e){
        var cat_id = e.cat_id;
        var offset = 0;
        var f_id = this.props.query.f_id;
        axios({
            url: this.props.url.ajaxlist,
            method:'post',
            data: {limit:this.props.query.limit, offset: offset,cat_id:cat_id,f_id:f_id},
           
        })
        .then(function (response){
            this.props.changeCategories(response.data,cat_id,offset);
            //console.log(response.data);
        }.bind(this))
        .catch(function (error){
            console.log(error);
            if (error.response.status=404) {
              alert( "This Category will soon be available. Thanks for coming to our restaurant" );
              window.location= window.location;
            } 
        }.bind(this),)

    },

    render: function(){
        var Cat = this.props.data.map(function(c){
            return(
            <option key={c.id_c} value={c.id_c}>{c.c_name}</option>);
        })
        return(
          <div className="filter-category col-xs-6" >
              <select className="form-control" onChange={this.handleSubmit} value={this.state.value} >
                  <option value="">All</option>
                  {Cat}
             </select>


         </div>
        )
    }
});

var Filters = React.createClass({
    getInitialState: function(){
        return {
            f_id: '1'
        }
    },
    handleFilter: function(e){
        this.setState({f_id: e.target.value});
        e.preventDefault();
        var f_id=e.target.value;

        this.handleFilterChange({f_id: f_id});
        this.setState({f_id: e.target.value});
    },
    handleFilterChange: function(e){
        var f_id = e.f_id;
        var limit = 3;
        var offset=0;
        axios({
            url: this.props.url.ajaxlist,
            method:'post',
            data: {limit:limit, offset: offset,cat_id:this.props.query.cat_id,f_id:f_id},
            
        })
        .then(function (response){
            this.props.changeFilter(response.data,f_id,offset);
            //console.log(response.data);
        }.bind(this))
        .catch(function (error){
            console.log(error);
        }.bind(this),)       
    },

    render: function(){
        return(
            <div className="filter-category col-xs-6">
                <select className="form-control" onChange={this.handleFilter} value={this.state.f_id}>
                    <option value="1">Price high to low</option>
                    <option value="2">Price low to high</option>
                    <option value="3">Most Comment</option>
                    <option value="4">Most Like</option>
                </select>
            </div>                
        );
    } 
});

var createStore = Redux.createStore;
var Provider = ReactRedux.Provider;
var connect = ReactRedux.connect;
var applyMiddleware = Redux.applyMiddleware;


var initialState = {
    url:{
        ajaxlist: window.location+"/apis/ajaxlist",
        ajaxcategories: window.location+"/apis/ajaxcategories",
        ajaxcomment: window.location+'/apis/ajaxcomment',
        ajaxreply: window.location+'/apis/ajaxreply',
        ajaxuserdata: window.location+'/apis/ajaxuserdata',
        ajaxlike: window.location+'/apis/ajaxlike'
     },
    products: [],
    query:{
        limit:3,
        offset:0,
        cat_id:'',
        f_id:'1'
    },
    categories: [],
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
    like:[]
    
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
            
            case 'set_Like':
            newState = Object.assign({},state,{
                like: action.data
            });
            break;
            
            case 'set_Products':
                newState = Object.assign({}, state,{products: action.data});
            break;

            case 'set_Categories':
                newState = Object.assign({}, state,{categories: action.data});
            break;

            case 'loadmore_Products':
                newState = Object.assign({}, state,{
                    products: action.data,
                    query:{
                        limit:state.query.limit,
                        offset:action.offset,
                        cat_id:state.query.cat_id,
                        f_id:state.query.f_id
                    }
                });
            break;

            case 'change_Categories':
                newState = Object.assign({},state,  {
                    products: action.data,
                    query:{
                        limit:state.query.limit,
                        offset:action.offset,
                        cat_id:action.cat_id,
                        f_id: state.query.f_id
                    }
                });
            break;

            case 'change_Filter':
                newState = Object.assign({},state,{
                    products: action.data,
                    query:{
                        limit:state.query.limit,
                        offset:action.offset,
                        cat_id:state.query.cat_id,
                        f_id: action.f_id
                    }
                });
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
            case 'add_Comment':
                newState = Object.assign({},state,{
                comment:{
                    datacomment: action.data
                }
            });break;

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
    }
  
    return newState;
};

var store = createStore(reducer, initialState);
console.log(store.getState());


var ProductListDispatch = function(dispatch){
    return{
        setProducts: function(products){
            dispatch({
              type: 'set_Products',
              data: products
            });
        },
        setCategories: function(categories){
            dispatch({
              type: 'set_Categories',
              data: categories
            });
        },
        loadmoreProducts: function(products,offset){
            dispatch({
                type:'loadmore_Products',
                data: products,
                offset: offset
            })
        },
        setUserId: function(user_id){
            dispatch({
                type: 'set_UserId',
                data: user_id   
            })
            console.log(store.getState());
        },
        setLike: function(data){
            dispatch({
                type:'set_Like',
                data: data
            })
        }
    }
};


var ProductListState = function(state){
    return {
        url: state.url,
        query: state.query,
        data: state.products,
        user_id: state.user_id,
        
    };
};


ProductList = connect(
    ProductListState,
    ProductListDispatch
)(ProductList)

var LikeButtonState = function(state){
    return{
        data: state.like, 
        user_id: state.user_id,
        url: state.url
    }  
};
LikeButton = connect(LikeButtonState)(LikeButton)
//send data to Product component
var ProductsState = function(state){
    return {
        url: state.url,
        comment: state.comment,
        like: state.like
    }
};
var CommentDispatch = function(dispatch){
    return{
        setComments: function(data,offset,pro_id){
            dispatch({
                type: "set_Comments",
                data: data,
                offset:offset,
                pro_id:pro_id
            })
            console.log(store.getState());
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
        }
    }
};

Products = connect(ProductsState,CommentDispatch)(Products)

var CommentBoxState = function(state){
    return{
        data: state.comment.datacomment,
        comment: state.comment,
        url: state.url,
        reply: state.reply.datareply,

    }
}
CommentBox = connect(
        CommentBoxState,CommentDispatch
        )(CommentBox)


var CommentFormState = function(state){
    return{
        comment:state.comment,
        url:state.url   
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


ReplyBox = connect(ReplyBoxState,CommentDispatch)(ReplyBox)

var ReplyFormState = function(state){
    return{
        url: state.url,
        reply:state.reply.datareply
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
//send data to categories component
var CategoriesState = function(state){
    return {
        query: state.query,
        data: state.categories,
        url: state.url
    }
};

var CategoriesDispatch = function(dispatch){
    return{
        changeCategories: function(data,cat_id,offset){
            dispatch({
                type: 'change_Categories',
                data: data,
                cat_id: cat_id,
                offset: offset
            })
            console.log('change_Categories');
            console.log(store.getState());
        }
    }
};

Categories = connect(
    CategoriesState,
    CategoriesDispatch
)(Categories)

var FilterState = function(state){
    return{
        url: state.url,
        query: state.query
    }
};
var FilterDispatch = function(dispatch){
    return{
        changeFilter: function(data,f_id,offset){
            dispatch({
                type: 'change_Filter',
                data: data,
                f_id: f_id,
                offset: offset
            })
            console.log('change_Filter');
            console.log(store.getState());
        }
    }
};

Filters = connect(
    FilterState,
    FilterDispatch
)(Filters)



ReactDOM.render(
    <Provider store={store}>
        <ProductList />
    </Provider>,
    document.getElementById('product')
);