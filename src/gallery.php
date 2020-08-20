<?php
    /**
     * R2Cloud data webpage reader
     * Gallery page
     * @author Lukáš Plevač <lukasplevac@gmail.com>
     * @date 26.7.2020
     */

    include 'php/templates.php';
    include 'php/r2cloud_data.php';
    include 'php/components.php';
    include 'php/time.php';
    include 'config.php';

    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    $temp     = new template('gallery');
    $comp     = new components();

    $r2_cloud = new r2cloud_data($config->r2_patch, $config->r2_url);

    //get all observations with images
    $observations_raw = $r2_cloud->get_all_images(); //order in new -> old

    $observations = "";
    foreach ($observations_raw as $observation) {
        $observations .= $comp->gallery_image(
            $observation['meta']->tle->line1,
            $observation['meta']->satellite,
            $observation['meta']->id,
            get_time_in_zone(gmdate("Y-m-d H:i:s", $observation['meta']->start / 1000), $config->timezone),
            $observation['image']
        );
    }

    $temp->create([
        'page_title'   => $config->title,
        'observations' => $observations,
        'count'        => count($observations_raw)
    ]);