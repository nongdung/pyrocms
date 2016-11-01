var ProductList = React.createClass({
    componentDidMount: function() {
        this.loadProductFromServer();
        this.loadCategoryFromServer();
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
            //console.log(response);
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
                <button className="loadmore btn btn-default" onClick={this.handleProductloadmore}> Load more...</button>
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
        console.log(this.props.comment.datacomment);
    }.bind(this))
    .catch(function (error){
        console.log(error);
    }.bind(this),)

    },
    render: function(){
        return(
            <div className="product">
            
                <div className="row" key={this.props.id}>
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
                                <p className="properties-label"> Price :</p>
                                <span className="price properties-content"> {this.props.p_price} </span>   
                            </div>
                        </div>
                        <div className="detail col-xs-12 col-md-12"> 
                            <span className="properties-label-des"> Short description:</span>
                            <p>{this.props.p_short_description}</p>
                            <a href="{window.location+'/detail/'+ this.props.id}"> Read more </a>
                        </div>

                        <div className="btn-group btn-group-justified ">
                            <a href="#" className="btn btn-default"><span className="glyphicon glyphicon-heart"></span><span>306</span></a>
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

var CommentBox = React.createClass({
    handleLoadmorecomment:function(e){
     var pro_id = this.props.id_product;
     
     var obj = {
          "productid": this.props.comment.datacomment
        };
           function getCount(group) {
            var count = 0;
            for (var i = 0; i < obj.productid.length; i++) {
                if (obj.productid[i].product_id_c == group) {
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
        //var x = Object.keys(this.props.comment.datacomment.product_id_c==="1").length;
        //console.log(x);
    }.bind(this))
    .catch(function (error){
        console.log(error);
    }.bind(this),) 
    },
    render: function(){
        return(
           <div className="commentbox collapse" id={"collapse"+this.props.id_product}>
            <button className="loadmore btn btn-default" onClick={this.handleLoadmorecomment}> Load older comment...</button>  
            {this.props.data.map((a)=>{ if(this.props.id_product == a.product_id_c){ return(
                <div className="well" key={a.id}>
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
                  
                </div>)}
            })} 
            
             <CommentForm id_product={this.props.id_product}/>  

          </div>       
        )
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
        ajaxcomment: window.location+'/apis/ajaxcomment'
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
    }
};

var reducer = function(state,action){
    if(state === undefined) {
        return initialState;
    }
    var newState = state;
        switch(action.type){
        
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
        }
    }
};


var ProductListState = function(state){
    return {
        url: state.url,
        query: state.query,
        data: state.products
    };
};


ProductList = connect(
    ProductListState,
    ProductListDispatch
)(ProductList)

//send data to Product component
var ProductsState = function(state){
    return {
        url: state.url,
        comment: state.comment
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
        }
    }
};

Products = connect(ProductsState,CommentDispatch)(Products)

var CommentBoxState = function(state){
    return{
        data: state.comment.datacomment,
        comment: state.comment,
        url: state.url
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
        }
    }
};
CommentForm=connect(CommentFormState,CommentFormDispatch)(CommentForm)
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