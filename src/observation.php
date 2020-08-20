<?php
    /**
     * R2Cloud data webpage reader
     * Observation info page
     * @author Lukáš Plevač <lukasplevac@gmail.com>
     * @date 26.7.2020
     */

    include 'php/templates.php';
    include 'php/r2cloud_data.php';
    include 'php/time.php';
    include 'php/Hexdump.php';
    include 'config.php';

    $temp =     new template('observation');

    $r2_cloud = new r2cloud_data($config->r2_patch, $config->r2_url);

    if (!is_numeric($_GET['sat']) || !is_numeric($_GET['id'])) {
        die("Invalid sat or id");
    }

    //create link
    $link        = $_GET['sat'] . "/data/" . $_GET['id'];

    //get observation
    $observation = $r2_cloud->get_observation($link);

    //init hexdump
    use Jhartell\Hexdump\Hexdump;
    $hexdump = new Hexdump();

    $temp->create([
        'page_title'      => $config->title,
        'sat_name'        => $observation['meta']->tle->line1,
        'sat_id'          => $observation['meta']->satellite,
        'ob_start'        => get_time_in_zone(gmdate("Y-m-d H:i:s", $observation['meta']->start / 1000), $config->timezone),
        'ob_end'          => get_time_in_zone(gmdate("Y-m-d H:i:s", $observation['meta']->end / 1000), $config->timezone),
        'samp_rate'       => $observation['meta']->sampleRate,
        'in_samp_rate'    => $observation['meta']->inputSampleRate,
        'freq'            => $observation['meta']->frequency . "Hz",
        'a_freq'          => $observation['meta']->actualFrequency . "Hz",
        'num_decoded'     => $observation['meta']->numberOfDecodedPackets,
        'raw'             => isset($observation['raw']) ? "<a href='{$observation['raw']}' download>Download</a>" : "Unavailable",
        'tle_1'           => $observation['meta']->tle->line2,
        'tle_2'           => $observation['meta']->tle->line3,
        'image'           => isset($observation['image']) ? "<img src='{$observation['image']}'>" : "Image unavailable",
        'data'            => isset($observation['data']) ? $hexdump->dump(file_get_contents($observation['data-os-patch']), $config->hexdump_limit) . "<br><a href='{$observation['data']}' download>Download all data in bin</a>" : "Data unavailable",
        'bandwidth'       => $observation['meta']->bandwidth,
        'decoder'         => $observation['meta']->decoder,
        'spectrogram'     => isset($observation['spectrogram']) ? "<img src='{$observation['spectrogram']}'>" : "Spectrogram unavailable",
    ]);