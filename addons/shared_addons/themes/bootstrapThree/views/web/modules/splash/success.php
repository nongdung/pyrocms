<div class="container" <?php if ($location_detail['layout']['value'] == "fullsize"){ echo "id=\"container-bottom-0\"";}?>>
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="panel panel-primary <?php if ($location_detail['layout']['value'] != "fullsize"){ echo "sw-status-panel";} else { echo "id=\"wifilogin\"";}?>">
				<div class="panel-body">
					{{ location_detail:success_content }}
				</div>
			</div>
		</div>
		<div class="col-md-3"></div>
	</div>
</div>
