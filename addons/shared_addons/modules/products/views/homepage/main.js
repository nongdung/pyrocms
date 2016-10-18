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
        console.log(data);
      }.bind(this),
      error: function(xhr, status, err) {
        console.error(this.props.url, status, err.toString());
      }.bind(this)
        });
    
    },
  loadCategoriesFromServer:function()
  {
      $.ajax({
        url: 'http://localhost/pyrocms/products/ajaxcategories',
        dataType: 'json',
        type: 'POST',
        data: this.state.value,
        success: function(data) {
          this.setState({value: data});
          console.log(data);
        }.bind(this),
        error: function(xhr, status, err) {
          console.error('http://localhost/pyrocms/products/ajaxcategories', status, err.toString());
        }.bind(this)
    });
  },
 //origin state
  getInitialState: function() {
    return {data: [], query:{limit:3,offset:0}, value:[]};
  },
    
   componentDidMount: function() {
    this.loadProductFromServer();
    this.loadCategoriesFromServer();
    
  },

 //loadmore button-> load 3 more product with limit=1
  handleSubmit: function(e) {
      e.preventDefault();
      var limit = 3;
      var offset = this.state.query.offset+3;
      // TODO: send request to the server
      $.ajax({
      url: this.props.url,
      dataType: 'json',
      type: 'POST',
      data: {limit:1, offset: offset},
      success: function(newdata) {
        var a = this.state.data;
        var b = a.concat(newdata);
        this.setState({data: b, query: {limit:limit, offset: offset}});
        
      }.bind(this),
      error: function(xhr, status, err) {
        console.error(this.props.url, status, err.toString());
      }.bind(this)
        });
      },

  handleChange: function(e){
    var vname = e.value;
    var limit = 2;
    var offset = 0;
    console.log(e);
    $.ajax({
    url: this.props.url,
    dataType: 'json',
    type: 'POST',
    data: {value:vname,limit:3, offset: offset},
    success: function(data) {
      this.setState({data:data, query: {limit:limit, offset: offset},value:this.state.value});
      console.log(data);
      console.log(this.state.query);
      console.log(this.state.value);
    }.bind(this),
    error: function(xhr, status, err) {
      console.error(this.props.url, status, err.toString());
    }.bind(this)
  });
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
          <Filter cat = {this.state.value} onhanldeChange={this.handleChange}/>
        </div>
        <div className="row">
          <div className="product">
            {List}
          </div>
        </div>
        <div className="row text-center">
          <button className="loadmore btn btn-default" onClick={this.handleSubmit}> Load more...</button>
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

//filter: category+filter
var Filter = React.createClass({
  getInitialState: function() {
        return {
            value: 'All'
        }
    },
    change: function(event){ 
        this.setState({value: event.target.value}); 
    },
    
    handleSubmit:function(e){
      e.preventDefault();
      var value = this.state.value;
      this.props.onhanldeChange({value: value});
      this.setState({value: ''});
      //console.log(this.state.value);
    },
  render: function(){
    var Cat = this.props.cat.map(function(c){
      return(
      <option key={c.c_name} value={c.c_name}>{c.c_name}</option>);
    })
    return(
      <form className="commentForm" onSubmit={this.handleSubmit}>
          <select id="lang" onChange={this.change} value={this.state.value} >
              <option value="All" type="submit" >All</option>
              {Cat}
         </select>
           <input type="submit" value="Post" />
              <p></p>
          <p>{this.state.value}</p>
           
     </form>
  );
  }
});

//List product
var Ls = React.createClass({
  
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
              <a href="#" className="btn btn-default"><span className="glyphicon glyphicon-thumbs-up"></span></a>
              <a href="#" className="btn btn-default"><span className="glyphicon glyphicon-comment"></span></a>
              <a href="#" className="btn btn-default"><span className="glyphicon glyphicon-share-alt"></span></a>
          </div>             
      </div>
    );
  }
}); 

ReactDOM.render(
<Blog url="http://localhost/pyrocms/products/ajaxlist"/>,
document.getElementById('product')
); 
