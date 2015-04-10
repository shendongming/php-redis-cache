<?php
/**
 * User: sdm
 * Date: 15/4/10
 * Time: 17:01
 * test result
 ....................................................................................................
 ..**...**...**.***...****.*...**.....**...*.*.*.*.*........*.**.*..*...*..*....**.*..**..**.***.*..*
 **..***..***..*...***....*.***..*****..***.*.*.*.*.********.*..*.**.***.**.****..*.**..**..*...*.**.

 */


include_once __DIR__ . '/../../vendor/autoload.php';


function test4_set1()
{
    $conf = array(
        'cluster' => array('127.0.0.1:7001', '127.0.0.1:7000'),
    );
    $cache = new RedisCache($conf);
    $t1 = microtime(1);

    for ($i = 0; $i < 10000; $i++) {
        $cache->set('qw' . $i, 'hello' . $i);
    }

    $t2 = microtime(1);

    var_dump($t2 - $t1);
    echo "\n";
}
function test4_set2()
{
    $cache = new Redis();
    $cache->pconnect('127.0.0.1',7001);
    $t1=microtime(1);

    for ($i = 0; $i < 10000; $i++) {
        $cache->set('qwe' . $i, 'hello' . $i);
        $cache->expire('qwe'.$i,1800);
    }

    $t2=microtime(1);

    var_dump($t2-$t1);
    echo "\n";


}

test4_set1();
test4_set2();