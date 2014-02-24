<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Shinagawa
 * Date: 20/02/14
 * Time: 13:59
 */

namespace ebussola\ads\reports\facebook\campaignstats;


use ebussola\ads\reports\facebook\AbstractStats;

class CampaignStats extends AbstractStats implements \ebussola\ads\reports\facebook\CampaignStats {

    public function __construct($stats) {
        parent::__construct($stats);

        $this->object_id = &$stats->campaign_id;
        $this->name = &$stats->campaign_name;
    }

    /**
     * @param \ebussola\ads\reports\facebook\CampaignStats $stats
     *
     * @return \ebussola\ads\reports\facebook\CampaignStats
     */
    public function merge(\ebussola\ads\reports\Stats $stats) {
        $this->object_id = $this->object_id . ' + ' . $stats->object_id;
        $this->name = $this->name . ' + ' . $stats->name;

        parent::merge($stats);
    }

}