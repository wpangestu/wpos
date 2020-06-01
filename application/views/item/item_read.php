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
        <h2 style="margin-top:0px">Item Read</h2>
        <table class="table">
	    <tr><td>Barcode</td><td><?php echo $barcode; ?></td></tr>
	    <tr><td>Name</td><td><?php echo $name; ?></td></tr>
	    <tr><td>Category Id</td><td><?php echo $category_id; ?></td></tr>
	    <tr><td>Unit Id</td><td><?php echo $unit_id; ?></td></tr>
	    <tr><td>Price</td><td><?php echo $price; ?></td></tr>
	    <tr><td>Stock</td><td><?php echo $stock; ?></td></tr>
	    <tr><td>Created</td><td><?php echo $created; ?></td></tr>
	    <tr><td>Updated</td><td><?php echo $updated; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('item') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>