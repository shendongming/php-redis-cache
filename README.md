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
    include_once __DIR__ . '/RedisCache.php';
    
    
    function test1()
    {
        $conf = array(
            'cluster' => array('127.0.0.1:7000', '127.0.0.1:7001'),
    
        );
        $cache = new RedisCache($conf);
    
    
        //print_r($cache);
        for ($i = 0; $i < 100; $i++) {
            $cache->set('a' . $i, 'hello' . $i);
            if ($cache->get('a' . $i) == 'hello' . $i) {
                $c = '.';
            } else {
                $c = '*';
            }
            echo $c;
            flush();
        }
        echo "\n";
    
    }
    
    
    function test2()
    {
        $conf = array(
            'cluster' => array('127.0.0.1:7000'),
    
        );
        $cache = new RedisCache($conf);
    
    
        //print_r($cache);
        for ($i = 0; $i < 100; $i++) {
            //$cache->set('a' . $i, 'hello' . $i);
            if ($cache->get('a' . $i) == 'hello' . $i) {
                $c = '.';
            } else {
                $c = '*';
            }
            echo $c;
            flush();
        }
    
    
        echo "\n";
    }
    
    
    function test3()
    {
        $conf = array(
            'cluster' => array('127.0.0.1:7001'),
    
        );
        $cache = new RedisCache($conf);
    
        for ($i = 0; $i < 100; $i++) {
            //$cache->set('a' . $i, 'hello' . $i);
            if ($cache->get('a' . $i) == 'hello' . $i) {
                $c = '.';
            } else {
                $c = '*';
            }
            echo $c;
            flush();
        }
    
    
        echo "\n";
    
    }
    
    function test4_set(){
        $conf = array(
            'cluster' => array('127.0.0.1:7001','127.0.0.1:7000'),
        );
        $cache = new RedisCache($conf);
        $t1=microtime(1);
    
        for ($i = 0; $i < 10000; $i++) {
            $cache->set('a' . $i, 'hello' . $i);
        }
    
        $t2=microtime(1);
    
        var_dump($t2-$t1);
        echo "\n";
    }
    
    test1();
    test2();
    test3();
    test4_set();
```