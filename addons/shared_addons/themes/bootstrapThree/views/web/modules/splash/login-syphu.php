<?php if ($location_detail['layout']['value'] == "fullsize"):?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-4">
				<!-- Modal -->
				<div class="modal fade modal-transparent" id="modal-transparent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">			      
				      <div class="modal-body">
				      	<div class="row">
				      		<?php foreach ($wifi_method_position as $key => $value): ?>			     						 
										     	<?php if($key == "facebook_js"): ?>
													
														  <a class="btn btn-block azm-social azm-btn-40 azm-facebook wifi-login-link" href="<?php echo $wifi_login_html[$key]['link'];?>">
														    <i class="fa fa-40 fa-facebook pull-left"></i> <?php if (isset($wifi_login_html[$key]['caption'])) {echo $wifi_login_html[$key]['caption'];} else { echo "Login with Facebook";}?> 
														  </a>

										     	<?php endif?>
										     	
										     	<?php if($key == "google_js"): ?>
										     		
														<a class="btn btn-block azm-social azm-btn-40 azm-google-plus wifi-login-link" href="<?php echo $wifi_login_html[$key]['link'];?>">
														    <i class="fa fa-40 fa-google-plus pull-left"></i> <?php if (isset($wifi_login_html[$key]['caption'])) {echo $wifi_login_html[$key]['caption'];} else { echo "Login with Google";}?>
														</a>

										     	<?php endif?>
										     	
										     	<?php if($key == "click"): ?>
										     												     			
										     			<a id="click-login" class="btn btn-block azm-social azm-btn-40 azm-youtube-play wifi-login-link" href="<?php echo $wifi_login_html[$key]['link'];?>">
														    <i class="fa fa-40 fa-spotify pull-left"></i><?php if (isset($wifi_login_html[$key]['caption'])) {echo $wifi_login_html[$key]['caption'];} else { echo "Quick Login";}?>
														</a>										     			
										     		
										     	<?php endif?>
									     					 
							<?php endforeach;?>
				        	
				        	</div>
				      	</div>

				      </div>
				    </div>
				  </div>
				</div>
			</div>
	</div>

	<div id="container-bottom-0" class="container">
		<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-3">												
					<?php if ( isset($user_data) && ($user_data['res'] == "success" || $user_data['res'] == "already")) :?>
						<div class="" id="wifilogin">
						  	<div class="row">
								<div class="col-xs-12">
									  	 <p class="text-justify">
									  	 		Bạn đã đăng nhập wifi thành công! Cám ơn bạn đã sử dụng dịch vụ của chúng tôi
									  	 		<br/>
									  	 		<i>Login Success! Thanks for using our service!</i>
									  	 		<br/>
									  	 		<?php if ($user_data['userurl']):?>
									  	 			<a style="color:gold;" href="<?php echo $user_data['userurl'];?>" target="_blank"><?php echo $user_data['userurl'];?></a>
									  	 		<?php endif;?>
									  	 </p>
								</div>
							</div>
						</div>
					<?php elseif (!isset($user_data['res'])): ?>
						<div class="" id="wifilogin">
						  	<div class="row">
								     	<div class="col-xs-12">
								     	<p class="text-justify">Chào mừng bạn đến với website của {{ settings:site_name }}, để kết nối wifi vui lòng hiện diện trong vùng phủ sóng của chúng tôi!</p>
								     	<p class="text-justify">Welcome to our service! Please get into our Wi-Fi coverage area for internet access</p>
								     	</div>
							</div>
						</div>
					<?php else: ?>
						<?php if ($user_data['res'] == "failed") :?>
							<div id="wifilogin">
						  		<div class="row">
									<div class="col-xs-12">
									     	<p class="text-danger">Có lỗi xảy ra, bạn vui lòng bấm vào <a href="http://1.0.0.0">đây</a> để đăng nhập lại! (Failed! Please login again!)</p>
									</div>
								</div>
							</div>
						<?php else:?>
							<a id="modal-login-btn" style="width:200px;" class="<?php if (isset($location_detail['login_button_class'])) {echo $location_detail['login_button_class'];}else{echo "btn azm-social btn-block azm-btn-40 azm-medium azm-gradient";}?>" data-toggle="modal" data-target="#modal-transparent">
				  				<?php if (isset($location_detail['login_button_class'])) {echo $location_detail['login_button_caption'];}else{echo "Wifi Login";}?>
							</a>

						<?php endif;?>

					<?php endif ?>
					</div>
					<div class="col-sm-6"></div>
					<div id="sw-copyright" class="pull-right"><i>Power by <a href="http://smartwifi.com.vn" target="_blank">SmartWifi</a></i></div>
			</div>
		</div>
	
<?php else:?>
	
	<div class="container">
		<div class="row">
				<div class="col-sm-8 col-md-8 col-lg-8">
					{{ location_detail:extra_content }}
				</div>
				<div class="col-sm-4 col-md-4 col-lg-4">
					<div class="panel <?php if (isset($location_detail['login_button_class'])){ echo $location_detail['login_button_class']; } else{ echo "panel-primary";}?>" style="margin-top: 15px;">
						<div class="panel-heading text-center">Wifi Login<span class="glyphicon glyphicon-info-sign pull-right" data-toggle="modal" data-target="#myModal"></span></div>
						<div class="panel-body">
							<!-- Modal -->
							<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-body">
							        {{ location_detail:main_content }}
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>							        
							      </div>
							    </div>
							  </div>
							</div>
							
							<?php foreach ($wifi_method_position as $key => $value): ?>			     						 
										     	<?php if($key == "facebook_js"): ?>
													
														  <a class="btn btn-block azm-social azm-btn-40 wifi-login-link <?php if (isset($wifi_login_html[$key]['data']['css_class'])) {echo $wifi_login_html[$key]['data']['css_class'];} else {echo "azm-facebook";}?>" href="<?php echo $wifi_login_html[$key]['link'];?>">
														    <i class="fa fa-40 fa-facebook pull-left"></i> <?php if (isset($wifi_login_html[$key]['caption'])) {echo $wifi_login_html[$key]['caption'];} else { echo "Login with Facebook";}?> 
														  </a>
													
										     	<?php endif?>
										     	
										     	<?php if($key == "google_js"): ?>

														<a class="btn btn-block azm-social azm-btn-40 wifi-login-link <?php if (isset($wifi_login_html[$key]['data']['css_class'])) {echo $wifi_login_html[$key]['data']['css_class'];}else{echo "azm-google-plus";}?>" href="<?php echo $wifi_login_html[$key]['link'];?>">
														    <i class="fa fa-40 fa-google-plus pull-left"></i> <?php if (isset($wifi_login_html[$key]['caption'])) {echo $wifi_login_html[$key]['caption'];} else { echo "Login with Google";}?>
														</a>

										     	<?php endif?>
										     	
										     	<?php if($key == "click"): ?>
										     			
										     			<a id="click-login" class="btn btn-block azm-social azm-btn-40 wifi-login-link <?php if (isset($wifi_login_html[$key]['data']['css_class'])) {echo $wifi_login_html[$key]['data']['css_class'];}else{ echo "azm-dropbox";}?>" href="<?php echo $wifi_login_html[$key]['link'];?>">
														    <?php if (isset($wifi_login_html[$key]['caption'])) {echo $wifi_login_html[$key]['caption'];} else { echo "Quick Login";}?>
														</a>										     			
							
										     	<?php endif?>
									     					 
								<?php endforeach;?>
						</div>
					</div>
				</div>
				
		</div>

	</div>
<?php endif;?>

<script>
	$('.wifi-login-link').click(function(e) {
		var my = $(e.target);
		my.html('Redirecting...');
		//$('#sw-status-wait').fadeIn();
	});
	
	$('#click-login').click(function() {
		if (typeof woopraTracker === 'object') {
			woopra.track("Click Login", {
        			Type: "Attempt"
			});
		}
	});
	
		$(".modal-transparent").on('show.bs.modal', function () {
	  setTimeout( function() {
	    $(".modal-backdrop").addClass("modal-backdrop-transparent");
	    $("#modal-login-btn").hide();
	  }, 0);
	});
	$(".modal-transparent").on('hidden.bs.modal', function () {
	  $(".modal-backdrop").addClass("modal-backdrop-transparent");
	  $("#modal-login-btn").show();
	});
	
	function blinker() {
   	 $('#sw-copyright').fadeOut(1000).fadeIn(1000);
	}

	setInterval(blinker, 1000); //Runs every second
</script>