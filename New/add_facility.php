<?php
session_start();
		include('../config.php'); 
      	error_reporting(0);
      	// SESSION CHECK SET OR NOT
      	if(!isset($_SESSION['admin']))
      	{
      		header('location:index.php');
      	}
		$queryMatch	=	"SELECT Name FROM `Species`";
		$statementMatch	=	$db->prepare($queryMatch);
		$statementMatch->execute();
		$species = $statementMatch->fetchAll();

   if(isset($_POST['submit']))
  	{
			  //When no image is selected
			  if($_FILES['image']['Name']=='')
			  {
					$query  = "INSERT INTO `Animals` SET AID=?,Name=?,Species=?,Sex=?,HealthStatus=?,Pregnant=?,DoB=?,DoA=?,Exhibit=?";
					$parameters = array($_POST['AID'],$_POST['Name'],$_POST['Species'],$_POST['Sex'],$_POST['HealthStatus'],$_POST['Pregnant'],$_POST['DoB'],$_POST['DoA'],$_POST['Exhibit']);
			  }
			$statement  = $db->prepare($query);
			$statement->execute($parameters);
			$error  = 'success';
			$errormsg = "New User added successfully";
  }
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js"> <!--<![endif]-->
    <head>

    <title>Add User</title>
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
			<h1>Add New User</h1>
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
								Add User
							</h3>
						</div> <!-- /.portlet-header -->
						<div class="portlet-content">
							<div id="error"></div>
							<form id="validate-basic" action="" data-validate="parsley" method="post" class="form parsley-form ajax_form" enctype="multipart/form-data">
								<div class="form-group">
									<label for="name">Name</label>
									<input type="text" id="Name" name="Name" class="form-control" data-required="true" value="<?php echo $_POST['Name'] ?>">
								</div>
								<div class="form-group">
									<label for="name">Species</label>
									<select id="select-input" name="Species" class="form-control" required="">
                                        <option selected disabled hidden style='display: none' value=''></option>
										<? foreach ($species as $i){
											echo "<option value='". $i[0] ."'> ". $i[0] ."</option>";
										}?>
									</select>
								</div>
								<div class="form-group">
									<label for="name">Sex</label>
                                    <select id="select-input" name="Pregnant" class="form-control">
                                        <option selected disabled hidden style='display: none' value='' required=""></option>
                                        <option value="M">M</option>
                                        <option value="F">F</option>
                                        <option value="A">A</option>
                                    </select>
								</div>
								<div class="form-group">
									<label for="name">Health Status</label>
                                    <select id="select-input" name="HealthStatus" class="form-control">
                                        <option selected disabled hidden style='display: none' value=''required=""></option>
                                        <option value="Well">Well</option>
                                        <option value="Ill">Ill</option>
                                        <option value="Recovering">Recovering</option>
                                    </select>
								</div>
								<div class="form-group">
									<label for="name">Preggo</label>
									<select id="select-input" name="Pregnant" class="form-control">
                                        <option selected disabled hidden style='display: none' value=''required=""></option>
										<option value="T">T</option>
										<option value="F">F</option>
									</select>
								</div>
								<!--
								<div class="form-group">
									<label for="name">Preggo</label>
									<select id="select-input" name="status" class="form-control">
										<option value="Enable">F</option>
										<option value="Disable">M</option>
                                        <input type="text" id="HealthStatus" name="HealthStatus" class="form-control" data-required="true" value="<?php echo $_POST['Pregnant'] ?>" >
									</select>
								</div>
								-->
								<div class="form-group">
									<label for="name">DoB</label>
									<input type="text" id="DoB" name="DoB" class="form-control" data-required="true" value="<?php echo $_POST['DoB'] ?>" >
								</div>
								<div class="form-group">
									<label for="name">DoA</label>
									<input type="text" id="DoA" name="DoA" class="form-control" data-required="true" value="<?php echo $_POST['DoA'] ?>" >
								</div>
								<div class="form-group">
									<label for="name">Exhibit</label>
									<input type="text" id="Exhibit" name="Exhibit" class="form-control" data-required="true" value="<?php echo $_POST['Exhibit'] ?>" >
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
<script src="../assets/plugins/parsley/parsley.js"></script>
</body>
</html>