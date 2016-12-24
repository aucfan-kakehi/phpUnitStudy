<?php

require __DIR__ . '/hello.php';

function assetTrue($condition)
{
    if (! $condition) {
        throw new Exception('Assertion failed.');
    }
}

$test = hello();
$expected = 'Hello World!';
assetTrue($test === $expected);
