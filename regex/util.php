<?php
/**
 * Utility functions
 *
 * @param $value
 */
function writeBoolean($value)
{
    echo $value ? 'true' : 'false';
    echo "\n";
}

function writeString($value)
{
    echo $value;
    echo "\n";
}

function writeArray($value)
{
    print_r($value);
    echo "\n";
}
