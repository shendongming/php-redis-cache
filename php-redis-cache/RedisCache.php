<?php
/**
 * Created by PhpStorm.
 * User: sdm
 * Date: 15/4/10
 * Time: 14:09
 */


include_once(__DIR__ . '/Hashing.php');

class RedisCache
{
    const MAX_HASH = 0xffff;

    private $config = array();

    private $virtualNode = 4;

    private $redis = array();
    private $nodeMap = array();

    /**
     * @var Hashing|null
     */
    private $hash = null;

    public function __construct($config)
    {
        $this->config = $config;
        foreach ($config['cluster'] as $v) {
            for ($i = 0; $i < $this->virtualNode; $i++) {
                $id = $this->getHash($v . $i);
                $this->nodeMap[$id] = $v;
            }
        }
        ksort($this->nodeMap);
        $this->hash = new Hashing(array_keys($this->nodeMap));
    }

    public function getHash($key)
    {
        $v=substr(md5($key),0,4) ;
        return  hexdec($v) & self::MAX_HASH;
    }

    /**
     * set data
     * @param $key
     * @param $value
     * @param int $exp
     */
    public function set($key, $value, $exp = 3600)
    {
        $value = serialize($value);
        $redis = $this->getRedis($key);
        $ret = $redis->set($key, $value);
        if ($exp) {
            $redis->expire($key, $exp);
        }
        return $ret;
    }

    /**
     * @param $key
     * @return Redis
     */
    private function getRedis($key)
    {
        $pos = $this->getHash($key);
        $node = $this->hash->findNode($pos);
        $conn = $this->nodeMap[$node];
        $redis = $this->connect($conn);
        //echo "$key => $conn\n";
        return $redis;
    }

    /**
     * @param $conn
     * @return Redis
     */
    private function connect($conn)
    {
        if (isset($this->redis[$conn])) {
            return $this->redis[$conn];
        }
        $arr = explode(':', $conn);
        $redis = new Redis();
        $redis->pconnect($arr[0], isset($arr[1]) ? $arr[1] : 6379);

        $this->redis[$conn] = $redis;
        return $redis;
    }

    public function get($key)
    {
        $redis = $this->getRedis($key);
        $value = $redis->get($key);
        if ($value) {
            $value = unserialize($value);
        }
        return $value;

    }
}

