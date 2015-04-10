<?php
/**
 * User: sdm
 * Date: 15/4/10
 * Time: 17:01
 */


include_once __DIR__ . '/../../vendor/autoload.php';


function testFindOne($i, $pos, $idList)
{
    $hash = new Hashing($idList);
    $result = $hash->findNode($pos);
    assert($i == $result);
    echo '.';

}

function testFind()
{

    testFindOne(1, 1, array(1, 2, 3, 4, 6));
    testFindOne(2, 2, array(1, 2, 3, 4, 6));
    testFindOne(4, 5, array(1, 2, 3, 4, 6));
    testFindOne(4, 5, array(1, 3, 4, 6));
    testFindOne(6, 8, array(1, 3, 4, 6));
    testFindOne(6, 1, array(3, 4, 6));
    testFindOne(6, 12, array(3, 4, 6));
    testFindOne(3, 12, array(3, 40, 60));

}

testFind();