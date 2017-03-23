<?php
session_start();
		include('../config.php'); 
      	error_reporting(0);
      	// SESSION CHECK SET OR NOT
      	if(!isset($_SESSION['admin']))
      	{
      		header('location:index.php');
      	}

   $user_id = $_GET['id'];

   if(isset($_POST['submit']))
  	{
		
   

		
		$query  = "UPDATE `Animals` SET Name=?,HealthStatus=?,Pregnant=?,DoA=?,Exhibit=?";
		$parameters = array($_POST['Name'],$_POST['HealthStatus'],$_POST['Pregnant'],$_POST['DoA'],$_POST['Exhibit']);		  
		$statement  = $db->prepare($query);
		$statement->execute($parameters);
		$error  = 'success';
		$errormsg = "User updated successfully";
                 

    }

      		
       $queryMatch	=	"SELECT Name FROM `Species`";
		$statementMatch	=	$db->prepare($queryMatch);
		$statementMatch->execute();
		$species = $statementMatch->fetchAll();

      	// Query To Get User Data
       $userData = $db->prepare("SELECT * FROM Animals WHERE AID=?");
       $userData->execute(array($user_id));
       $row_user = $userData->fetch(PDO::FETCH_ASSOC); 		
?>


<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js"> <!--<![endif]-->
    <head>

    <title>Edit <?php echo $row_user['name'];?></title>
	<?php include "include/head.php" ?>
	
	<link rel="stylesheet" href="../assets/plugins/fileupload/bootstrap-fileupload.css" type="text/css" />

	<style>
      
      .gmnoprint img {
    		max-width: none; 
	}
	#mapCanvas{
		 height: 300px;
        width: 480px;
        border: 1px solid #333;
        margin-top: 0.6em;
	}
	#select4 {
			height: 300px;
		}		
</style>

</head>

<body>
<div id="wrapper">

	<?php include 'include/header.php'; ?>
	<?php include 'include/topMenu.php'; ?>
	<?php include 'include/sidebar.php'; ?>

	<div id="content">		
		<div id="content-header">
			<h1>Edit <b><?php echo $row_user['name'];?></b></h1>
		</div> <!-- #content-header -->	
		<div id="content-container">
		<?php 
  if($errormsg){
    echo "<div class='alert alert-$error'  style='padding-left: 5px;'>$errormsg</div>";
  }?> 
			<div class="row">
				<div class="col-sm-6">
					<div class="portlet">
						<div class="portlet-header">
							<h3><i class="fa fa-plus-square"></i>
								Edit User
							</h3>
						</div> <!-- /.portlet-header -->
						<div class="portlet-content">
							<div id="error"></div>
							<form id="validate-basic" action="" data-validate="parsley" method="post" class="form parsley-form ajax_form" enctype="multipart/form-data">
<div class="form-group">
									<label for="name">Name</label>
									<input type="text" id="Name" name="Name" class="form-control" data-required="true" value="<?php echo $row_user['Name'] ?>">
								</div>
								<div class="form-group">
									<label for="name">Health Status</label>
                                    <select id="select-input" name="HealthStatus" class="form-control">
									
                                        <option value="<?php echo $row_user['HealthStatus'] ?>">Pre Selected: <?php echo $row_user['HealthStatus'] ?></option>
                                        <option value="Well">Well</option>
                                        <option value="Ill">Ill</option>
                                        <option value="Recovering">Recovering</option>
                                    </select>
								</div>
								<div class="form-group">
									<label for="name">Preggo</label>
									<select id="select-input" name="Pregnant" class="form-control">
                                        <option value="<?php echo $row_user['Pregnant'] ?>"> Pre Selected: <?php echo $row_user['Pregnant'] ?></option>
										<option value="T">T</option>
										<option value="F">F</option>
									</select>
								</div>
								<div class="form-group">
									<label for="name">DoA</label>
									<input type="text" id="DoA" name="DoA" class="form-control" data-required="true" value="<?php echo $row_user['DoA'] ?>" >
								</div>
								<div class="form-group">
									<label for="name">Exhibit</label>
									<input type="text" id="Exhibit" name="Exhibit" class="form-control" data-required="true" value="<?php echo $row_user['Exhibit'] ?>" >
								</div>

								<div class="form-group">
									<button type="submit"  name="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Submit</button>
								</div>
							</form>
						</div> 
					  <!--END PORTLET-CONTENT -->
					</div> 
				  <!-- END PORTLET -->
	            </div> 
	           <!-- END COL -->
			</div> 
		  <!--END ROW -->
		</div> 
	   <!-- END CONTENT-CONATINER -->
	</div> 
  <!--END CONTENT -->
</div> 
<!--END WRAPPER -->


<?php include "include/footer.php" ?>
<?php include "include/footerjs.php" ?>
<script src="../assets/plugins/fileupload/bootstrap-fileupload.js"></script>
<script src="../assets/plugins/parsley/parsley.js"></script>




<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
<script type="text/javascript">

		//Get Latitude And Longitude
		var geocoder = new google.maps.Geocoder();

		function geocodePosition(pos) 
		{
			  geocoder.geocode(
			  {
			    latLng: pos
			  }, function(responses) 
			  	{
					    if (responses && responses.length > 0) {
					      updateMarkerAddress(responses[0].formatted_address);
					    } else {
					      updateMarkerAddress('add address');
					    }
			  	});
		}

		function updateMarkerStatus(str) 
		{
		  //document.getElementById('markerStatus').innerHTML = str;
		}

		function updateMarkerPosition(latLng) 
		{
			$('#lat').val(latLng.lat());
			$('#lng').val(latLng.lng());
		}

		function updateMarkerAddress(str) 
		{
		 
		  $('#currentlocation').val(str);
		  
		}
		    
		function initialize() 
		{
				//Latitude longitude of default
				var clat = <?php $lat=$row_user['latitude']==''?0:$row_user['latitude'];echo $lat;?>;
				var clong = <?php $long=$row_user['longitude']==''?0:$row_user['longitude'];echo $long;?>;

				var latLng = new google.maps.LatLng(clat,clong);
				   
		        var mapOptions = {
		          center: latLng,
		          zoom: 8,
		          mapTypeId: google.maps.MapTypeId.ROADMAP
		        };
				
		       map = new google.maps.Map(document.getElementById('mapCanvas'),
		          mapOptions);

		        var input = document.getElementById('currentlocation');
				
		        var autocomplete = new google.maps.places.Autocomplete(input);

		        //autocomplete.bindTo('bounds', map);

		        var infowindow = new google.maps.InfoWindow();
		        marker = new google.maps.Marker({
		          map: map,
				  position: latLng,
		          title: 'ReferSell',
		          map: map,
		          draggable: true
		        });
		         updateMarkerPosition(latLng);
		         geocodePosition(latLng);
		  
		  // Add dragging event listeners.
		  google.maps.event.addListener(marker, 'dragstart', function() {
		    updateMarkerAddress('Dragging...');
		  });
		  
		  google.maps.event.addListener(marker, 'drag', function() {
		    updateMarkerStatus('Dragging...');
		    updateMarkerPosition(marker.getPosition());
		  });
		  
		  google.maps.event.addListener(marker, 'dragend', function() {

		    updateMarkerStatus('Drag ended');
		    geocodePosition(marker.getPosition());
		  });
		        google.maps.event.addListener(autocomplete, 'place_changed', function() {
		          infowindow.close();
		          var place = autocomplete.getPlace();
				 
		          if (place.geometry.viewport) {
		            map.fitBounds(place.geometry.viewport);
		          } else {
		            map.setCenter(place.geometry.location);
		            map.setZoom(10);  // Why 17? Because it looks good.
		          }

		          var image = new google.maps.MarkerImage(
		              place.icon,
		              new google.maps.Size(71, 71),
		              new google.maps.Point(0, 0),
		              new google.maps.Point(17, 34),
		              new google.maps.Size(35, 35));
		          marker.setIcon(image);
		          marker.setPosition(place.geometry.location);
		           updateMarkerPosition(place.geometry.location);
		       //  geocodePosition(place.geometry.location);
		          var address = '';
		         

		         // infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
		        //  infowindow.open(map, marker);
		        });

		        // Sets a listener on a radio button to change the filter type on Places
		        // Autocomplete.
		        function setupClickListener(id, types) {
		          var radioButton = document.getElementById(id);
		          google.maps.event.addDomListener(radioButton, 'click', function() {
		            autocomplete.setTypes(types);
		          });
		        }
		       
		      }

		      google.maps.event.addDomListener(window, 'load', initialize);
    </script> 
</body>
</html>