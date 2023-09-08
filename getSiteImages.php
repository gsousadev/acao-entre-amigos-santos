<?php

$baseUrl = "https://cruzterrasanta.com.br";
$initialUrl = $baseUrl . "/lista-completa-de-santos-e-icones-catolicos";
$html = file_get_contents($initialUrl);

$dom = new domDocument;
@$dom->loadHTML($html);
$dom->preserveWhiteSpace = false;
$lisks = $dom->getElementsByTagName('a');

$outputLinks = [];
$outputImages = [];

echo "# Fazendo leitura dos links do site"  . PHP_EOL;

foreach ($lisks as $link) {
    if (!empty($link->getAttribute('class') == "lista-completa-santos__group-list-link")) {
        $outputLinks[] = $baseUrl . $link->getAttribute('href');
    }
}
echo "# Quantidade de link encontrados para páginas de santos ..." . count($outputLinks)  . PHP_EOL;
echo "# Acessando links de paginas para capturar locais de imagens de santos ..."  . PHP_EOL;
$count = 1;

foreach ($outputLinks as $link) {
    try{

 
    $htmlLinks = file_get_contents($link);
    $domLinks = new domDocument;
    @$domLinks->loadHTML($htmlLinks);
    $domLinks->preserveWhiteSpace = true;
    $images = $domLinks->getElementsByTagName('img');

        foreach ($images as $image) {
            if (!empty($image->getAttribute('class') == "saint-summary__picture")) {
                $linkToSave = $baseUrl . $image->getAttribute('src');
                $outputImages[] = $linkToSave;
                echo "# Gravando local de imagem " . $count . ": " . $linkToSave  . PHP_EOL;
                $count++;
            }
        }   
    }catch(Exception $e){
        sleep(10);
        continue;
    }
}

echo "# Quantidade de locais de imagens encontradas ..." . count($outputImages)  . PHP_EOL;
echo "# Acessando locais de imagens para fazer download ..." . PHP_EOL;

$count = 1;

$dir = "temp";

if (!file_exists($dir)) {
    mkdir('temp', 0777, true);
}

foreach ($outputImages as $imageUrl) {
    try{
        $url = explode("/", $imageUrl);
        $name = $url[count($url) - 1];
        $fp = fopen($dir  . "/" . $name, 'wb');

        $ch = curl_init($imageUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US)");
        $raw_data = curl_exec($ch);
        curl_close($ch);
        fwrite($fp, $raw_data);
        fclose($fp);

        echo "# Download de imagem " . $count . " concluído: " . $name  . PHP_EOL;

        $count++;
    }catch(Exception $e){
        sleep(10);
        continue;
    }
}
