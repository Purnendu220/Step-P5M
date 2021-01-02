<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Report List</h4>
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
                                    <th>Total Surgery</th>
                                    <th>Total Time</th>
                                    <th>Total Session</th>
                                    
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
                                        <td><?php echo $value->fld_total_surgery; ?></td>
                                        <td><?php echo $value->fld_total_time; ?></td>
	                                    <td>
                                         <?php 
                                         echo $count = $this->db->where('fld_user_id',$value->fld_id)->get('tbl_user_steps')->num_rows();
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