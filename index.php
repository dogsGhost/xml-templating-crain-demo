<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>xml templating</title>
    <style>
        body { font: 1em/1.3 sans-serif; margin: 0 auto; width: 96%; max-width: 960px; }
        table { border-spacing: 0; border: 1px solid #333; }
        th, td { padding: 5px; border: 1px solid #333; text-align: right; }
        td + td, th + th { text-align: left; }
        p { max-width: 600px; }
    </style>
</head>
<body>

    <p>The below table is generated on page load by parsing a local xml file(<a href="jobs.xml">jobs.xml</a>) that has been generated from an <a href="https://rew12.ultipro.com/CAS1011/jobboard/ReqXML.aspx">xml feed</a>.
    A cron job could be set to generate this local file at set intervals, as well as the pages for the individual job postings. This protects the integrity of the site if the
    feed were to go down, and also allows for consistency across the site when interacting with the data regardless of
     when the site is querying it.</p>

<?php include('render.php'); ?>
<br>
<a href="<?php echo $config['target_dir']; ?>">See list of job postings</a>
</body>
</html>