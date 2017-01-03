var Search = React.createClass({
    getInitialState: function(){
        return { likecount: [] , items:[], commentcount:[]};
    },
    componentDidMount: function() {
        this.loaddatafromserver();
        this.loadLikedata();
        this.loadcommentcount();
    },
    loaddatafromserver: function(){
        axios({
            url:this.props.url,
            method:'post',
            data: {
                limit:100,
                offset:0,
                cat_id:'',
                f_id:'1'
            },
        })
        .then(function (response) {
            this.setState({items:response.data});
            console.log(response.data);
            
        }.bind(this))
        .catch(function (error) {
            console.log(error);
            
        }.bind(this),);
    },
    loadLikedata:function(e){
        axios({
            url:window.location.origin+'/pyrocms/products/apis/ajaxlike',
            method:'post',
            data:{user_id:""}
        })
        .then(function (response) {
            this.setState({likecount:response.data});
            
        }.bind(this))
        .catch(function (error) {
            console.log(error);
        }.bind(this),);
    },
    
    loadcommentcount: function(){
        axios({
            url:window.location.origin+'/pyrocms/products/apis/ajaxcommentcount',
            method:'post'
            
        })
        .then(function (response) {
            this.setState({commentcount:response.data});
            
        }.bind(this))
        .catch(function (error) {
            console.log(error);
        }.bind(this),);
    },
    
    
    render: function(){
        
        return <SearchBox items={this.state.items} likecount={this.state.likecount} commentcount={this.state.commentcount}/>
    }
});



var SearchBox = React.createClass({
    
    getInitialState: function(){
        return { searchString: ''};
    },

    handleChange: function(e){
        this.setState({searchString:e.target.value});
    },

    render: function() {
        
        var products = this.props.items,searchString = this.state.searchString.trim().toLowerCase();
        var likecount = this.props.likecount;
        var commentcount = this.props.commentcount;
        if(searchString.length > 0){
            // We are searching. Filter the results.
            products = products.filter(function(l){
                return l.p_name.toLowerCase().match( searchString );
            });

        }
        var style = {color: "grey"};
        return (
        <div>
            <div className="row">
                <div className="col-md-6">
                        
                    <div id="custom-search-input">
                        <div className="input-group col-md-12">
                            <input type="text" className="form-control input-lg" placeholder="Looking for a special product" value={this.state.searchString} onChange={this.handleChange}/>
                            <span className="input-group-btn">
                                <button className="btn btn-info btn-lg" type="button">
                                    <i className="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div className="searchresult">
            
                { products.map(function(l){
                    return (
                            <div className="itemresult row">
                                <a className="itemresult" href={window.location.origin+"/pyrocms/products/detail/"+ l.id}>
                                <div className="col-xs-2">
                                    <img className="searchresultimg " src={l.path} />
                                </div>
                                <div className="col-xs-8">
                                <b className="res-name">{l.p_name} </b>
                                        <br></br>

                                        <span className="res-price">Price: {l.p_price}</span> 
                                        <br></br>
                                        <span className="glyphicon glyphicon-heart" style={style}></span>
                                        { likecount.map(function(a){if(l.id == a.pro_id){return  <span style={style}>{a.likecount}</span>} })}
                                                        <span>   </span>
                                        <span className="glyphicon glyphicon-comment" style={style}></span>
                                        { commentcount.map(function(b){if(l.id == b.pro_id){return  <span style={style}>{b.commentcount}</span>} })}        
                                </div>    
                                      
                                </a>
                            </div>
                    )
                    
                }) }
            
            </div>            
        </div>
        )
    }
});




ReactDOM.render(
	<Search url={window.location.origin+"/pyrocms/products/apis/ajaxlistsearch"}/>,
	document.getElementById('search')
);