<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    /**
     * R2Cloud data webpage reader
     * Satille icons
     * @author Lukáš Plevač <lukasplevac@gmail.com>
     * @date 27.8.2020
     */

    $satellite_icons = (object)[
        'path'   => 'assets/images/satellites/',
        'icons'  => (object)[
            'fox1d'             => 'fox1d.png',
            'fox1c'             => 'fox1c.png',
            'sNet'              => 'snet.png',
            'siriusSat'         => 'siriussat.png',
            'elfin'             => 'elfin.png',
            'cubebel'           => 'cubebel.png',
            'irvine'            => 'irvine.png',
            'reaktorHelloWorld' => 'reaktorhelloworld.png',
            'minxss'            => 'minxss.png',
            'snuglite'          => 'snuglite.png',
            'itasat'            => 'itasat.png',
            'eseo'              => 'eseo.png',
            'csimfd'            => 'csimfd.png',
            'pwsat2c'           => 'pwsat2c.png',
            'chomptt'           => 'chomptt.png',
            'UWE4'              => 'UWE4.png',
            'lume1'             => 'lume1.png',
            'nexus'             => 'nexus.png',
            'astroCast'         => 'astrocast.png',
            'aistechSat'        => 'aistechsat.png',
            'm6p'               => 'm6p.png',
            'painani1'          => 'painani1.png',
            'lucky7'            => 'lucky7.png',
            'opsSat'            => 'opssat.png',
            'swampSatII'        => 'swampsatII.png',
            'huskySat'          => 'huskysat.png',
            'qarman'            => 'qarman.png',
            'tanyushaYuzgu'     => 'tanyusha-yuzgu.png',
            'technoSat'         => 'technosat.png',
            'aalto'             => 'aalto.png',
            'lituanicaSat'      => 'lituanicasat.png',
            'zhuhai'            => 'zhuhai.png',
            'grifex'            => 'grifex.png',
            'fireBird'          => 'firebird.png',
            'tigriSat'          => 'tigrisat.png',
            'polyitan'          => 'polyitan.png',
            'bugSat'            => 'bugsat.png',
            'funCube'           => 'funcube.png',
            'cubebug1'          => 'cubebug1.png',
            'GOMX1DSTAR'        => 'GOMX1DSTAR.png',
            'DO64'              => 'DO64.png',
            'noaa'              => 'noaa.png',
            'meteor'            => 'meteor.png'
        ],

        'defaults' => (object) [
            'sat'     => 'default.png',
            'cubeSat' => 'default-cube.png'
        ]
    ];

    function get_satellite_icon($tle_line_0, $satellite_icons) {
        
        if ($tle_line_0 == "NOAA 15" || $tle_line_0 == "NOAA 18" || $tle_line_0 == "NOAA 19") {
            return $satellite_icons->path . $satellite_icons->icons->noaa;
        } else if ($tle_line_0 == "DELFI-C3 (DO-64)") {
            return $satellite_icons->path . $satellite_icons->icons->DO64;
        } else if ($tle_line_0 == "GOMX-1" || $tle_line_0 == "D-STAR ONE (SPARROW)") {
            return $satellite_icons->path . $satellite_icons->icons->GOMX1DSTAR;
        } else if ($tle_line_0 == "CUBEBUG-2 (LO-74)") {
            return $satellite_icons->path . $satellite_icons->icons->cubebug1;
        } else if ($tle_line_0 == "FUNCUBE-1 (AO-73)") {
            return $satellite_icons->path . $satellite_icons->icons->funCube;
        } else if ($tle_line_0 == "BUGSAT-1 (TITA)") {
            return $satellite_icons->path . $satellite_icons->icons->bugSat;
        } else if ($tle_line_0 == "POLYITAN-1") {
            return $satellite_icons->path . $satellite_icons->icons->polyitan;
        } else if ($tle_line_0 == "TIGRISAT") {
            return $satellite_icons->path . $satellite_icons->icons->tigriSat;
        } else if ($tle_line_0 == "METEOR-M 2") {
            return $satellite_icons->path . $satellite_icons->icons->meteor;
        } else if ($tle_line_0 == "FIREBIRD 3" || $tle_line_0 == "FIREBIRD 4") {
            return $satellite_icons->path . $satellite_icons->icons->fireBird;
        } else if ($tle_line_0 == "GRIFEX") {
            return $satellite_icons->path . $satellite_icons->icons->grifex;
        } else if ($tle_line_0 == "ZHUHAI-1 02 (CAS-4B)" || $tle_line_0 == "ZHUHAI-1 01 (CAS-4A)") {
            return $satellite_icons->path . $satellite_icons->icons->zhuhai;
        } else if ($tle_line_0 == "LITUANICASAT-2") {
            return $satellite_icons->path . $satellite_icons->icons->lituanicaSat;
        } else if ($tle_line_0 == "AALTO-1") {
            return $satellite_icons->path . $satellite_icons->icons->aalto;
        } else if ($tle_line_0 == "TECHNOSAT") {
            return $satellite_icons->path . $satellite_icons->icons->technoSat;
        } else if ($tle_line_0 == "FOX-1D (AO-92)") {
            return $satellite_icons->path . $satellite_icons->icons->fox1d;
        } else if ($tle_line_0 == "S-NET A" || $tle_line_0 == "S-NET B" || $tle_line_0 == "S-NET C" || $tle_line_0 == "S-NET D") {
            return $satellite_icons->path . $satellite_icons->icons->sNet;
        } else if ($tle_line_0 == "SIRIUSSAT-1" || $tle_line_0 == "SIRIUSSAT-2") {
            return $satellite_icons->path . $satellite_icons->icons->siriusSat;
        } else if ($tle_line_0 == "ELFIN-B" || $tle_line_0 == "ELFIN-A") {
            return $satellite_icons->path . $satellite_icons->icons->elfin;
        } else if ($tle_line_0 == "CUBEBEL-1 (BSUSAT-1)") {
            return $satellite_icons->path . $satellite_icons->icons->cubebel;
        } else if ($tle_line_0 == "IRVINE01") {
            return $satellite_icons->path . $satellite_icons->icons->irvine;
        } else if ($tle_line_0 == "REAKTOR HELLO WORLD") {
            return $satellite_icons->path . $satellite_icons->icons->reaktorHelloWorld;
        } else if ($tle_line_0 == "MINXSS-2") {
            return $satellite_icons->path . $satellite_icons->icons->minxss;
        } else if ($tle_line_0 == "FOX-1CLIFF (AO-95)") {
            return $satellite_icons->path . $satellite_icons->icons->fox1c;
        } else if ($tle_line_0 == "SNUGLITE") {
            return $satellite_icons->path . $satellite_icons->icons->snuglite;
        } else if ($tle_line_0 == "ITASAT 1") {
            return $satellite_icons->path . $satellite_icons->icons->itasat;
        } else if ($tle_line_0 == "ESEO") {
            return $satellite_icons->path . $satellite_icons->icons->eseo;
        } else if ($tle_line_0 == "CSIM-FD") {
            return $satellite_icons->path . $satellite_icons->icons->csimfd;
        } else if ($tle_line_0 == "ASTROCAST 0.1" || $tle_line_0 == "ASTROCAST 0.2") {
            return $satellite_icons->path . $satellite_icons->icons->astroCast;
        } else if ($tle_line_0 == "PW-SAT2") {
            return $satellite_icons->path . $satellite_icons->icons->pwsat2c;
        } else if ($tle_line_0 == "CHOMPTT") {
            return $satellite_icons->path . $satellite_icons->icons->chomptt;
        } else if ($tle_line_0 == "UWE-4") {
            return $satellite_icons->path . $satellite_icons->icons->UWE4;
        } else if ($tle_line_0 == "LUME 1") {
            return $satellite_icons->path . $satellite_icons->icons->lume1;
        } else if ($tle_line_0 == "NEXUS (FO-99)") {
            return $satellite_icons->path . $satellite_icons->icons->nexus;
        } else if ($tle_line_0 == "AISTECHSAT-3") {
            return $satellite_icons->path . $satellite_icons->icons->aistechSat;
        } else if ($tle_line_0 == "M6P") {
            return $satellite_icons->path . $satellite_icons->icons->m6p;
        } else if ($tle_line_0 == "PAINANI 1") {
            return $satellite_icons->path . $satellite_icons->icons->painani1;
        } else if ($tle_line_0 == "LUCKY-7") {
            return $satellite_icons->path . $satellite_icons->icons->lucky7;
        } else if ($tle_line_0 == "OPS-SAT") {
            return $satellite_icons->path . $satellite_icons->icons->opsSat;
        } else if ($tle_line_0 == "SWAMPSAT-2") {
            return $satellite_icons->path . $satellite_icons->icons->swampSatII;
        } else if ($tle_line_0 == "HUSKYSAT-1") {
            return $satellite_icons->path . $satellite_icons->icons->huskySat;
        } else if ($tle_line_0 == "QARMAN") {
            return $satellite_icons->path . $satellite_icons->icons->qarman;
        } else if ($tle_line_0 == "AAUSAT 4" || $tle_line_0 == "NAYIF-1 (EO-88)" || $tle_line_0 == "PEGASUS" || $tle_line_0 == "SKCUBE" || $tle_line_0 == "RADFXSAT (FOX-1B)" || $tle_line_0 == "ENDUROSAT ONE" || $tle_line_0 == "TANUSHA-3" || $tle_line_0 == "JY1SAT (JO-97)" || $tle_line_0 == "SUOMI-100" || $tle_line_0 == "ATL-1" || $tle_line_0 == "SMOG-P" || $tle_line_0 == "FLORIPASAT-1" || $tle_line_0 == "QUETZAL-1") {
            return $satellite_icons->path . $satellite_icons->defaults->cubeSat;
        } else {
            return $satellite_icons->path . $satellite_icons->defaults->sat;
        }
    }

?>