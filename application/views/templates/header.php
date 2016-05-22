<html>
	<head>
    	<link href="<?php echo base_url(); ?>asset/css/bootstrap.min.css" rel="stylesheet">
        <!--<link href="<?php //echo base_url(); ?>asset/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="<?php //echo base_url(); ?>asset/css/buttons.dataTables.min.css" type="text/css" rel="stylesheet"/>-->
        <link href="<?php echo base_url(); ?>asset/css/custom_style.css" type="text/css" rel="stylesheet"/>
        <script src="<?php echo base_url(); ?>asset/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script>
        <!--<script src="<?php //echo base_url(); ?>asset/js/jquery.dataTables.min.js"></script>
        <script src="<?php //echo base_url(); ?>asset/js/buttons.print.min.js"></script>
        <script src="<?php //echo base_url(); ?>asset/js/dataTables.buttons.min.js"></script>
        <script src="<?php //echo base_url(); ?>asset/js/highcharts.js"></script>-->
		<title>Simple Task</title>
	</head>
	<body>
    	<nav class="navbar navbar-default navbar-fixed-top">
    		<div class="container-fluid">
                <div class="navbar-header">
                  <a class="navbar-brand" href="<?php echo base_url(); ?>">SIMPLE TASK</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                	<?php
                	if(isset($this->session->userdata['logged_in']))
					{
						?>
	                    <ul class="nav navbar-nav">
	                        <li><a href="<?php echo site_url('contact'); ?>">Contact</a></li>
	                        <li><a href="<?php echo site_url('user'); ?>">User</a></li>
	                    </ul>
	                    <ul class="nav navbar-nav navbar-right">
					        <li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
									<?php echo strtoupper($_SESSION["name"]); ?><span class="caret"></span>
								</a>
								<ul class="dropdown-menu">
						            <li><a href="<?php echo site_url().'/login/logout'; ?>"><span class="glyphicon glyphicon-off"> LOGOUT</span></a></li>
					          	</ul>
					        </li>
						</ul>
	                    <?php
                    }
                    ?>
          		</div>
            </div>
		</nav>
		<?php 
		if(isset($this->session->userdata['logged_in']))
		{
			?>
        <div align="center">
        	<div class="well" style="width:90%; height:90%">
				<h1><?php
						echo $title;
					?></h1>
					<hr>
					<?php
				}
				?>