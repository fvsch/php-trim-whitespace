<?php

if (PHP_SAPI === 'cli') {
    echo "(Please see this test in a browser.)\n";
    die();
}

require_once __DIR__.'/../trim-whitespace.php';
$data = file_get_contents(__DIR__.'/data/emptylines.html');

$test1 = trimWhitespace($data, ['blankLines'=>0]);
$test2 = trimWhitespace($data, ['blankLines'=>1]);
$test3 = trimWhitespace($data, ['blankLines'=>2]);
$test4 = trimWhitespace($data, ['blankLines'=>2, 'leading'=>false]);
$test5 = trimWhitespace($data, ['blankLines'=>2, 'inside'=>false]);

?>

<style>td { border: solid 1px; padding: .5em; vertical-align: top; }</style>
<table style="table-layout:fixed;">
    <tr>
        <td><strong>Original</strong><br><pre><?php echo $data; ?></pre></td>
        <td><strong>maxBlankLines:0</strong><br><pre><?php echo $test1; ?></pre></td>
        <td><strong>maxBlankLines:1</strong><br><pre><?php echo $test2; ?></pre></td>
        <td><strong>maxBlankLines:2</strong><br><pre><?php echo $test3; ?></pre></td>
        <td><strong>maxBlankLines:2,trimStart:false</strong><br><pre><?php echo $test4; ?></pre></td>
        <td><strong>maxBlankLines:2,maxSpaces:false</strong><br><pre><?php echo $test5; ?></pre></td>
    </tr>
</table>
