<?php
    /**
     * R2Cloud data webpage reader
     * terminal
     * @author Lukáš Plevač <lukasplevac@gmail.com>
     * @date 26.7.2020
     */

    include 'php/templates.php';
    include 'php/r2cloud_data.php';
    include 'config.php';

    if ($argv) {

        if (count($argv) == 1) {
            $action = "--help";
        } else {
            $action = $argv[1];
        }

        if (isset($argv[2])) {
            $value = $argv[2];
        }

        $r2_cloud = new r2cloud_data($config->r2_patch, $config->r2_patch);

        if ($action == "--help") {
            echo "R2Cloud data terminal tool\n\n";
            echo "example use php terminal.php --list-observations\n\n";
            echo "--help    show help\n";
            echo "--list-observations   list all observations by time in format time - link\n";
            echo "--list-observations-sat   list all observations by satelites in format time - link\n";
            echo "--observations-of-sat <sat_id>   get all observations of sat\n";
            echo "--observation <link>   get info for observation\n";
        } else if ($action == "--list-observations") {
            print_r($r2_cloud->get_all_observations_by_time());
        } else if ($action == "--list-observations-sat") {
            print_r($r2_cloud->get_all_observations_by_satellites());
        } else if ($action == "--observations-of-sat") {
            print_r($r2_cloud->get_observations_of_satellite($value));
        } else if ($action == "--observation") {
            print_r($r2_cloud->get_observation($value));
        }
    }