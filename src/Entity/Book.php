<?php

namespace App\Entity;

class Book extends \EasyRdf\Resource

{
    function birthEvent()
    {
        foreach ($this->all('bio:event') as $event) {
            if (in_array('bio:Birth', $event->types())) {
                return $event;
            }
        }
        return null;
    }
    function age()
    {
        $birth = $this->birthEvent();
        if ($birth) {
            $year = substr($birth->get('bio:date'), 0, 4);
            if ($year) {
                return date('Y') - $year;
            }
        }
        return 'unknown';
    }
}


