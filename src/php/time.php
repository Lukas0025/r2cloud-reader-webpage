<?php
    function get_time_in_zone($time, $zone){
        $userTimezone = new DateTimeZone($zone);
        $utcTimezone  = new DateTimeZone('UTC');
        $dataDateTime = new DateTime($time, $utcTimezone);
        $offset       = $userTimezone->getOffset($dataDateTime);
        $interval     = DateInterval::createFromDateString((string)$offset . 'seconds');
        
        $dataDateTime->add($interval);
        return $dataDateTime->format('Y-m-d H:i:s');
    }

    function get_time_in_utc_timestrap($time, $zone){
        $userTimezone = new DateTimeZone($zone);
        $utcTimezone  = new DateTimeZone('UTC');
        $dataDateTime = new DateTime($time, $userTimezone);
        $offset       = $utcTimezone->getOffset($dataDateTime);
        $interval     = DateInterval::createFromDateString((string)$offset . 'seconds');
        
        $dataDateTime->add($interval);
        return $dataDateTime->getTimestamp() * 1000;
    }