<?php

require_once __DIR__.'/../trim-whitespace.php';

function human_filesize($bytes, $decimals = 2) {
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

function test($name='?', $string, $runs=100, $opts=[]) {
    if (!is_int($runs) || $runs < 1 || $runs > 10000) {
        throw "Can only test between 1 and 10000 runs.";
    }
    $test = '';
    $start = microtime(true);
    for ($i=0; $i < $runs; $i++) {
        $test = trimWhitespace($string, $opts);
    }
    $mean = round((microtime(true) - $start) / $runs * 1000, 3);
    $reduction = round((1 - strlen($test) / strlen($string)) * 100, 2);

    return str_pad($name, 25) .
        str_pad($mean.'ms', 25) .
        str_pad($reduction.'%', 25) .
        "\n";
}

function testGroup($title='Unknown test', $string, $runs=100) {
    $size = human_filesize(strlen($string));
    $fullTitle = "$title ($size, x$runs)";
    echo "==== $fullTitle\n\n";

    echo str_pad('', 25) .
        str_pad('Mean time', 25) .
        str_pad('Size reduction', 25) .
        "\n";
    echo test('All features on', $string, $runs);
    echo test('`leading`    off', $string, $runs, ['leading'=>false]);
    echo test('`inside`     off', $string, $runs, ['inside'=>false]);
    echo test('`blankLines` off', $string, $runs, ['blankLines'=>false]);
    echo "\n";
}

if (PHP_SAPI !== 'cli') echo "<pre>\n";

$fragment = file_get_contents(__DIR__.'/data/fragment.html');
$casterman = file_get_contents(__DIR__.'/data/casterman.html');
$yahoo = file_get_contents(__DIR__.'/data/yahoo.html');
$htmlspec = file_get_contents(__DIR__.'/data/htmlspec.html');

echo "\n";
testGroup('HTML fragment', $fragment, 100);
testGroup('Unminified HTML page', $casterman, 100);
testGroup('Yahoo Homepage', $yahoo, 100);
testGroup('HTML Spec', $htmlspec, 5);
