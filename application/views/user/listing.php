<div align="left" style="width: 90%"><a href="#modalAddUser" data-toggle="modal" class="btn btn-success">Add User</a></div>
</br>

<table class="table table-bordered" style="background:#FFF; width:90%; font-size:small">
	<thead>
		<th style="width: 1%; text-align:center">No.</th>
		<th style="text-align:center">Username</th>
		<th style="width: 15%; text-align:center">Password</th>
		<th style="text-align:center">Name</th>
        <th style="width: 15%; text-align:center">Created Date</th>
        <th style="width: 15%; text-align:center">Updated Date</th>
        <th style="width: 1%; text-align:center">Action</th>
	</thead>
	<tbody>
		<?php
		if(!empty($user))
		{
			foreach ($user as $i => $user_item)
			{
				?>
				<tr style="text-align:center">
					<td style="vertical-align:middle"><?php echo $rows_number; ?></td>
			    	<td style="text-align:left; vertical-align:middle"><?php echo $user_item->username; ?></td>
                    <td style="vertical-align:middle"><?php echo $user_item->password; ?></td>
                    <td style="text-align:left; vertical-align:middle"><?php echo $user_item->name; ?></td>
                    <td style="vertical-align:middle"><?php echo mdate($datestring, mysql_to_unix($user_item->create_date)); ?></td>
                    <td style="vertical-align:middle"><?php echo mdate($datestring, mysql_to_unix($user_item->update_date)); ?></td>
			    	<td style="vertical-align:middle">
                    	<div class="btn-group">
                                <a class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action <span class="glyphicon glyphicon-menu-down"></span>
                                </a>
                                <div class="dropdown-menu">
                            		<a class="btn btn-primary form-control" href="#modalUpdateUser<?php echo $user_item->id; ?>" data-toggle="modal">Update</a>
                            		<a class="btn btn-danger form-control" href="#modalDeleteUser<?php echo $user_item->id; ?>" data-toggle="modal">Delete</a>
                                </div>
                     	</div>
		    		</td>
				</tr>
				<?php 
				$rows_number++;
			}
		}
		else
		{
			?>
			<tr>
		    	<td style="font-weight: bold; text-align: center; color: red" colspan="7">No Data</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
<?php
echo $this->pagination->create_links();
?>
<!-- Add Meeting Modal-->
<div id="modalAddUser" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add New User</h4>
			</div>
			<?php echo validation_errors(); ?>
			<?php echo form_open('user/create'); ?>
			<div class="modal-body">
				<fieldset>
					<div class="form-group" align="left">
				        <label class="col-md-3">Username</label>
				        <label class="col-md-1">:</label>
				        <div class="col-md-8"><input name="username" id="username" type="text" class="form-control"  placeholder="Unique Name"/></div>
				    </div>
				    <div class="form-group" align="left">
				        <label class="col-md-3">Password</label>
				        <label class="col-md-1">:</label>
				        <div class="col-md-8"><input name="password" type="password" class="form-control"  placeholder="Password"/></div>
				    </div>
				    <div class="form-group" align="left">
				        <label class="col-md-3">Name</label>
				        <label class="col-md-1">:</label>
				        <div class="col-md-8"><input name="name" type="text" class="form-control"  placeholder="Full Name"/></div>
				    </div>
			    </fieldset>
			</div>
			<div class="modal-footer"><input type="submit" name="add" value="SAVE" class="form-control btn btn-success"></div>
			</form>
		</div>
	</div>
</div>
<!--End Add Modal-->

<!-- Update Meeting Modal-->
<?php
foreach($user as $i => $user_item)
{
	?>
	<div id="modalUpdateUser<?php echo $user_item->id; ?>" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Update User</h4>
				</div>
				<?php echo validation_errors(); ?>
				<?php echo form_open('user/update'); ?>
					<input name="id" type="hidden" value="<?php echo $user_item->id; ?>"/>
					<div class="modal-body">
						<fieldset>
							<div class="form-group" align="left">
						        <label class="col-md-4">Username</label>
						        <label class="col-md-1">:</label>
						        <div class="col-md-7">
						        	<input name="username" type="text" class="form-control"  placeholder="Unique Name" value="<?php echo $user_item->username ?>"/>
					        	</div>
						    </div>
						    <div class="form-group" align="left">
						        <label class="col-md-4">Name</label>
						        <label class="col-md-1">:</label>
						        <div class="col-md-7">
						        	<input name="name" type="text" class="form-control"  placeholder="Full Name" value="<?php echo $user_item->name ?>"/>
					        	</div>
						    </div>
                            
						    <div class="form-group" align="left">
						        <label class="col-md-12"><input name="change" type="checkbox" id="ch<?php echo $user_item->id; ?>" onChange="checked_password(<?php echo $user_item->id; ?>);" value="<?php echo $user_item->id; ?>"/> Change Password</label>
						    </div>
						    <div class="form-group" align="left">
						        <label class="col-md-4">Current Password</label>
						        <label class="col-md-1">:</label>
						        <div class="col-md-7">
						        	<input name="current_password" type="password" id="current_password<?php echo $user_item->id; ?>" class="form-control"  placeholder="Current Password" disabled/>
					        	</div>
						    </div>
                            <div class="form-group" align="left">
						        <label class="col-md-4">New Password</label>
						        <label class="col-md-1">:</label>
						        <div class="col-md-7">
						        	<input name="new_password" type="password" id="new_password<?php echo $user_item->id; ?>" class="form-control"  placeholder="New Password" disabled/>
					        	</div>
						    </div>
                            <div class="form-group" align="left">
						        <label class="col-md-4">Retype Password</label>
						        <label class="col-md-1">:</label>
						        <div class="col-md-7">
						        	<input name="retype_password" type="password" id="retype_password<?php echo $user_item->id; ?>" class="form-control"  placeholder="Retype Password" disabled/>
					        	</div>
						    </div>
					    </fieldset>
					</div>
					<div class="modal-footer"><input type="submit" name="add" value="SAVE" class="form-control btn btn-primary"></div>
				</form>
			</div>
		</div>
	</div>
	<?php
}
?>
<!--End Update Modal-->

<!-- Delete Meeting Modal-->
<?php
foreach($user as $i => $user_item)
{
	?>
	<div id="modalDeleteUser<?php echo $user_item->id; ?>" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete User</h4>
				</div>
				<?php echo validation_errors(); ?>
				<?php echo form_open('user/remove'); ?>
				<input name="id" type="hidden" value="<?php echo $user_item->id; ?>"/>
				<div class="modal-body">
					<fieldset>
						<h4>Are you sure?</h4>
				    </fieldset>
				</div>
				<div class="modal-footer"><input type="submit" name="add" value="DELETE" class="form-control btn btn-danger"></div>
				</form>
			</div>
		</div>
	</div>
	<?php
}
?>
<!--End Delete Modal-->
<script type="text/javascript">
$(document).ready(function()
{
	
});

function checked_password(id)
{
	var checked = document.getElementById("ch"+id).checked;
	
	if(checked === true)
	{
		document.getElementById("current_password"+id).disabled = false;
		document.getElementById("new_password"+id).disabled = false;
		document.getElementById("retype_password"+id).disabled = false;
	}
	else if(checked === false)
	{
		document.getElementById("current_password"+id).disabled = true;
		document.getElementById("new_password"+id).disabled = true;
		document.getElementById("retype_password"+id).disabled = true;
	}
}
</script>