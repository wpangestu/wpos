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
        <h2 style="margin-top:0px">Item <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Barcode <?php echo form_error('barcode') ?></label>
            <input type="text" class="form-control" name="barcode" id="barcode" placeholder="Barcode" value="<?php echo $barcode; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Name <?php echo form_error('name') ?></label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $name; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Category Id <?php echo form_error('category_id') ?></label>
            <input type="text" class="form-control" name="category_id" id="category_id" placeholder="Category Id" value="<?php echo $category_id; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Unit Id <?php echo form_error('unit_id') ?></label>
            <input type="text" class="form-control" name="unit_id" id="unit_id" placeholder="Unit Id" value="<?php echo $unit_id; ?>" />
        </div>
	    <div class="form-group">
            <label for="bigint">Price <?php echo form_error('price') ?></label>
            <input type="text" class="form-control" name="price" id="price" placeholder="Price" value="<?php echo $price; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Stock <?php echo form_error('stock') ?></label>
            <input type="text" class="form-control" name="stock" id="stock" placeholder="Stock" value="<?php echo $stock; ?>" />
        </div>
	    <input type="hidden" name="item_id" value="<?php echo $item_id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('item') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>