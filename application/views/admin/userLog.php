<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">User Log</h4>
                    <a href="<?php echo base_url('admin/user'); ?>" title="Add New Info" style="float: right;" >
	                    <div class="alert alert-success">
						  <strong>Back</strong>
						</div>
					</a>
                    <div class="data-tables">
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>#</th>
                                    <th>UserName</th>
                                    <th>Location</th>
                                    <th>Device ID</th>
                                    <th>Device Type</th>
                                    <th>Date</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            	<?php $i = 0;
                            	foreach ($now as $key => $value) {
                            		$i++;
                            		?>
                            		<tr>
	                                    <td><?php echo $i; ?></td>
	                                    <td><?php echo $value->fld_user_name; ?></td>
	                                    <td><?php echo $value->fld_user_location; ?></td>
	                                    <td><?php echo $value->fld_device_id; ?></td>
                                        <td><?php echo $value->fld_device_type; ?></td>
	                                    <td><?php echo $value->fld_date; ?></td>
	                                    
	                                </tr>
                            		<?php 
                            	}
                            	?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>
</div>