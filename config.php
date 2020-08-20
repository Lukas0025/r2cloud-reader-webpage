<?php
    /**
     * R2Cloud data webpage reader
     * config file
     * @author Lukáš Plevač <lukasplevac@gmail.com>
     * @date 26.7.2020
     */

    $config = (object)[
        'title'                 => 'R2Cloud data',
        'r2_patch'              => '/var/www/data/',
        'r2_url'                => '/',
        'timezone'              => 'UTC',
        'observations_on_home'  => 10,
        'hexdump_limit'         => 10
    ];

?>