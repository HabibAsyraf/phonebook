<?php $search_data = $this->phpsession->get("search_data"); ?>
<div align="center" style="width: 100%">
	<div class="form-group" style="width: 92%">
		<div class="col-md-6" align="left">
			<a href="#modalAddContact" data-toggle="modal" class="btn btn-success">Add Contact <span class="glyphicon glyphicon-plus"></span></a>
			<a target="_blank" href="<?php echo site_url('contact/excel_listing'); ?>" class="btn btn-primary">Export To Excel <span class="glyphicon glyphicon-file"></span></a>
		<a target="_blank" href="<?php echo site_url('contact/pdf_listing'); ?>" class="btn btn-danger">Export To PDF  <span class="glyphicon glyphicon-print"></span></a>
		</div>
		<form action="<?php echo site_url()?>/contact/search" method="POST">
			<div class="col-md-5">
				<input type="text" name="search_contact" class="form-control" value="<?php echo isset($search_data['search_contact']) ? $search_data['search_contact'] : '' ; ?>" />
			</div>
			<div class="col-md-1">
				<input type="submit" value="Search" class="form-control btn btn-default" />
			</div>
			<div class="col-md-6" align="right">
				&nbsp;
			</div>
		</form>
	</div>
	<div class="form-group">
		<table class="table table-hover table-bordered" style="background:#FFF; width:90%; font-size:small">
			<thead >
				<th style="width: 1%; text-align:center">No.</th>
				<th style="text-align:center">Name</th>
				<th style="width: 15%; text-align:center">Tel No.</th>
		        <th style="width: 15%; text-align:center">Created Date</th>
		        <th style="width: 15%; text-align:center">Updated Date</th>
		        <th style="width: 1%; text-align:center">Action</th>
			</thead>
			<tbody>
				<?php
				if($query->num_rows() > 0)
				{
					$a=1;
					foreach ($query->result() as $i => $contact_item)
					{
						?>
						<tr style="text-align:center">
							<td style="vertical-align:middle"><?php echo $a; ?></td>
					    	<td style="text-align:left; vertical-align:middle"><?php echo $contact_item->name; ?></td>
							<td style="vertical-align:middle"><?php echo $contact_item->tel_no; ?></td>
							<td style="vertical-align:middle"><?php echo date("d-F-Y", strtotime($contact_item->create_date)); ?></td>
							<td style="vertical-align:middle"><?php echo date("d-F-Y", strtotime($contact_item->update_date)); ?></td>
					    	<td style="vertical-align:middle">
								<div class="btn-group">
									<a class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Action <span class="glyphicon glyphicon-menu-down"></span>
									</a>
									<div class="dropdown-menu">
										<a class="btn btn-primary form-control" href="#modalUpdateContact<?php echo $contact_item->id; ?>" data-toggle="modal">Update</a>
										<a class="btn btn-danger form-control" href="#modalDeleteContact<?php echo $contact_item->id; ?>" data-toggle="modal">Delete</a>
									</div>
		                     	</div>
				    		</td>
						</tr>
						<?php 
						$a++;
					}
				}
				else
				{
					?>
					<tr>
				    	<td style="font-weight: bold; text-align: center; color: red" colspan="6">No Data</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
		<?php
		echo $pagination;
		?>
	</div>
</div>
<!-- Add Meeting Modal-->
<div id="modalAddContact" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add New Contact</h4>
			</div>
			<form action="<?php echo site_url()?>/contact/create" method="post" name="form" id="add-form">
			<div class="modal-body">
				<fieldset>
				    <div class="form-group" align="left">
				        <label class="col-md-3">Name</label>
				        <label class="col-md-1">:</label>
				        <div class="col-md-8"><input name="name" type="text" class="form-control"  placeholder="Example: Jack Sparrow"/></div>
				    </div>
				    <div class="form-group" align="left">
				        <label class="col-md-3">Tel No.</label>
				        <label class="col-md-1">:</label>
				        <div class="col-md-8"><input name="tel_no" type="text" class="form-control"  placeholder="Example: 012-123456"/></div>
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
foreach ($query->result() as $i => $contact_item)
{
	?>
	<div id="modalUpdateContact<?php echo $contact_item->id; ?>" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Update Contact</h4>
				</div>
				<form action="<?php echo site_url()?>/contact/create" method="POST" />
					<input name="id" type="hidden" value="<?php echo $contact_item->id; ?>"/>
					<div class="modal-body">
						<fieldset>
						    <div class="form-group" align="left">
						        <label class="col-md-3">Name</label>
						        <label class="col-md-1">:</label>
						        <div class="col-md-8">
						        	<input name="name" type="text" class="form-control"  placeholder="Example: Jack Sparrow" value="<?php echo $contact_item->name ?>"/>
					        	</div>
						    </div>
						    <div class="form-group" align="left">
						        <label class="col-md-3">Tel No.</label>
						        <label class="col-md-1">:</label>
						        <div class="col-md-8">
						        	<input name="tel_no" type="text" class="form-control"  placeholder="Example: 123456789" value="<?php echo $contact_item->tel_no ?>"/>
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
foreach ($query->result() as $i => $contact_item)
{
	?>
	<div id="modalDeleteContact<?php echo $contact_item->id; ?>" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete Contact</h4>
				</div>
				
				<div class="modal-body">
					<fieldset>
						<h4>Are you sure?</h4>
				    </fieldset>
				</div>
				
				<div class="modal-footer">
					<a class="btn btn-danger btn-md" href="<?php echo site_url();?>/contact/remove/<?php echo urlencode(base64_encode($contact_item->id . "###contact/listing")); ?>" title="Delete">DELETE</a>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>
<!--End Delete Modal-->