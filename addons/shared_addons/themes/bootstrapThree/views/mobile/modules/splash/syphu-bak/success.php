<?php if ($location_detail['layout']['value'] == "fullsize"):?>
	<div id="container-bottom-0" class="container">
		<div class="row">			
			<div class="col-xs-12">
				<div class="panel panel-default" id="wifilogin">
					<div class="panel-body">
						<div class="text-center">
							<h3>Bạn đã đăng nhập wifi thành công</h3>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
<?php else:?>
	<div id="container" class="container">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
						<div class="text-center">
							<h5>Bạn đã đăng nhập wifi thành công</h5>
						</div>
			</div>
			<div class="col-md-3"></div>
			<div class="col-md-12">
				{{ location_detail:success_content }}
			</div>
		</div>
	</div>
<?php endif;?>