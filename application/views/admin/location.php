<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Info List</h4>
                    <a href="<?php echo base_url('admin/location/addNew'); ?>" title="Add New Location" style="float: right;" >
	                    <div class="alert alert-success">
						  <strong>Add New</strong>
						</div>
					</a>
                    <div class="data-tables">
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>#</th>
                                    <th>Name English</th>
                                    <th>Name Araic</th>                                    
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php $i = 0;
                            	foreach ($location as $key => $value) {
                            		$i++;
                            		?>
                            		<tr>
	                                    <td><?php echo $i; ?></td>
	                                    <td><?php echo $value->fld_name; ?></td>
	                                    <td><?php echo $value->fld_name_ar; ?></td>
	                                    <td><?php echo $value->fld_create_date; ?></td>
	                                    <td>
	                                    	<?php
	                                    	if( $value->fld_status == '1' ){
	                                    		?>
													<div class="alert alert-success">
													  <strong>Active</strong>
													</div>
	                                    		<?php 
	                                    	}else{
	                                    		?>
	                                    		<div class="alert alert-danger">
												  <strong>Inactive</strong>
												</div>
	                                    		<?php
	                                    	}
	                                    	?></td>
	                                    <td>
	                                    	<a class="alert alert-success" href="<?php echo base_url('admin/location/edit/'.$value->fld_id); ?>" title="Edit Info"> <i class="fa fa-pencil-square-o"></i></a>
	                                    	
	                                    	<a class="alert alert-danger data-trash " data-url="<?php echo base_url('admin/location/delete/');?>" data-id = "<?php echo $value->fld_id; ?>" title="Delete User Data"> <i class="fa fa-trash"></i></a>
	                                    	
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