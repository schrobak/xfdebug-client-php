<?php

require_once realpath(__DIR__) . '/../xfdebug-client.php';

function test_dump()
{
    XfDump::dump(array_fill(0, 10, 'test_data'));
}

test_dump();