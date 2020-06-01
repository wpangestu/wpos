<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Customer <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Id Customer <?php echo form_error('id_customer') ?></label>
            <input type="text" class="form-control" name="id_customer" id="id_customer" placeholder="Id Customer" value="<?php echo $id_customer; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Name Customer <?php echo form_error('name_customer') ?></label>
            <input type="text" class="form-control" name="name_customer" id="name_customer" placeholder="Name Customer" value="<?php echo $name_customer; ?>" />
        </div>
	    <div class="form-group">
            <label for="enum">Gender <?php echo form_error('gender') ?></label>
            <input type="text" class="form-control" name="gender" id="gender" placeholder="Gender" value="<?php echo $gender; ?>" />
        </div>
	    <div class="form-group">
            <label for="address">Address <?php echo form_error('address') ?></label>
            <textarea class="form-control" rows="3" name="address" id="address" placeholder="Address"><?php echo $address; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="varchar">Phone <?php echo form_error('phone') ?></label>
            <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" value="<?php echo $phone; ?>" />
        </div>
	    <div class="form-group">
            <label for="timestamp">Create At <?php echo form_error('create_at') ?></label>
            <input type="text" class="form-control" name="create_at" id="create_at" placeholder="Create At" value="<?php echo $create_at; ?>" />
        </div>
	    <div class="form-group">
            <label for="timestamp">Update At <?php echo form_error('update_at') ?></label>
            <input type="text" class="form-control" name="update_at" id="update_at" placeholder="Update At" value="<?php echo $update_at; ?>" />
        </div>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('customer') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>