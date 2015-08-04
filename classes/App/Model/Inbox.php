<?php

namespace App\Model;


class Inbox extends \PHPixie\ORM\Model
{
    public $table = 'inbox';

    public function getDate()
    {
        return ($this->pixie->view_helper()->getDateFormat($this->timestamp));
    }
}