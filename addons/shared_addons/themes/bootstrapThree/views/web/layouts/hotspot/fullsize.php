<!doctype html>
<html>
  <head>
    {{ theme:partial name="hotspot/default/metadata" }}
  </head>
<body>
	{{ template:body }}
	{{ widgets:area slug="woopra" }}
	<script>
		    $.backstretch([   	
		    		"{{ location_detail:desktoptablet_background:image}}"		    			    	
		    	{{ if location_detail:desktoptablet_background_2:image }}
		    		,"{{ location_detail:desktoptablet_background_2:image}}"
		    	{{ endif }}
		    	{{ if location_detail:desktoptablet_background_3:image }}
		    		,"{{ location_detail:desktoptablet_background_3:image}}"
		    	{{ endif }}
		      ], {
		        fade: 750,
		        duration: 4000
		    });
	</script>       
</body>     
</html>