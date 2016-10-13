var Blog = React.createClass({
  loadCommentsFromServer: function(a) {
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
  

 //origin state
  getInitialState: function() {
    return {data: [], query:{limit:3,offset:0}};
  },

   componentDidMount: function() {
    this.loadCommentsFromServer();
   
  },

 //loadmore button-> load 3 more product with limit=1
  handleSubmit: function(e) {
      e.preventDefault();
      var limit = 3;
      var offset = this.state.query.offset+3
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

  render: function(){
    //map data after call-> set props for List product below
    var Node = this.state.data.map(function(a) {
      return (
        <Ls p_name={a.p_name} id={a.id} key={a.id} p_price={a.p_price} p_short_description={a.p_short_description} p_image={a.path}>
        </Ls>
      );
    });
    return(
      <div className="main">
        <div className="row">
          <Searchbox />
          <Filter />
        </div>
        <div className="row">
          <div className="product">
            {Node}
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
  render: function(){
    return(
     <div className="filter-category col-xs-12">
            
            <div className="btn-group btn-group-justified">
                <div className="btn-group">
                    <button type="button" className="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    Categories <span className="caret"></span></button>
                    <ul className="dropdown-menu" role="menu">
                    <li><a href="#">Category 1</a></li>
                    <li><a href="#">Category 2</a></li>
                    </ul>
                </div>
                <div className="btn-group">
                    <button type="button" className="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    Filter <span className="caret"></span></button>
                    <ul className="dropdown-menu" role="menu">
                    <li><a href="#">All</a></li>
                    <li><a href="#">Most popular</a></li>
                    </ul>
                </div>
            </div>
  </div>
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
