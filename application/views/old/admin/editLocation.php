<!-- page title area end -->
<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-6 col-ml-12">
            <div class="row">
                <!-- Textual inputs start -->
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Edit Location</h4>
                            <?php  // print_r($now->fld_title); ?>
                            <form action="<?php echo base_url('admin/location/saveold/'.$now->fld_id); ?>" method="POST" enctype='multipart/form-data'>
                            <!-- <p class="text-muted font-14 mb-4">Here are examples of <code>.form-control</code> applied to each textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p> -->
                            <div class="form-group">
                                <label for="example-text-input" class="col-form-label">Location Name English</label>
                                <input class="form-control" type="text" value="<?php echo $now->fld_name; ?>" placeholder="Location Name English"  id="fld_name" name="fld_name" required>
                            </div>
                             <div class="form-group">
                                <label for="example-text-input" class="col-form-label">Location Name Arabic</label>
                                <input class="form-control" type="text" value="<?php echo $now->fld_name_ar; ?>" placeholder="Location Name Arabic"  id="fld_name_ar" name="fld_name_ar" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Status *</label>
                                <select class="form-control" id="fld_status" name="fld_status" required style="height: calc(3.25rem + 2px);">
                                    <option value="">(-- Status --)</option>
                                    <option value="1" <?php if( $now->fld_status == '1' ) {?> selected <?php } ?> >Active</option>
                                    <option value='0' <?php if( $now->fld_status == '0' ) {?> selected <?php } ?>  >Inactive</option>
                                </select>
                            </div>
                            <div class="form-check">
                                <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Submit</button>
                                <a href="<?php echo base_url('admin/location') ?>" class="btn btn-warning mt-4 pr-4 pl-4" style="float: right;">Cancel</a>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Textual inputs end -->
            </div>
        </div>
    </div>
</div>