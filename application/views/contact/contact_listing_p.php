<page style="font-size: 12px">
	<h1><?php echo $title; ?></h1>
	<hr/>
	<table style="width: 100%" cellspacing="0">
		<tr>
			<th style="background-color: lightgrey; width: 5%; border: solid 1px; text-align: center">No.</th>
			<th style="background-color: lightgrey; width: 35%; border: solid 1px; text-align: center">Name</th>
			<th style="background-color: lightgrey; width: 20%; border: solid 1px; text-align: center">Tel No.</th>
			<th style="background-color: lightgrey; width: 20%; border: solid 1px; text-align: center">Create Date</th>
			<th style="background-color: lightgrey; width: 20%; border: solid 1px; text-align: center">Update Date</th>
		</tr>
		<?php
		if($query->num_rows() > 0)
		{
			$count=1;
			foreach($query->result() as $row)
			{
				?>
				<tr>
					<td style="width: 5%; border: solid 1px; border-top: solid 0px; text-align: center"><?php echo $count; ?></td>
					<td style="width: 35%; border: solid 1px; border-top: solid 0px;"><?php echo $row->name; ?></td>
					<td style="width: 20%; border: solid 1px; border-top: solid 0px;"><?php echo $row->tel_no; ?></td>
					<td style="width: 20%; border: solid 1px; border-top: solid 0px; text-align: center"><?php echo date("d-F-Y", strtotime($row->create_date)); ?></td>
					<td style="width: 20%; border: solid 1px; border-top: solid 0px; text-align: center"><?php echo date("d-F-Y", strtotime($row->update_date)); ?></td>
				</tr>
				<?php
				$count++;
			}
		}
		else
		{
			?>
			<tr>
				<td style="width: 100%; border: solid 1px; border-top: solid 0px; text-align: center" colspan="5">No data</td>
			</tr>
			<?php
		}
		?>
	</table>
</page>