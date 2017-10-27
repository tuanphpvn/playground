<?php
//composer require erusev/parsedown

// 1) Register new hook github -> payLoadUrl = http://yoursite.com
// 2) Make this fill callable by github with path: http:://yoursite.com/githook/index.php

require_once 'vendor/autoload.php';

$json = file_get_contents('php://input');
file_put_contents('test.json', $json);
$payload = json_decode($json, true);

if (empty($json)) {
    header("HTTP/1.1 500 Internal Server Error");
    die('No data provided for parsing, payload invalid.');
}

if ($payload['ref'] !== 'refs/heads/master') {
    die('Ignored. Not master.');
}

$last_commit = array_pop($payload['commits']);

$modified = $last_commit['modified'];

$prefix = 'https://raw.githubusercontent.com/';
$repo = 'swader/autopush/'; # change here
$branch = 'master/';

$languages = [
    'en_EN' => 'en',
    'hr_HR' => 'hr'
];
$lvl = 2;

$folders = [];
foreach ($modified as $file) {
    $folder = explode('/', $file);
    $folder = implode('/', array_slice($folder, 0, -$lvl));
    $folders[] = $folder;
}
$folders = array_unique($folders);

foreach ($folders as $folder) {
    $fullFolderPath = $prefix.$repo.$branch.$folder.'/';

    $meta = getMeta($fullFolderPath);
    if (!$meta) {
        continue;
    }

    $content = '';
    foreach ($languages as $langpath => $key) {
        $url = $fullFolderPath.$langpath.'/final.md';
        $content .= "{:$key}".mdToHtml(getContent($url))."{:}";
    }
    if (!empty($content) && is_numeric($meta['id'])) {
        file_put_contents('/tmp/wpupdate', $content);
        exec('wp post update '.$meta['id'].' /tmp/wpupdate', $output);
        var_dump($output);
    }
}

function getContent(string $url): ?string {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url.'?nonce='.md5(microtime()));
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);

    $data = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($code != 200) {
        return null;
    }
    curl_close($ch);
    return $data;
}

function mdToHtml(string $text): string {
    $p = new Parsedown();
    $p->setUrlsLinked(true);
    return $p->parse($text);
}

function getMeta(string $folder): ?array {
    $data = getContent(trim($folder, '/').'/meta.json');
    if (!empty($data)) {
        return json_decode($data, true);
    }
    return null;
}