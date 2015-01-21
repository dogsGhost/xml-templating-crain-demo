<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>xml templating</title>
    <style>
        body { font: 1em/1.3 sans-serif; }
        table { border-spacing: 0; border: 1px solid #333; }
        th, td { padding: 5px; border: 1px solid #333; text-align: right; }
        td + td, th + th { text-align: left; }
    </style>
</head>
<body>
<?php include('render.php'); ?>
<a href="<?php echo $config['target_dir']; ?>">See all generated files</a>
</body>
</html>