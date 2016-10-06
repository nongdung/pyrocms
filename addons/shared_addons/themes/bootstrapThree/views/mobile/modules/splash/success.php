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
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
						<div class="panel panel-primary sw-status-panel">
							<div class="panel-body">
								{{ location_detail:success_content }}
							</div>
						</div>
			</div>
		</div>
	</div>
<?php endif;?>