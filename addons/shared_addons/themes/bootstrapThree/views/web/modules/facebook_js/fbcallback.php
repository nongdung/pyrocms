<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<div id="container" class="container">
	<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">				
				<input type="hidden" id="fb-username" name="fb-username" value="<?php echo $settings['wifi_login_account']['login_username'];?>"/>
				<input type="hidden" id="fb-password" name="fb-password" value="<?php echo $settings['wifi_login_account']['login_password'];?>"/>
				<input type="hidden" id="sharing" name="sharing" value="<?php echo $settings['sharing']['val'];?>"/>
				<input type="hidden" id="wait_time" name="wait_time" value="<?php echo $settings['wait_time'];?>"/>
				<input type="hidden" id="location_id" name="location_id" value="<?php echo $location_id;?>"/>
				<input type="hidden" id="userurl" name="userurl" value="<?php echo $this->session->userdata('userurl');?>"/>
				<input type="hidden" id="login_success_redirect" name="login_success_redirect" value="<?php echo $location_detail['redirect_url'];?>"/>
				<div id="fb-root"></div>				
				
				<div id="fb-step-0" style="display:inline; margin:0px auto;" class="clearfix">
					<div class="panel panel-primary" style="margin-top: 10px;">
						<div class="text-center panel-body">
							<p class="text-center">Facebook loading...</p>
							{{ theme:image file="wait.gif" width="30" height="30" alt="Please wait" style="margin: 0 auto;" class="img-rounded center-block" }}
						</div>
					</div>
				</div>
				
				<div class="form-group panel panel-primary" id="fb-step-1" style="display:none; margin-top:10px;">
					<div class="text-center text-info panel-body">
						<div id="fb-login-msg"></div>
						<div id="clock"></div>
						<div id="btn-connect-fb" style="margin-top:5px;margin-bottom:10px;display:none;">
							<a class="btn btn-primary btn-responsive" onClick="swFacebook.Connect();"><?php echo $settings['share_btn_caption'];?></a>
							<?php if ($settings['sharing']['val'] == "Enable"):?>
							<br/>
							<label style="margin-top:0px;"><input id="checkin" type="checkbox" name="checkin" value="1" checked><i>Check-in</i></label>
							
							<?php endif;?>
						</div>
						<br/>
						<div id="statusPage" style="display:none;">			
								<div class="text-center">
										Well done, you are now connected to Internet.
							
									<div id="originalURL"></div><br/>
									<span id="statusMessage"></span>
									<div class="text-center" style="padding-bottom:5px;">				
										<a href="http://1.0.0.0" class="btn btn-xs btn-warning btn-responsive">Wifi Logout</a>
									</div>
								</div>	
						</div>
											
						<div class="fb-page" data-width="360" data-href="https://www.facebook.com/<?php echo $settings['page_id'];?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"></div>			

					</div>
				</div>
				<div id="waitPage-FB" style="display:none; margin:auto;" class="clearfix">
					{{ theme:image file="wait.gif" width="30" height="30" alt="Please wait" style="margin: 0 auto;" class="img-rounded center-block" }}
				</div>
				
			</div>
			<div class="col-sm-3"></div>
			
	</div>
	<?php if ($location_detail['layout']['value'] != "fullsize"):?>
		<div class="row">
			<div class="col-md-12">
				{{ location_detail:waiting_content }}
			</div>
		</div>
	<?php endif;?>
</div>

<script type="text/javascript">
	swController.onUpdate = SmartWifi.updateUI;
	swController.onError  = SmartWifi.handleError;
	
	window.fbAsyncInit = function() {
		FB.init({
			appId      : '<?php echo $fb_settings['app_id'];?>',
			cookie     : true,
			//status     : true,
			xfbml      : true,  // parse social plugins on this page
			version    : 'v2.5' // use version 2.0
		});
		FB.getLoginStatus(swFacebook.updateButton);
					 
		//LIKE events
		FB.Event.subscribe('edge.create', swFacebook.LikeConnect);
		
		//Comment
		FB.Event.subscribe('comment.create', swFacebook.CommentConnect);
		
		//FB.Event.subscribe('auth.authResponseChange', swFacebook.updateButton);
	};

	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

	var postObj = {
					"enable":"<?php echo $settings['sharing']['val'];?>",
					"pageid":"<?php echo $settings['page_id'];?>",
					"name":"<?php echo $settings['post_name'];?>",
					"link":"<?php echo $settings['post_link'];?>",
					"caption":"<?php echo $settings['post_caption'];?>",
					"desc":"<?php echo $settings['post_desc'];?>",
					"pic":"<?php echo $settings['post_picture'];?>",
					"place":"<?php echo $settings['post_location'];?>"
	};

	var $clock = $('#clock')
		.on('update.countdown', function(event) {
			var format = '%H:%M:%S';
			var time, tt, sec;
			time=event.strftime(format);
			tt=time.split(":");
			sec=tt[0]*3600+tt[1]*60+tt[2]*1;
			$(this).html("(Please wait) Bạn sẽ được đăng nhập Wifi trong: " + sec +"s");      
		})
		.on('finish.countdown', function(event) {			
    		swFacebook.Connect();    		  		
			$(this).html('');
		});
</script>
