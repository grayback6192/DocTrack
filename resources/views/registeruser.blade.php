<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="assets/img/favicon.png" />
	<title>Register | User</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<!-- CSS Files -->
    <link href="logincss/css/bootstrap.min.css" rel="stylesheet" />
	<link href="logincss/css/paper-bootstrap-wizard.css" rel="stylesheet" />

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<!-- <link href="assets/css/demo.css" rel="stylesheet" /> -->

	<!-- Fonts and Icons -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
	<link href="logincss/css/themify-icons.css" rel="stylesheet">
</head>

<body>
	<div class="image-container set-full-height" style="background-image: url('logincss/img/reg.jpg')">
	  

		

	    <!--   Big container   -->
	    <div class="container">
	        <div class="row">
		        <div class="col-sm-8 col-sm-offset-2">

		            <!--      Wizard container        -->
		            <div class="wizard-container">

		                <div class="card wizard-card" data-color="azure" id="wizardProfile">
		                    <form action="{{Route("UserRegister")}}" method="post" enctype="multipart/form-data">
		                <!--        You can switch " data-color="orange" "  with one of the next bright colors: "blue", "green", "orange", "red", "azure"          -->
		                	{{csrf_field()}}
		                    	<div class="wizard-header text-center">
		                        	<h3 class="wizard-title">User Register</h3>
									<p class="category">This is the part of User Register.</p>
		                    	</div>

								<div class="wizard-navigation">
									<div class="progress-with-circle">
									     <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 21%;"></div>
									</div>
									<ul>
			                            <li>
											<a href="#about" data-toggle="tab">
												<div class="icon-circle">
													<i class="ti-user"></i>
												</div>
												Your Info
											</a>
										</li>
			                            <li>
											<a href="#account" data-toggle="tab">
												<div class="icon-circle">
													<i class="ti-settings"></i>
												</div>
												Work
											</a>
										</li>
			                            <li>
											<a href="#address" data-toggle="tab">
												<div class="icon-circle">
													<i class="ti-map"></i>
												</div>
												Address
											</a>
										</li>
			                        </ul>
								</div>
		                        <div class="tab-content">
		                            <div class="tab-pane" id="about">
		                            	<div class="row">
											<h5 class="info-text"> Please tell us more about yourself.</h5>
											<div class="col-sm-4 col-sm-offset-1">
												<div class="picture-container">
													<div class="picture">
														<input type="file" name="userprofpic" id="wizard-picture">
														<img src="{{url('./users/default.jpg')}}" class="picture-src" id="wizardPicturePreview" title="" />
													</div>
													<h6>Choose Picture</h6>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>First Name <small>(required)</small></label>
													<input name="fname" type="text" class="form-control" placeholder="First Name">
												</div>
												<div class="form-group">
													<label>Last Name <small>(required)</small></label>
													<input name="lname" type="text" class="form-control" placeholder="Last Name">
												</div>
												<div class="form-group">
													<label>Contact Number <small>(required)</small></label>
													<input name="contact" type="text" class="form-control" placeholder="Contact Number">
												</div>
												<div class="form-group">
													<label>Address<small>(required)</small></label>
													<input name="address" type="text" class="form-control" placeholder="Address">
												</div>
												<div class="form-group">
													<label>Gender<small>(required)</small></label>
													<label class="radio-inline">
        <input type="radio" name="gender" id="optionsRadiosInline1" value="Male" > Male
</label>

<label class="radio-inline">
       <input type="radio" name="gender" id="optionsRadiosInline2" value="Female">Female
</label>
												</div>
												<div class="form-group">
					
													<label>Signature<small> (required)</small></label>
													<input name="sign" accept = "image/x-png, image/jpeg" type="file" class="form-control" placeholder="Signature">

												</div>
											</div>
										
										</div>
		                            </div>
		                            <div class="tab-pane" id="account">
		                                <h5 class="info-text">Enter Business Key</h5>
		                                <div class="row">
		                                    
		                                      <div class="col-sm-7 col-sm-offset-1">
		                                    	<div class="form-group">
		                                            <label>School Key</label>
		                                            <input type="text" id = "businessKey" name = "business" class="form-control" placeholder="Business Key">
		                                        </div>
		                                    </div>

		                                     
		                                </div>
		                            </div>
		                            <div class="tab-pane" id="address">
		                                <div class="row">
		                                    <div class="col-sm-12">
		                                        <h5 class="info-text"> Create Account </h5>
		                                    </div>
		                                    <div class="col-sm-7 col-sm-offset-1">
		                                    	<div class="form-group">
		                                            <label>Email</label>
		                                            <input name="email" type="email" class="form-control" placeholder="example@gmail.com">
		                                        </div>
		                                    </div>
		                                    <div class="col-sm-7 col-sm-offset-1">
		                                        <div class="form-group">
		                                            <label>Password</label>
		                                            <input type="password" class="form-control" name = "password" placeholder="Password">
		                                        </div>
		                                    </div>
		                                    <div class="col-sm-7 col-sm-offset-1">
		                                        <div class="form-group">
		                                            <label>Confirm Password</label>
		                                            <input type="password" name = "password_confirmation" class="form-control" placeholder="Confirm Password">
		                                        </div>
		                                    </div>
		                                    
		                                </div>
		                            </div>
		                        </div>
		                        <div class="wizard-footer">
		                            <div class="pull-right">
		                                <input type='button' class='btn btn-next btn-fill btn-info btn-wd' name='next' value='Next' />
		                                <input type='submit' class='btn btn-finish btn-fill btn-info btn-wd' name='finish' value='Finish' />
		                            </div>

		                            <div class="pull-left">
		                                <input type='button' class='btn btn-previous btn-default btn-wd' name='previous' value='Previous' />
		                            </div>
		                            <div class="clearfix"></div>
		                        </div>
		                    </form>
		                </div>
		            </div> <!-- wizard container -->
		        </div>
	    	</div><!-- end row -->
		</div> <!--  big container -->

	    <div class="footer">
	        <div class="container text-center">
	            ONCINUE
	        </div>
	    </div>
	</div>
</body>

	<!--   Core JS Files   -->
	<script src="logincss/js/jquery-2.2.4.min.js" type="text/javascript"></script>
	<script src="logincss/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="logincss/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>

	<!--  Plugin for the Wizard -->
	<script src="logincss/js/paper-bootstrap-wizard.js" type="text/javascript"></script>

	<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
	<script src="logincss/js/jquery.validate.min.js" type="text/javascript"></script>


{{-- Ajax --}}
<script type = "text/javascript"></script>
<script>
$("#businessKey").keypress(function()
{
	$.ajax(
	{
		url: "/key",
		type: "GET",
		success:function(data)
		{
			// alert(data);
		}
	});
})

</script>







</html>
