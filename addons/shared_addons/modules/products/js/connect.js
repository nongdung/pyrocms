var Connect = React.createClass({
	render: function() {
		return (
			<div className="connect  btn-group  btn-group-justified">							
				<a className="btn btn-primary" href="#" role="button">
					<i className="fa fa-heart-o" aria-hidden="true"> Like </i>
				</a>
			
				<a className="btn btn-success" href="#" role="button">
					<i className="fa fa-comment-o" aria-hidden="true"> Comment </i>
				</a>
				
				<a className="btn btn-danger" href="#" role="button">
					<i className="fa fa-share-alt" aria-hidden="true"> Share </i>
				</a>
			</div>		
		);
	}
});
ReactDOM.render(
  <Connect />, document.getElementById('conn')
);

