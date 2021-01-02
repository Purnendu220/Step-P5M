<!-- page title area end -->
<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-6 col-ml-12">
            <div class="row">
                <!-- Textual inputs start -->
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">View User Data</h4>
                            <form action="" method="POST" enctype='multipart/form-data'>
                            <!-- <p class="text-muted font-14 mb-4">Here are examples of <code>.form-control</code> applied to each textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p> -->
                            <div class="form-group">
                                <label for="example-text-input" class="col-form-label">Name</label>
                                <input class="form-control" type="text" value="<?php echo $now->fld_name; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="example-text-input" class="col-form-label">Phone</label>
                                 <input class="form-control" type="text" value="<?php echo $now->fld_phone; ?>" readonly >
                            </div>
                            <div class="form-group">
                                <label for="example-text-input" class="col-form-label">Location</label>
                                 <input class="form-control" type="text" value="<?php echo $now->l_name; ?>" readonly>
                            </div>
                             <div class="form-group">
                                <label for="example-text-input" class="col-form-label">Time contribute</label>
                                 <input class="form-control" type="text" value="<?php echo $now->fld_total_time; ?>" readonly>
                            </div>
                            <div class="form-check">
                                <!-- <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Submit</button> -->
                                <a href="<?php echo base_url('admin/info') ?>" class="btn btn-warning mt-4 pr-4 pl-4" style="float: right;">Cancel</a>
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