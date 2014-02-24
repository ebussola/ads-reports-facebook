<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Shinagawa
 * Date: 20/02/14
 * Time: 11:24
 */

namespace ebussola\ads\reports\facebook;

abstract class AbstractStats extends \ebussola\ads\reports\stats\Stats implements Stats {

    private $stats;

    public $social_impressions;
    public $social_clicks;
    public $unique_impressions;
    public $unique_clicks;
    public $unique_social_impressions;
    public $unique_social_clicks;
    public $app_engagement;
    public $app_story;
    public $page_engagement;
    public $post_engagement;
    public $offsite_conversion;
    public $app_custom_event;

    public function __construct($stats) {
        $this->stats = $stats;

        $this->time_start = new \DateTime($stats->date_start);
        $this->time_end = new \DateTime($stats->date_stop);
        $this->clicks = &$stats->clicks;
        $this->impressions = &$stats->impressions;
        $this->cost = &$stats->spend;

        $this->social_impressions = &$stats->social_impressions;
        $this->social_clicks = &$stats->social_clicks;
        $this->unique_impressions = &$stats->unique_impressions;
        $this->unique_clicks = &$stats->unique_clicks;
        $this->unique_social_impressions = &$stats->unique_social_impressions;
        $this->unique_social_clicks = &$stats->unique_social_clicks;
        $this->app_engagement = &$stats->actions[$this->findActionIndex($stats->actions, 'app_engagement')]->value;
        $this->app_story = &$stats->actions[$this->findActionIndex($stats->actions, 'app_story')]->value;
        $this->page_engagement = &$stats->actions[$this->findActionIndex($stats->actions, 'page_engagement')]->value;
        $this->post_engagement = &$stats->actions[$this->findActionIndex($stats->actions, 'post_engagement')]->value;
        $this->offsite_conversion = &$stats->actions[$this->findActionIndex($stats->actions, 'offsite_conversion')]->value;
        $this->app_custom_event = &$stats->actions[$this->findActionIndex($stats->actions, 'app_custom_event')]->value;
    }

    /**
     * @param Stats $stats
     *
     * @return Stats
     */
    public function merge(\ebussola\ads\reports\Stats $stats) {
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

        parent::merge($stats);
    }

    private function findActionIndex($actions, $action_type) {
        foreach ($actions as $i => $action) {
            if ($action->action_type == $action_type) {
                return $i;
            }
        }

        return false;
    }

}