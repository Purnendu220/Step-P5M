<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Info List</h4>
                    <a href="<?php echo base_url('admin/info/addNew'); ?>" title="Add New Info" style="float: right;" >
	                    <div class="alert alert-success">
						  <strong>Add New</strong>
						</div>
					</a>
                    <div class="data-tables">
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>#</th>
                                    <th>Title / Details</th>
                                    <th>Slug</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php $i = 0;
                            	foreach ($info as $key => $value) {
                            		$i++;
                            		?>
                            		<tr>
	                                    <td><?php echo $i; ?></td>
	                                    <td>
	                                    	<?php 
	                                    	if( $value->fld_title != "" ){
	                                    		echo $value->fld_title; 
	                                    	}else{
	                                    		?> <strong>Details : </strong> <?php echo $value->fld_details;
	                                    	} ?></td>
	                                    <td><?php echo $value->fld_slug; ?></td>
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
	                                    	<a class="alert alert-success" href="<?php echo base_url('admin/info/edit/'.$value->fld_id); ?>" title="Edit Info"> <i class="fa fa-pencil-square-o"></i></a>
	                                    	<?php 
	                                    	if( @$value->fld_id != '1' ){
	                                    	?>
	                                    	<a class="alert alert-danger data-trash " data-url="<?php echo base_url('admin/info/delete/');?>" data-id = "<?php echo $value->fld_id; ?>" title="Delete Info"> <i class="fa fa-trash"></i></a>
	                                    	<?php } ?>
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