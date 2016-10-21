var Comment = React.createClass({
	render: function() {
		return (
			<div className="properties-detail">
				<div className="col-xs-12 col-md-12"> 
					<h2>Comment:</h2>
					<span>Font Awesome gives you scalable vector icons that can instantly be customized — size, color, drop shadow, and anything that can be done with the power of CSS.</span>
				</div>
			</div>		
		);
	}
});
ReactDOM.render(
  <Comment />, document.getElementById('comment')
);