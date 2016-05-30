<?php
$this->load->view('templates/header', $title);
?>
<br/><br/><br/><br/><br/><br/><br/>
<div class="modal-dialog" id="div_login">
    <div class="modal-content">
        <form action="verify" method="post" class="form_horizontal">
            <div class="modal-body">
                <h4>Log In</h4>
                <?php get_msg(true); ?>
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Username">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="submit" name="login" class="form-control btn btn-primary" value="Sign In">
                </div>
                <p>Create New Account? <a id="to_register" href="#">Create New</a></p>
            </div>
        </form>
    </div>
</div>

<div class="modal-dialog" id="div_register" style="display: none">
	<div class="modal-content">
		<form action="register" method="post" class="form_horizontal">
			<div class="modal-body">
				<h4>Register</h4>
				<?php get_msg(true); ?>
				<div class="form-group">
					<input type="text" name="name" class="form-control" placeholder="Fullname">
				</div>
				<div class="form-group">
					<input type="text" name="username" class="form-control" placeholder="Username">
				</div>
				<div class="form-group">
					<input type="password" name="password" class="form-control" placeholder="Password">
				</div>
				<div class="form-group">
					<input type="submit" name="login" class="form-control btn btn-primary" value="Submit">
				</div>
				<p>Already a member ? <a id="to_login" href="#">Log In</a></p>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function()
{
	$('#to_register').on('click', function()
	{
		$('#div_login').fadeOut().css('display', 'none');
		$('#div_register').fadeIn().css('display', '');
	});
	
	$('#to_login').on('click', function()
	{
		$('#div_login').fadeIn().css('display', '');
		$('#div_register').fadeOut().css('display', 'none');
	});
});
</script>
<?php
$this->load->view('templates/footer');
?>