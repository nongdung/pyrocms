<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="container" <?php if ($location_detail['layout']['value'] == "fullsize"){ echo "id=\"container-bottom-0\"";}?>>
	<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<input type="hidden" id="gg-username" name="gg-username" value="<?php echo $settings['wifi_login_account']['login_username'];?>"/>
				<input type="hidden" id="gg-password" name="gg-password" value="<?php echo $settings['wifi_login_account']['login_password'];?>"/>
				<input type="hidden" id="location_id" name="location_id" value="<?php echo $location_id;?>"/>
				<input type="hidden" id="userurl" name="userurl" value="<?php echo $this->session->userdata('userurl');?>"/>
				<input type="hidden" id="login_success_redirect" name="login_success_redirect" value="<?php echo $location_detail['redirect_url'];?>"/>
				
				<div class="form-group panel panel-primary" <?php if ($location_detail['layout']['value'] != "fullsize"){ echo "id=\"sw-status-panel\"";}?>>
					<div class="panel-body text-center text-info">
							<div id="content"></div>
							<span id="clock"></span>
							<div id="sw-gg-wait" style="display:inline; margin:0 auto;" class="clearfix">
								{{ theme:image file="wait.gif" width="30" height="30" alt="Please wait" style="margin: 0 auto;" class="img-rounded center-block" }}
							</div>
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
					</div>
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
			//window.location.assign("/smartwifi.vn/splash/success/<?php echo $location_id;?>/d");
    		ggConnect();
    		setTimeout(function() {
    			if (swController.clientState != 1) {
    				window.location.assign('http://1.0.0.0');
    			}
			},5000);    		
    		$('#sw-gg-wait').hide();
			$(this).html('');
		});

	var clientId = '<?php echo $gg_settings['client_id'];?>';
	var apiKey = '<?php echo $gg_settings['api_key'];?>';
	<?php if ($gg_settings['plus_login']):?>
	var scopes = 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/plus.login';
	<?php else:?>
	var scopes = 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile';
	<?php endif;?>

	function handleClientLoad() {
		gapi.client.setApiKey(apiKey);
		window.setTimeout(checkAuth,100);
	}

	function checkAuth() {
        	gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true}, handleAuthResult);
	}

	function handleAuthResult(authResult) {
        if (authResult && !authResult.error) {
			makeApiCall();
        } else {
			$('#content').html('<div class="text-danger">Google login failed! Click <a href="http://1.0.0.0">here</a> to retry!</div>');
        }
	}

	function makeApiCall() {		
		$.ajaxSetup({
        	data: {
            	csrf_hash_name: SmartWifi.readCookie('wifi_csrf_cookie_name')
        	}
    	});
		var userdata;
		gapi.client.load('plus', 'v1', function() {
			var request = gapi.client.plus.people.get({
				'userId': 'me'
			});
			request.execute(function(resp) {
				var primaryEmail;
				for (var i=0; i < resp.emails.length; i++) {
					if (resp.emails[i].type === 'account') primaryEmail = resp.emails[i].value;
				}
				userdata = {
					'g_id' : resp.id,
					'g_name' : resp.displayName,
					'g_email' : primaryEmail,
					'g_gender' : resp.gender,
					'g_link' : resp.url,
					'g_language' : resp.language,
					'loc_id'	: <?php echo "'".$location_id."'";?>
				};
				if (typeof woopraTracker === 'object') {
					var ggIdentified = SmartWifi.readCookie('sw_gg_woopra_identified');
					if (ggIdentified == null) {
						woopra.identify({
							ggid : resp.id,
							name : resp.displayName,
							email : primaryEmail,
							gender : resp.gender,
							profile : resp.url,
						}).push();
						SmartWifi.eraseCookie('sw_gg_woopra_identified');
						SmartWifi.createCookie('sw_gg_woopra_identified','1',2400);
					}
				}
				
				$.post( "google_js/callback/logs", userdata, function( data ) {
					//alert( "Data Loaded: " + data );
				});
				
				var heading = document.createElement('h4');
				var image = document.createElement('img');
				image.src = resp.image.url;
				heading.appendChild(document.createTextNode('Hi! ' + resp.displayName));
				document.getElementById('content').appendChild(heading);
				
				var val = 1000 * <?php echo $settings['wait_time'];?>;
    			selectedDate = new Date().valueOf() + val;
    			$clock.countdown(selectedDate.toString());
			});
		});
	}

	function ggConnect(){
		if (swController.clientState == -1) {
			$('#content').html('<div class="text-danger">Error! Wifi is not ready!</div>');
			setTimeout(function() {
				window.location.assign('http://1.0.0.0');
			},3000);
			return false;
		} else if ( swController.clientState == 0 ) {
			var username;
			var password;
			var u = document.getElementById('gg-username');
			var p = document.getElementById('gg-password');
			if (u != null) {username = u.value} else {username ='';}
			if (p != null) {password = p.value} else {password ='';}
			
			if (typeof woopraTracker === 'object') {
				woopra.track("Google Login", {
	        			Type: "Attempt"
				});
			}
	
			if (username != '' && password != '') {
				SmartWifi.showPage('waitPage-GG');	 
				setTimeout('swController.logon(\''+ username + '\',\'' + password + '\')', 500);
				setTimeout(function() {
					if (swController.clientState == 1){		
						if (typeof woopraTracker === 'object') {
							woopra.track("Google Login", {
	        						Type: "Success"
							});
						}
						
					} else {
						if (typeof woopraTracker === 'object') {
							woopra.track("Google Login", {
	        						Type: "Failed"
							});
						}
					}
					window.scrollTo(0,0);
				},1500);
			} else {
				alert("Username/Password is not set");
			}
		} else {
			return false;
		}
	}
</script>

<script src="https://apis.google.com/js/client.js?onload=handleClientLoad" async defer></script>
