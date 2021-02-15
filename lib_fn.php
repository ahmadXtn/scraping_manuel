<?php
//$bookData = 'https://educadhoc.hachette-livre.fr/api/book-data.json?book_id=4131&book_type=extract';

require_once 'init.php';

function getBookInfo($id): array
{
    $completJson = "https://educadhoc.hachette-livre.fr/api/extract/$id/complet.json";

    $json = json_decode(file_get_contents($completJson), true);
    return [
        'pages_count'=>$json['pages_count'],
        'id' => $json['id'],
        'title' => $json['title'],
        'bookDataUrl' => "https://educadhoc.hachette-livre.fr/api/book-data.json?book_id={$json['id']}&book_type=extract"
    ];
}



function getPages($id)
{
    $json=json_decode(file_get_contents(getBookInfo($id)['bookDataUrl']),true);

    return $json['pages'];

}

function createBookFolder($id){
    if (!file_exists(DOWNLOAD_FOLDER.'\\'.getBookInfo($id)['title'])) {
        mkdir("download/".getBookInfo($id)['title'], 0777, true);
        echo  "folder created ".PHP_EOL;
    }
    else {
        echo 'folder exist' .PHP_EOL;
        die();
    }
}

