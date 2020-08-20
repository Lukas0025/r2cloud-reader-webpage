<?php
    class components {

        public function observation_list_item($id, $sat_name, $sat_id, $decoder, $decoded, $start, $status, $status_bg = 'bg-success') {
            return '<tr onclick="window.location=\'observation.php?sat=' . $sat_id . '&id=' . $id . '\';" style="cursor: pointer">
                        <td><span class="text-muted">' . $id . '</span></td>
                        <td>' . $sat_name . '</td>
                        <td>' . $decoder . '</td>
                        <td>' . $decoded . '</td>
                        <td>' . $start . '</td>
                        <td>
                            <span class="status-icon ' . $status_bg . '"></span>' . $status . '
                        </td>
                    </tr>';
        }

        public function gallery_image($sat_name, $sat_id, $id, $start, $image) {
            return '<div class="col-sm-6 col-lg-4">
                        <div class="card p-3">
                            <a href="observation.php?sat=' . $sat_id . '&id=' . $id . '" class="mb-3">
                                <img src="' . $image . '" class="rounded">
                            </a>
                            
                            <div class="d-flex align-items-center px-2">
                                <div>
                                    <div>' . $sat_name . '</div>
                                    <small class="d-block text-muted">' . $start . '</small>
                                </div>
                            </div>
                        </div>
                    </div>';
        }

        public function satellite_item($sat_id, $sat_name, $decoded, $last_pass) {
            $bar_color = $decoded < 30 ? "bg-red" : ($decoded < 60 ? "bg-yellow" : "bg-green");

            return '<tr onclick="window.location=\'observations.php?sat=' . $sat_id . '\';">
                        <td class="text-center">
                            <img src="assets/images/sat.png" width="40px" class="d-block">
                        </td>
                        <td>
                            <div>' . $sat_name . '</div>
                        </td>
                        <td>
                        <div class="clearfix">
                            <div class="float-left">
                            <strong>' . $decoded . '%</strong>
                            </div>
                        </div>
                        <div class="progress progress-xs">
                            <div class="progress-bar ' . $bar_color . '" role="progressbar" style="width: ' . $decoded . '%" aria-valuenow="' . $decoded . '" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        </td>
                        <td>
                            <div>' . $last_pass . '</div>
                        </td>
                    </tr>';
        }

    }
?>