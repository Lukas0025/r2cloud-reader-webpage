<?php
    /**
     * R2Cloud data webpage reader
     * Observations list page (default)
     * @author Lukáš Plevač <lukasplevac@gmail.com>
     * @date 26.7.2020
     */

    include 'php/templates.php';
    include 'php/r2cloud_data.php';
    include 'php/components.php';
    include 'php/time.php';
    include 'config.php';

    $temp     = new template('observations');
    $comp     = new components();

    $r2_cloud = new r2cloud_data($config->r2_patch, $config->r2_url);

    
    if (is_numeric($_GET['sat'])) {
        //get observations of sat
        $observations_raw = $r2_cloud->get_observations_of_satellite($_GET['sat']);
        $title = "Observations of sat " . $_GET['sat'];
    } elseif (isset($_GET['near'])) {
        $title = "Observations on " . $_GET['near'] . " +- 2h";
        //get observations near date
        $near  = get_time_in_utc_timestrap($_GET['near'], $config->timezone);
        $start = $near - (3600000 * 2); //+2h
        $end   = $near + (3600000 * 2); //-2h

        $observations_raw = $r2_cloud->get_observations_between($start, $end);
    } else {
        //get observations
        $observations_raw = $r2_cloud->get_all_observations_by_time(); //order in new -> old
        $title = "Observations by time";
    }

    $observations = "";
    foreach ($observations_raw as $observation_raw) {
        $observation = $r2_cloud->get_observation($observation_raw);

        //is exist?
        if (!isset($observation['meta'])) {
            continue; //skip it no metadata
        }

        /**
         * 0 - decoding
         * 2 - decoded
         * 1 - fail to decode
         */
        $decoded_status = (isset($observation['data']) || isset($observation['image'])) ? 2 : (
            ($observation['meta']->status == "NEW") ? 0 : 1
        );

        $observations .= $comp->observation_list_item(
            $observation['meta']->id,
            $observation['meta']->tle->line1,
            $observation['meta']->satellite,
            $observation['meta']->decoder,
            $observation['meta']->numberOfDecodedPackets,
            get_time_in_zone(gmdate("Y-m-d H:i:s", $observation['meta']->start / 1000), $config->timezone),
            $decoded_status == 0 ? 'Decoding' : (
                $decoded_status == 1 ? 'Fail to decode' : 'Decoded'
            ),
            $decoded_status == 0 ? 'bg-warning' : (
                $decoded_status == 1 ? 'bg-danger' : 'bg-success'
            )
        );
    }

    $temp->create([
        'page_title'   => $config->title,
        'observations' => $observations,
        'title'        => $title
    ]);