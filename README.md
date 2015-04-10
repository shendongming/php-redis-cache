# php-redis-cache
php redis cache ,consistent hashing ,wrap phpredis



```php
<?     

/*
   test result
   ....................................................................................................
   ..**...**...**.***...****.*...**.....**...*.*.*.*.*........*.**.*..*...*..*....**.*..**..**.***.*..*
   **..***..***..*...***....*.***..*****..***.*.*.*.*.********.*..*.**.***.**.****..*.**..**..*...*.**.
*/
   
   
include_once __DIR__ . '/vendor/autoload.php';



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
```