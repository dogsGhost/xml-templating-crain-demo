<?php

$config = [
    'xml_src' => 'https://rew122.ultipro.com/CAS1011/jobboard/ReqXML.aspx',
    'tmpl_src' => 'template.html',
    'target_dir' => 'output/'
];

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



/*

cron command to run this as a cron job everyday at 6 AM:
0 6 * * * /usr/bin/wget http://www.sitename.com/render.php

*/