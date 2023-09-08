<?php

$imagens = glob('./zzz/*');

$santosArray = [];

foreach($imagens as $oldImagePath){

    $image = explode('/', $oldImagePath,3)[2];

    $slug = str_replace('.jpg', '', $image);

    $name = strtoupper(str_replace('_', ' ', $slug));

    $santosArray[] = [
        'nome' => $name,
        'slug' => $slug,
        'imagem' => $image
    ];
}

file_put_contents('./teste.json',json_encode($santosArray));

echo PHP_EOL;