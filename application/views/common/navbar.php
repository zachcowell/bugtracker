<div class="container-fluid">
<div class="navbar navbar-inverse">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Issue tracker</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              	<li id="dashboard" class="loggedin"><a href="<?= site_url('home/viewDashboard'); ?>">Dashboard</a></li>
				<li id="home" class="loggedin"><a href="<?= site_url('home/issueList'); ?>">Issues</a></li>
				<li id="testcases" class="loggedin"><a href="<?= site_url('home/testCase'); ?>">Test Cases</a></li>
              	<li id="newUser" class="loggedin"><a href="<?= site_url('home/newUser'); ?>">Create User</a></li>
            </ul>
			<div class="pull-right">
				<div class="btn-group loggedin">
				<a href="#" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
					<i class="icon-plus-sign icon-white"></i> Create issue <b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?= site_url('home/issueCreation'); ?>"><i class="icon-warning-sign"></i> Bug</a></li>
			          	<li><a href="<?= site_url('home/issueCreation'); ?>"><i class="icon-gift"></i> Change request</a></li>
			          	<li><a href="<?= site_url('home/issueCreation'); ?>"><i class="icon-info-sign"></i> Other</a></li>
						<li class="divider"></li>
			          	<li><a href="#"><i class="icon-chevron-right"></i> Excel import</a> <br /></li>
					</ul>
				</div>
				<div class="btn-group loggedin">
				<a href="#" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					<i class="icon-user icon-white"></i><?=' '.(isset($username)?$username:'');?> <b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#">Edit profile</a></li>
			          	<li><a href="#">Change project view</a></li>
			          	<li><a href="<?= site_url('home/createProject'); ?>">Create Project</a></li>
			          	<li class="divider"></li>
			          	<li><a href="<?= site_url('home/logout'); ?>">Logout</a> <br /></li>
					</ul>
				</div>
			</div>
			<?php 
			$attributes = array('class' => 'navbar-form pull-right visitor', 'id' => 'login');
			echo form_open('verifylogin', $attributes); ?>
			     <input type="text" class="span2" placeholder="username" id="username" name="username"/>
			     <input type="password" class="span2" placeholder="password" id="passowrd" name="password"/>
			     <input type="submit" class="btn btn-primary" value="Login"/>
		   </form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
</div>
<div id="message" class="container alert alert-success" style="display:<?=$this->session->flashdata('message') ? '' : 'none'; ?>;">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<?=$this->session->flashdata('message');?> </div>
<script>
	$('.<?=$hidemode;?>').hide();
</script>

