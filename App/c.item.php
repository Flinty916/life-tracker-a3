<?php

namespace mystats;

use Exception;

class Item
{
    public $class;
    public $displayName;
    public $img;

    public function __construct($item)
    {
        try {
            $this->validateItem($item);
            $this->setItem($item);
        } catch (Exception $e) {
            echo '<strong>ERROR: ' . $e->getMessage() . '</strong>';
        }
    }

    protected function validateItem($item)
    {
        if (is_string($item)) {
            return true;
        } else
            throw new Exception('Item must be given in String format!');
    }

    protected function setItem($item)
    {
        try {
            $item = json_decode(@file_get_contents('https://api.flintsdesigns.co.uk/a3-search/' . $item));
            if ($item) {
                $this->class = $item->classname;
                $this->displayName = $item->displayName;
                $this->img = $item->image;
                return true;
            }
        }
        catch (Exception $e) {
            throw new Exception('Class not found!');
        }
    }
}
