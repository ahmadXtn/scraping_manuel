<?php
set_time_limit(36000);

ini_set('xdebug.var_display_max_children', '-1');
ini_set('xdebug.var_display_max_data', '-1');
ini_set('xdebug.var_display_max_depth', '-1');

require __DIR__ . '/vendor/autoload.php';
require_once 'lib_fn.php';

use Knp\Snappy\Pdf;

$options = [
    'enable-javascript' => true,
    'javascript-delay' => 2500,
    'no-stop-slow-scripts' => true,
    'lowquality' => false,
    'enable-external-links' => true,
    'enable-internal-links' => true,
    'page-height' => 550,
    'page-size' => "A4",
    'page-width' => 400,
];


$bookId = $argv[1];
$baseUrl = "https://educadhoc.hachette-livre.fr/extract/complet/$bookId/show-page/";

createBookFolder($bookId);


//$json = json_decode(file_get_contents($jsonurl), true);
//$pages = $json['pages'];


$snappy = new Pdf('C://"Program Files"/wkhtmltopdf/bin/wkhtmltopdf.exe');

//$snappy->setOptions($options);

$pages = getPages($bookId);
echo getBookInfo($bookId)['pages_count'] . ' to download' . PHP_EOL;
foreach ($pages as $index => $val) {
    try {
        $out = $snappy->getOutput($baseUrl . $val, $options);
        file_put_contents('download/' . getBookInfo($bookId)['title'] . "/$index.pdf", $out);
    } catch (Exception $err) {
        echo $err;
        continue;
    }
}
echo "complete" . PHP_EOL;
//file_put_contents('download/file.pdf', $pdf);

