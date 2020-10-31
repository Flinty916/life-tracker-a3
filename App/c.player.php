<?php

namespace mystats;
use Exception;
use KubAT\PhpSimple\HtmlDomParser;

class Player {
    protected $db;
    protected $pid;
    public $available = false;
    public $name;
    public $cash;
    public $bank;
    protected $copLvl;
    protected $medLvl;
    protected $civStats;
    protected $copStats;
    protected $medStats;
    protected $playtime;
    protected $inv;

    public function __construct($pid)
    {
        try {
            $this->validatePID($pid);
        }
        catch (Exception $e) {
            echo '<strong>ERROR: ' . $e->getMessage() . '</strong>';
        }
        $this->db = new Database();
        $this->pid = $pid;
        if($this->setStats($this->pid)) {
            $this->available = true;
        }
    }

    protected function validatePID($pid) {
        if(is_integer($pid))
            return true;
        else
            throw new Exception('Player ID must be an Integer!');
    }

    protected function destring($string, $int = false) {
        $arr = explode(',', trim($string, "[]\"`\0"));
        if($int) {
            foreach ($arr as $key => $value) {
                $arr[$key] = intval($value);
            }
        }
        else {
            foreach ($arr as $key => $value) {
                $arr[$key] = trim($value, "[]\"`\" \"");
                if(strlen($arr[$key]) == 0)
                    unset($arr[$key]);
            }
            $arr = array_values($arr);
        }
        return $arr;
    }

    protected function setStats($pid) {
        $stats = $this->db->select('players', ['*'], 'WHERE PID = "'.$pid.'"');
        if($stats) {
            $stats = $stats[0];
//            var_dump($stats);
            $this->name = $stats['name'];
            $this->cash = $stats['cash'];
            $this->bank = $stats['bankacc'];
            $this->copLvl = $stats['coplevel'];
            $this->medLvl = $stats['mediclevel'];
            $this->civStats = $this->destring($stats['civ_stats'], true);
            $this->copStats = $this->destring($stats['cop_stats'], true);
            $this->medStats = $this->destring($stats['med_stats'], true);
            $this->playtime = $this->destring($stats['playtime'], true);
            $this->inv = $this->setInv($stats['civ_gear']);
            return true;
        }
        else {
            return false;
        }
    }

    protected function setInv($strInv) {
        $arr = $this->destring($strInv);
        foreach($arr as $key => $item) {
            $obj = new Item($item);
            if($obj->class !== null)
                $arr[$key] = $obj;
            else
                $arr[] = $item;
        }
        return $arr;
    }

    public function getCivStats() {
        return $this->civStats;
    }
    public function getCopStats() {
        return $this->copStats;
    }
    public function getMedStats() {
        return $this->medStats;
    }
    public function getPlaytime() {
        $pt = array();
        $keys = ['Hours', 'Minutes', 'Seconds'];
        for($i = 0; $i < count($this->playtime); $i++) {
            $pt[$keys[$i]] = $this->playtime[$i];
        }
        return $pt;
    }
    public function getInv() {
        $inv = array();
        foreach ($this->inv as $item) {
            if(is_object($item) && $item->class !== null)
                $inv[] = $item->displayName;
            elseif(strlen($item) > 1)
                $inv[] = $item;
        }
        return $inv;
    }
}