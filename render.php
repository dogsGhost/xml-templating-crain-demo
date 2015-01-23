<?php

$config = [
    'xml_feed' => 'https://rew12.ultipro.com/CAS1011/jobboard/ReqXML.aspx',
    'xml_src' => 'jobs.xml',
    'tmpl_src' => 'template.html',
    'target_dir' => 'output/'
];

// create a local xml file from the feed. ideally we would set a cron job to do this at set intervals.
// This allows for consistency across the site when interacting with the data
// regardless of when the site is querying it.

$feed = file_get_contents($config['xml_feed']);
if ($feed) {
  $fh = fopen($config['xml_src'], 'w+'); //create new file if not exists
  fwrite($fh, $feed) or die("Failed to write contents to new file"); //write contents to new XML file
  fclose($fh) or die("failed to close stream resource"); //close resource stream
} else {
  die("Failed to read contents of feed at {$config['xml_feed']}");
}

function render_templated_files() {
    global $config;

    // get the xml from the xml file
    $xml = simplexml_load_file($config['xml_src']);
    if (!$xml) {
        throw new Exception("Error Processing XML");
    }

    // get the html from the template
    $template = file_get_contents($config['tmpl_src']);

    // for each item in the xml we want to:
    foreach ($xml->item as $item) {
        $html = $template;

        // take the xml value and replace the corresponding placeholder text in the template
        foreach ($item as $key => $value) {
            // Use Req # to create unqiue pages.
            if ($key == 'RequisitionNumber') {
                $filename = "{$config['target_dir']}job-{$value}.html";
            }
            $search = '{{' . $key . '}}';
            $html = str_ireplace($search, $value, $html);
        }

        // write the new html string to a file named for the item req #
        $file = fopen($filename, 'wb') or die('Cannot open file.');
        fwrite($file, $html);
        fclose($file);
    }
}

try {
    render_templated_files();
} catch (Exception $e) {
    echo "Caught exception: {$e->getMessage()} <br>";
}

require( 'count.php' );

/*

cron command to run this as a cron job everyday at 6 AM:
0 6 * * * /usr/bin/wget http://www.sitename.com/render.php

*/