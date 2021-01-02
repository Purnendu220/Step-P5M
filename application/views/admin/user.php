<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">User List</h4>
                    <!-- <a href="<?php echo base_url('admin/info/addNew'); ?>" title="Add New Info" style="float: right;" >
	                    <div class="alert alert-success">
						  <strong>Add New</strong>
						</div>
					</a> -->
                    <div class="data-tables">
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Location</th>
                                    <th>Total Surgery</th>
                                    <th>Total Time</th>
                                    <th>Date</th>
                                    <th>View</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php $i = 0;
                            	foreach ($users as $key => $value) {
                            		$i++;
                            		?>
                            		<tr>
	                                    <td><?php echo $i; ?></td>
	                                    <td><?php echo $value->fld_name; ?></td>
	                                    <td><?php echo $value->fld_phone; ?></td>
	                                    <td><?php echo $value->l_name; ?></td>
                                        <td><?php echo $value->fld_total_surgery; ?></td>
                                        <td><?php echo $value->fld_total_time; ?></td>
	                                    <td><?php echo $value->fld_create_date; ?></td>
	                                    <td>
                                            <a href="<?php echo base_url('admin/user/log/'.$value->fld_id); ?>" title="Edit Info">
                                        		<div class="alert alert-danger">
    											  <strong>View Log</strong>
    											</div>
                                            </a>
	                                    </td>
	                                    <td>
	                                    	<a class="alert alert-success" href="<?php echo base_url('admin/user/view/'.$value->fld_id); ?>" title="Edit Info"> <i class="fa fa-eye"></i></a>
	                                    	
	                                    	<a class="alert alert-danger data-trash " data-url="<?php echo base_url('admin/user/delete/');?>" data-id = "<?php echo $value->fld_id; ?>" title="Delete User Data"> <i class="fa fa-trash"></i></a>
	                                    	
	                                    </td>
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