<?php
$this->load->view('templates/header', $title);
?>
<br/><br/><br/><br/><br/><br/><br/><br/><br/>
<div class="modal-dialog">
    <div class="modal-content">
        <form action="verify" method="post">
            <div class="modal-body">
                <h4>Welcome</h4><br/>
                <div class="col-lg-12">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">  
                    <input type="submit" name="login" class="form-control btn btn-primary" value="Sign In">
                </div>
            </div>
        </form>
    </div>
</div>
<?php
$this->load->view('templates/footer');
?>