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
    include 'php/sat_icons.php';
    include 'config.php';

    $temp     = new template('index');
    $comp     = new components();

    $r2_cloud = new r2cloud_data($config->r2_patch, $config->r2_url);

    //get decoded observations
    $observations_raw = $r2_cloud->get_decoded_observations(); //order in new -> old

    $observations = "";
    $counter = 0;
    foreach ($observations_raw as $observation_raw) {
        $observation = $r2_cloud->get_observation($observation_raw);

        //is exist?
        if (!isset($observation['meta'])) {
            continue; //skip it no metadata
        }

        //end of counter
        if ($counter >= $config->observations_on_home) {
            break;
        }


        $observations .= $comp->observation_list_item(
            $observation['meta']->id,
            $observation['meta']->tle->line1,
            $observation['meta']->satellite,
            $observation['meta']->decoder,
            $observation['meta']->numberOfDecodedPackets,
            get_time_in_zone(gmdate("Y-m-d H:i:s", $observation['meta']->start / 1000), $config->timezone),
            'Decoded',
            'bg-success'
        );

        $counter++;
    }

    //get sattelites scores
    $scores = $r2_cloud->get_sattelites_scores();
    $satellites = "";
    foreach ($scores as $score) {
        $satellites .= $comp->satellite_item(
            $score['sat_id'],
            $score['name'],
            $score['decoded'],
            get_time_in_zone(gmdate("Y-m-d H:i:s", $score['last_pass'] / 1000), $config->timezone),
            get_satellite_icon($score['name'], $satellite_icons)
        );
    }

    $temp->create([
        'page_title'   => $config->title,
        'observations' => $observations,
        'satellites'   => $satellites
    ]);