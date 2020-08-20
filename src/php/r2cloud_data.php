<?php
    class r2cloud_data {
        private $r2cloud_patch;
        private $r2cloud_url;

        /**
         * Conscructor
         * @param string $r2cloud_patch - patch to R2Cloud
         * @param string $r2cloud_url   - patch to R2Cloud from http (if you dont use set same as patch)
         */
        function __construct($r2cloud_patch, $r2cloud_url) {
            $this->r2cloud_patch = $r2cloud_patch;
            $this->r2cloud_url = $r2cloud_url;
        }

        /**
         * get all observations and group it by satelites
         * @return array with satelites id as key and values arrays of oservations (same as by time)
         */
        public function get_all_observations_by_satellites() {
            $output = [];
            $satellites = glob($this->r2cloud_patch . '/data/satellites/*' , GLOB_ONLYDIR);

            foreach ($satellites as $satellite) {
                $output[basename($satellite)] = [];

                $observations = glob($satellite . '/data/*' , GLOB_ONLYDIR);

                $ids                 = [];
                $observations_output = []; 

                foreach ($observations as $observation) {
                    array_push($ids, basename($observation));
                    $observations_output[basename($observation)] = $this->get_observation_link($observation);
                }

                rsort($ids);

                for ($i = 0; $i < count($ids); $i++) {
                    $output[basename($satellite)][$ids[$i]] = $observations_output[$ids[$i]];
                }
            }

            return $output;
        }

        /**
         * get all observations order by time (new on top - for roreach)
         * @return array with id as key and values link for observation
         */
        public function get_all_observations_by_time() {
            $output = [];
            $times = [];

            $satellites = glob($this->r2cloud_patch . '/data/satellites/*' , GLOB_ONLYDIR);

            foreach ($satellites as $satellite) {
                $observations = glob($satellite . '/data/*' , GLOB_ONLYDIR);

                foreach ($observations as $observation) {
                    $output[basename($observation)] = $this->get_observation_link($observation);
                    array_push($times, basename($observation));
                }
            }

            //write in corect order
            rsort($times);
            $new_output = [];

            for ($i = 0; $i < count($times); $i++) {
                $new_output[$times[$i]] = $output[$times[$i]];
            }

            return $new_output;
        }

        /**
         * get observation link from observation path
         * @return string observation link
         */
        public function get_observation_link($patch) {
            return str_replace($this->r2cloud_patch . '/data/satellites/', "", $patch);
        }

        /**
         * all observations between to timestraps
         * @param int $start - linux timesrap * 1000 of start time
         * @param int $end - linux timesrap * 1000 of end time
         * @return array with id as key and values link for observation
         */
        public function get_observations_between($start, $end) {
            $output = [];

            foreach ($this->get_all_observations_by_time() as $id => $link) {
                $observation = $this->get_observation($link);

                if ($observation['meta']->start < $end && $observation['meta']->start > $start) {
                    $output[$id] = $link;
                }
            }

            return $output;
        }

        /**
         * Get info about observation
         * @param string $link - link for observation
         * @return array of informations for details use print_f()
         */
        public function get_observation($link) {
            $output = [];
            $observation = $this->r2cloud_patch . '/data/satellites/' . $link;

            if (file_exists($observation . "/spectogram.png")) {
                $output['spectrogram'] = $this->r2cloud_url . '/data/satellites/' . $link . "/spectogram.png";
            }

            if (file_exists($observation . "/meta.json")) {
                $json = file_get_contents($observation . "/meta.json");
                $output['meta'] = json_decode($json);
            }

            if (file_exists($observation . "/output.raw.gz")) {
                $output['raw']          = $this->r2cloud_url . '/data/satellites/' . $link . "/output.raw.gz";
                $output['raw-os-patch'] = $this->r2cloud_patch . '/data/satellites/' . $link . "/output.raw.gz";
            } elseif (file_exists($observation . "/output.wav")) {
                $output['raw']          = $this->r2cloud_url . '/data/satellites/' . $link . "/output.wav";
                $output['raw-os-patch'] = $this->r2cloud_patch . '/data/satellites/' . $link . "/output.wav";
            }

            if (file_exists($observation . "/a.jpg")) { //decoded image
                $output['image']         = $this->r2cloud_url . '/data/satellites/' . $link . "/a.jpg";
                $output['image-os-path'] = $this->r2cloud_patch . '/data/satellites/' . $link . "/a.jpg";
            }

            if (file_exists($observation . "/data.bin")) { //decoded data
                $output['data']          = $this->r2cloud_url . '/data/satellites/' . $link . "/data.bin";
                $output['data-os-patch'] = $this->r2cloud_patch . '/data/satellites/' . $link . "/data.bin";
            }

            return $output;

        }

        /**
         * get all observations of satellite with id
         * @param int $id - id of satelite
         * @return array with id as key and values link for observation
         */
        public function get_observations_of_satellite($id) {
            return $this->get_all_observations_by_satellites()[$id];
        }

        /**
         * get all observations with decoded images
         * @return array of observation
         */
        public function get_all_images() {
            $output = [];

            foreach ($this->get_all_observations_by_time() as $raw_observation) {

                $observation = $this->get_observation($raw_observation);
                
                if (isset($observation['image'])) {
                    array_push($output, $observation);
                }
            }

            return $output;
        }

        public function get_decoded_observations() {
            $output = [];

            $observations = $this->get_all_observations_by_time();

            foreach ($observations as $id => $observation) {
                
                $observation_data = $this->get_observation($observation);

                if (isset($observation_data['image']) || isset($observation_data['data'])) {
                    $output[$id] = $observation;
                }
  
            }

            return $output;
        }

        /**
         * get all observated satellites and get observations scores
         * @return array of array with keys decoded (score in %), name (sat name), last_pass, sat_id
         */
        public function get_sattelites_scores() {

            $output = [];

            $satellites = $this->get_all_observations_by_satellites();

            foreach ($satellites as $satellite) {
                
                $max_time = 0;
                $total    = 0;
                $decoded  = 0;
                $sat_name = "";
                $sat_id   = 0;
                foreach($satellite as $observation) {
                    $observation_data = $this->get_observation($observation);
                    
                    if ($max_time < $observation_data['meta']->start) {
                        $max_time = $observation_data['meta']->start;
                    }

                    if (isset($observation_data['image']) || isset($observation_data['data'])) {
                        $decoded++;
                    }

                    $total++;
                    $sat_name = $observation_data['meta']->tle->line1;
                    $sat_id = $observation_data['meta']->satellite;
                }

                if ($max_time > 0) {
                    array_push($output,[
                        "decoded"   => round(($decoded * 100) / $total),
                        "name"      => $sat_name,
                        "last_pass" => $max_time,
                        "sat_id"    => $sat_id
                    ]);
                }
  
            }

            return $output;
        }
    }
?>