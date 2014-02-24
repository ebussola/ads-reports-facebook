<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Shinagawa
 * Date: 20/02/14
 * Time: 14:29
 */

namespace ebussola\ads\reports\facebook;


use ebussola\ads\reports\statsreport\StatsReportTrait;

abstract class AbstractStatsReport extends AbstractStats implements \ebussola\ads\reports\StatsReport {
    use StatsReportTrait {
        addStats as traitAddStats;
    }

    public function __construct() {

    }

    /**
     * @param Stats $stats
     */
    public function addStats(\ebussola\ads\reports\Stats $stats) {
        $this->social_impressions = $this->social_impressions + $stats->social_impressions;
        $this->social_clicks = $this->social_clicks + $stats->social_clicks;
        $this->unique_impressions = $this->unique_impressions + $stats->unique_impressions;
        $this->unique_clicks = $this->unique_clicks + $stats->unique_clicks;
        $this->unique_social_impressions = $this->unique_social_impressions + $stats->unique_social_impressions;
        $this->unique_social_clicks = $this->unique_social_clicks + $stats->unique_social_clicks;
        $this->app_engagement = $this->app_engagement + $stats->app_engagement;
        $this->app_story = $this->app_story + $stats->app_story;
        $this->page_engagement = $this->page_engagement + $stats->page_engagement;
        $this->post_engagement = $this->post_engagement + $stats->post_engagement;
        $this->offsite_conversion = $this->offsite_conversion + $stats->offsite_conversion;
        $this->app_custom_event = $this->app_custom_event + $stats->app_custom_event;

        $this->traitAddStats($stats);
    }

}