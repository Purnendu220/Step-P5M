<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Config Data</h4>
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
                                    <th>Title</th>
                                    <th>Slug</th>
                                    <th>value</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php $i = 0;
                            	foreach ($config as $key => $value) {
                            		$i++;
                            		?>
                            		<tr>
	                                    <td><?php echo $i; ?></td>
	                                    <td><?php echo $value->fld_name; ?></td>
	                                    <td><?php echo $value->fld_slug; ?></td>
	                                    <td><?php echo $value->fld_value; if( $value->fld_slug =='one_surgery'){ echo " ( Minute )"; } if( $value->fld_slug =='session_complete' && $value->fld_value == 'RUN'){ echo " ".$value->fld_option; }?></td>
	                                    <td>
                                            <?php 
                                            if( $value->fld_slug =='session_complete' ){
                                                ?>
                                                <a title="Change Status" href="<?php echo base_url().'admin/config/updateStatus/'.$value->fld_value;?>"><div class="alert alert-danger">
                                                  <strong>Change Status</strong>
                                                </div></a>
                                                <?php
                                                 if( $value->fld_value =='RUN'){ ?>
                                                  <a title="Change Option" href="<?php echo base_url().'admin/config/updateOption/'.$value->fld_option;?>"><div class="alert alert-danger">
                                                  <strong>Change Option</strong>
                                                </div></a>
                                                 <?php 
                                                 }
                                            }
                                            ?>
                                                
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