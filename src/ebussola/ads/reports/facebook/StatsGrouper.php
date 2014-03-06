<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Shinagawa
 * Date: 25/02/14
 * Time: 11:55
 */

namespace ebussola\ads\reports\facebook;


use ebussola\ads\reports\facebook\adgroupstats\AdGroupStatsReport;

class StatsGrouper {

    public function body(AdGroupStatsReport $stats_report) {
        $stats_bodies = array();
        foreach ($stats_report as $stats) {
            $stats_body = $this->getStatsByBody($stats, $stats->body);

            if (isset($stats_bodies[$stats_body->object_id])) {
                $stats_bodies[$stats_body->object_id]->merge($stats);
            } else {
                $stats_bodies[$stats_body->object_id] = clone $stats;
            }
        }

        $stats_report->purgeStats();
        foreach ($stats_bodies as $stats_body) {
            $stats_report->addStats($stats_body);
        }

        return $stats_report;
    }

    /**
     * @param AdGroupStatsReport $stats
     * @param string             $body
     *
     * @return AdGroupStats
     */
    private function getStatsByBody($stats, $body) {
        foreach ($stats as $_stats) {
            /* @var AdGroupStats $stats */
            if ($_stats->body == $body) {
                return $_stats;
            }
        }

        return null;
    }

}