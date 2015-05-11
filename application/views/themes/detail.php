<!DOCTYPE html>
<html>
    <head>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/default/css/normalize.css">

        <meta name="robots" content="noindex">
        
        <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

        <!--Bootstrap-->
        <link href="<?php echo base_url(); ?>assets/themes/default/css/bootstrap.css" rel="stylesheet" type="text/css" />

        <?php require 'head.php'; ?> 
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> 

        <!--Custom styling-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/default/css/detail.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/default/css/main.css">
    </head>
    <body>        
        <?php echo $output; ?>
    </body>
</html>