<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Shinagawa
 * Date: 17/02/14
 * Time: 14:36
 */

namespace ebussola\ads\reports\facebook;

use ebussola\ads\reports\facebook\adgroupstats\AdGroupStats;
use ebussola\ads\reports\facebook\adgroupstats\AdGroupStatsReport;
use ebussola\ads\reports\facebook\campaignstats\CampaignStatsReport;
use ebussola\ads\reports\Reports;
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
        $stats_report = $this->_createDailyCampaignStats($campaign_ids, $date_start, $date_end);

        $campaign_stats = [];
        foreach ($stats_report as $_stats) {
            if (!isset($campaign_stats[$_stats->object_id])) {
                $campaign_stats[$_stats->object_id] = new CampaignStatsReport();
            }
            /** @noinspection PhpUndefinedMethodInspection */
            $campaign_stats[$_stats->object_id]->addStats($_stats);
        }

        return $campaign_stats;
    }

    /**
     * @param string[]  $campaign_ids
     * @param \DateTime $date_start
     * @param \DateTime $date_end
     *
     * @return StatsReport[]
     */
    public function createConsolidatedDailyCampaignStats($campaign_ids, \DateTime $date_start, \DateTime $date_end) {
        $stats_report = $this->_createDailyCampaignStats($campaign_ids, $date_start, $date_end);

        $ads_reports = new Reports();
        $ads_reports->groupBy('date', $stats_report);

        return $stats_report;
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

    /**
     * @param string[]  $ad_group_ids
     * @param \DateTime $start_date
     * @param \DateTime $end_date
     * @param bool      $group_similar_ads
     *
     * @return AdGroupStatsReport
     */
    public function createAdStats($ad_group_ids, \DateTime $start_date, \DateTime $end_date, $group_similar_ads) {
        $groups = $this->ads->getAdGroups($ad_group_ids);

        $creative_ids = [];
        foreach ($groups as $group) {
            foreach ($group->creative_ids as $creative_id) {
                $creative_ids[] = $creative_id;
            }
        }
        $creatives = $this->ads->getCreatives($creative_ids);

        $data_columns = $this->getAdFields();
        $filters = array(
            ReportStatsHelper::createFilter('adgroup_id', 'in', $ad_group_ids)
        );
        $stats = $this->ads->getReportStats($this->account_id, $data_columns, $filters, $start_date, $end_date);

        $this->completeGroupObj($groups, $creatives, $stats);

        // build ad_stats
        $adgroup_stats_report = new AdGroupStatsReport();
        foreach ($groups as $group) {
            $creative = reset($group->creatives);
            $stats = new AdGroupStats($group->stats, $creative);
            $stats->refreshValues();

            $adgroup_stats_report->addStats($stats);
        }

        if ($group_similar_ads) {
            $reports = new Reports(new StatsGrouper());
            $reports->groupBy('body', $adgroup_stats_report);
        }

        return $adgroup_stats_report;
    }

    /**
     * @deprecated
     *
     * @param      $groups
     * @param      $creatives
     * @param null $stats
     *
     * @return mixed
     */
    private function completeGroupObj($groups, $creatives, $stats=null) {
        foreach ($groups as $group) {
            $group->creatives = [];
            foreach ($group->creative_ids as $creative_id) {
                foreach ($creatives as $creative) {
                    if ($creative->id == $creative_id) {
                        $group->creatives[] = $creative;
                    }
                }
            }
        }

        if ($stats != null) {
            foreach ($groups as $group) {
                $group->stats = null;
                foreach ($stats as $_stats) {
                    if ($_stats->adgroup_id == $group->id) {
                        $group->stats = $_stats;
                        continue;
                    }
                }
            }
        }

        return $groups;
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

    /**
     * @param           $campaign_ids
     * @param \DateTime $date_start
     * @param \DateTime $date_end
     * @param           $stats_data
     *
     * @return array
     */
    private function _createDailyCampaignStats($campaign_ids, \DateTime $date_start, \DateTime $date_end) {
        $data_columns = $this->getCampaignFields();
        $filters = array(
            ReportStatsHelper::createFilter('campaign_id', 'in', $campaign_ids)
        );

        $stats = $this->ads->getDailyReportStats($this->account_id, $data_columns, $filters, $date_start, $date_end);

        $stats_report = new CampaignStatsReport();
        foreach ($stats as $stats_data) {
            $stats = new \ebussola\ads\reports\facebook\campaignstats\CampaignStats($stats_data);
            $stats->refreshValues();

            $stats_report->addStats($stats);
        }

        return $stats_report;
    }

}