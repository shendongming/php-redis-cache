<?php

/**
 * User: sdm
 * Date: 15/4/10
 * Time: 16:44
 */
class Hashing
{

    private $idList = array();
    private $len = 0;

    public function __construct($idList)
    {
        $this->idList = $idList;
        $this->len = count($idList);
    }

    public function findNode($pos)
    {

        $idList = $this->idList;
        $len = $this->len;
        if ($pos < $idList[0]) {
            return $idList[$len - 1];
        }
        if ($pos >= $idList[$len - 1]) {
            return $idList[$len - 1];
        }

        for ($i = 0; $i < $len - 1; $i++) {
            if ($pos >= $idList[$i] && $pos < $idList[$i + 1]) {

                return $idList[$i];
            }
        }

    }

}
