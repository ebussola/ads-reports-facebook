<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Shinagawa
 * Date: 17/02/14
 * Time: 14:36
 */

namespace ebussola\ads\reports\facebook;

use ebussola\ads\reports\facebook\campaignstats\CampaignStatsReport;
use ebussola\ads\reports\StatsReport;
use ebussola\facebook\ads\Ads;
use ebussola\facebook\ads\ReportStatsHelper;

class Facebook {

    /**
     * @var Ads
     */
    private $ads;

    /**
     * @var string
     */
    public $account_id;

    public function __construct(Ads $ads, $account_id) {
        $this->ads = $ads;
        $this->account_id = $account_id;
    }

    /**
     * @param string[]  $campaign_ids
     * @param \DateTime $date_start
     * @param \DateTime $date_end
     *
     * @return StatsReport[]
     */
    public function createDailyCampaignStats($campaign_ids, \DateTime $date_start, \DateTime $date_end) {
        $data_columns = $this->getCampaignFields();
        $filters = array(
            ReportStatsHelper::createFilter('campaign_id', 'in', $campaign_ids)
        );

        $stats = $this->ads->getDailyReportStats($this->account_id, $data_columns, $filters, $date_start, $date_end);
        $campaign_stats = [];
        foreach ($stats as $_stats) {
            $campaign_stats[$_stats->campaign_id][] = $_stats;
        }
        foreach ($campaign_stats as &$_campaign_stats) {
            $stats_report = new CampaignStatsReport();
            foreach ($_campaign_stats as $stats_data) {
                $stats = new \ebussola\ads\reports\facebook\campaignstats\CampaignStats($stats_data);
                $stats->refreshValues();

                $stats_report->addStats($stats);
            }

            $_campaign_stats = $stats_report;
        }

        return $campaign_stats;
    }

    /**
     * @param string[] $campaign_ids
     * @param \DateTime $start_date
     * @param \DateTime $end_date
     *
     * @return StatsReport
     */
    public function createCampaignStats($campaign_ids, \DateTime $start_date, \DateTime $end_date) {
        $data_columns = $this->getCampaignFields();
        $filters = array(
            ReportStatsHelper::createFilter('campaign_id', 'in', $campaign_ids)
        );

        $stats = $this->ads->getReportStats($this->account_id, $data_columns, $filters, $start_date, $end_date);
        $stats_report = new CampaignStatsReport();
        foreach ($stats as &$_stats) {
            $campaign_stats = new \ebussola\ads\reports\facebook\campaignstats\CampaignStats($_stats);
            $campaign_stats->refreshValues();

            $stats_report->addStats($campaign_stats);
        }

        return $stats_report;
    }

    private function getGeneralFields() {
        return array('impressions', 'clicks', 'social_impressions', 'social_clicks',
            'unique_impressions', 'unique_clicks', 'unique_social_impressions', 'unique_social_clicks',
            'actions', 'spend');
    }

    private function getCampaignFields() {
        return array_merge(array('campaign_id', 'campaign_name'), $this->getGeneralFields());
    }

    private function getAdFields() {
        return array_merge(array('adgroup_id', 'adgroup_name'), $this->getGeneralFields());
    }

}