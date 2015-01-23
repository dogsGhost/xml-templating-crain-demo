<?php

function get_job_counts() {
    global $config;

    // get the xml from the xml file
    $xml = simplexml_load_file($config['xml_src']);
    if (!$xml) {
        throw new Exception("Error Processing XML");
    }

    // have an array to store location counts
    $jobLocs = [];

    // loop through the xml
    foreach ($xml->item as $item) {
        foreach ($item as $key => $value) {
            if ($key == 'JobCity') {
                $string = (string)$value;
                //check if item's jobLoc is an array key
                if ( $jobLocs[$string] ) {
                    // if it is, increment its val by 1
                    $jobLocs[$string]++;
                } else {
                    // if not, set it as a key with val of 1
                    $jobLocs[$string] = 1;
                }
            }
        }
    }

    return $jobLocs;
}

try {

    $data = get_job_counts(); ?>

    <table>
        <thead>
            <tr>
                <th>Location</th>
                <th>Number of jobs</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data as $key => $value) {
                echo "<tr><td>{$key}</td><td>{$value}</td></tr>";
            }
            ?>
        </tbody>
    </table>

<?php
} catch (Exception $e) {
    echo "Caught exception: {$e->getMessage()} <br>";
}