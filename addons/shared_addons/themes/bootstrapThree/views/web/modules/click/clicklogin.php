<div class="container" <?php if ($location_detail['layout']['value'] == "fullsize"){ echo "id=\"container-bottom-0\"";}?>>
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8" style="min-height: 180px;">
			<div class="panel panel-primary <?php if ($location_detail['layout']['value'] != "fullsize"){ echo "sw-status-panel";} else { echo "id=\"wifilogin\"";}?>">
				<div class="panel-body">
					<div class="text-center">
						<div class="row" id="sw-status-wait" style="display:inline; margin:0 auto;" class="clearfix">
								{{ theme:image file="wait.gif" width="30" height="30" alt="Please wait" style="margin: 0 auto;" class="img-rounded center-block" }}
						</div>
						<?php if ($location_detail['layout']['value'] != "fullsize"):?>
							<div class="row">
								{{ location_detail:waiting_content }}
							</div>
						<?php endif;?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-2"></div>
	</div>
</div>
<script>
	$(function() {
		$.ajaxSetup({
        	data: {
            	csrf_hash_name: '<?php echo $this->security->get_csrf_hash(); ?>'
        	}
    	});
    	userdata = {					
			'loc_id': <?php echo "'".$location_detail['id']."'";?>,
			'called':"<?php echo $user_data['called'];?>"
		};				
		$.post( "click/login/logs", userdata, function( data ) {
			console.log(data);
		});
	});
</script>