var Blog = React.createClass({
  loadProductFromServer: function() {
     //call data from server
     $.ajax({
      url: this.props.url,
      dataType: 'json',
      type: 'POST',
      data: this.state.query,
      success: function(data) {
        this.setState({data: data, query: this.state.query});
        console.log("loadProductFromServer");
        console.log(this.state);
      }.bind(this),
      error: function(xhr, status, err) {
        console.error(this.props.url, status, err.toString());
      }.bind(this)
        });
    
    },
  loadCategoriesFromServer:function()
  {
      
      $.ajax({
        url: window.location+'/ajaxcategories',
        dataType: 'json',
        type: 'POST',
        data: this.state.cat,
        success: function(data) {
          this.setState({data: this.state.data ,query:this.state.query,cat:data});
         console.log("loadCategoriesFromServer");
          console.log(this.state);
        }.bind(this),
        error: function(xhr, status, err) {
          console.error(window.location+'/ajaxcategories', status, err.toString());
        }.bind(this)
    });
  },
 //origin state
  getInitialState: function() {
    return {data: [], query:{limit:3,offset:0,cat_id:'',f_id:'1'}, cat:[] };
  },
    
   componentDidMount: function() {
    this.loadProductFromServer();
    this.loadCategoriesFromServer();
    
  },

 //loadmore button-> load 3 more product with limit=1
  handleSubmitloadmore: function(e) {
      e.preventDefault();
      var limit = 3;
      var offset = this.state.query.offset+limit;
      // TODO: send request to the server
      $.ajax({
      url: this.props.url,
      dataType: 'json',
      type: 'POST',
      data: {limit:limit, offset: offset,cat_id:this.state.query.cat_id,f_id:this.state.query.f_id},
      success: function(newdata) {
        var a = this.state.data;
        var b = a.concat(newdata);
        this.setState({data: b, query: {limit:limit, offset: offset,cat_id:this.state.query.cat_id,f_id:this.state.query.f_id}});
        console.log("loadmore");
        console.log(this.state);
      }.bind(this),
      error: function(xhr, status, err) {
        console.error(this.props.url, status, err.toString());
      }.bind(this)
        });
      },

  handleCat: function(e){
    var cat_id = e.cat_id;
    var limit = this.state.query.limit;
    var offset = 0;
    
    $.ajax({
    url: this.props.url,
    dataType: 'json',
    type: 'POST',
    data: {limit:this.state.query.limit, offset: offset,cat_id:cat_id,f_id:this.state.query.f_id},
    success: function(data) {
      this.setState({data:data, query: {limit:limit, offset: offset,cat_id:cat_id,f_id:this.state.query.f_id}});
      console.log("catchange");
      console.log(this.state);
    }.bind(this),
    error: function(xhr, status, err) {
      console.error(this.props.url, status, err.toString());
    }.bind(this)
  });
  },

  handleFilterChange: function(e){
    var f_id = e.f_id;
    var limit = this.state.query.limit;
    var offset=0;

    $.ajax({
      url:this.props.url,
      dataType:'json',
      type: 'POST',
      data: {limit:this.state.query.limit, offset: offset,cat_id:this.state.query.cat_id,f_id:f_id},
      success: function(data){
        this.setState({data:data,query: {limit:limit, offset: offset,cat_id:this.state.query.cat_id,f_id:f_id}});
        console.log(this.state);
      }.bind(this),
      error: function(xhr, status, err){
        console.error(this.props.url, status, err.toString());
      }.bind(this)
    });
    console.log(f_id);
  },

  render: function(){
    //map data after call-> set props for List product below
    var List = this.state.data.map(function(a) {
      return (
        <Ls p_name={a.p_name} id={a.id} key={a.id} p_price={a.p_price} p_short_description={a.p_short_description} p_image={a.path}>
        </Ls>
      );
    });

    
    return(
      <div className="main">
        <div className="row">
          <Searchbox />
          <div className="filter col-xs-12">
          <Category cat = {this.state.cat} onhanldeChange={this.handleCat}/>
          <Filter onhandleFilterChange={this.handleFilterChange} />
          </div>
        </div>
        <div className="row">
          <div className="product">
            {List}
          </div>
        </div>
        <div className="row text-center">
          <button className="loadmore btn btn-default" onClick={this.handleSubmitloadmore}> Load more...</button>
        </div>
      </div>
    );
  }
});

//SearchBox
var Searchbox = React.createClass({
  render: function(){
    return(
      <div className="searchbox input-group col-xs-12">
            <input type="text" className="search-query form-control" placeholder="Search" />
            <span className="input-group-btn">
                <button className="btn btn-danger" type="button" >
                    <span className="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    );
  }
});

//filter: category
var Category = React.createClass({
  getInitialState: function() {
        return {
            cat_id: ''
        }
    },
  handleSubmit:function(e){
    this.setState({cat_id: e.target.value}); 
    e.preventDefault();
    var cat_id = e.target.value;
    
    
    this.props.onhanldeChange({cat_id: cat_id});
    this.setState({cat_id: e.target.value});
    
  },
  render: function(){
    var Cat = this.props.cat.map(function(c){
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
  );
  }
});

//Filier
var Filter = React.createClass({
  getInitialState: function(){
    return {
      f_id: '1'
    }
  },
  handleFilter: function(e){
    this.setState({f_id: e.target.value});
    e.preventDefault();
    var f_id=e.target.value;

    this.props.onhandleFilterChange({f_id: f_id});
    this.setState({f_id: e.target.value});
  },
  render: function(){
    return (
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

//List product
var Ls = React.createClass({
  getInitialState: function(){
    return {
      pro_id: ''
    }
  },
  
  handleShowComment: function(e){
    
    console.log('you are here boy');
  },
  render: function(){
    
    return(
      <div className="ls col-xs-12" id="ls">
          <div className="image col-xs-12">
          <a href={'http://localhost/pyrocms/products/detail/'+ this.props.id}>
             <img src={this.props.p_image} />
          </a>
          </div>

          <div className="detail col-xs-6 col-md-6 ">
              <p className="properties-label"> <a href={'http://localhost/pyrocms/products/detail/'+ this.props.id}> {this.props.p_name} </a> </p>   
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
              <a href="#"> Read more </a>
          </div>
          
          <div className="btn-group btn-group-justified">
              <a href="#" className="btn btn-default"><span className="glyphicon glyphicon-heart"></span></a>
              <a className="btn btn-default" role="button" data-toggle="collapse" href={"#collapse"+this.props.id} aria-expanded="false" aria-controls={"collapse"+this.props.id} onClick={this.handleShowComment}><span className="glyphicon glyphicon-comment"></span></a>
              <a href="#" className="btn btn-default"><span className="glyphicon glyphicon-share-alt"></span></a>
          </div>  

          <div className="collapse" id={"collapse"+this.props.id}>
            <div className="well">
                  asdfasdljkfhasljasdfhjasdfhjklasdfhjkasdfhjkasdfasdfl
            </div>
            <div className="well">
                  asdfasdljkfhasljasdfhjasdfhjklasdfhjkasdfhjkasdfasdfl
            </div>
            <div className="well">
                  asdfasdljkfhasljasdfhjasdfhjklasdfhjkasdfhjkasdfasdfl
            </div>
          </div> 
               
      </div>
    );
  }
}); 



ReactDOM.render(
<Blog url={window.location+"/ajaxlist"}/>,
document.getElementById('product')
); 
