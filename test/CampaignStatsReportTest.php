<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Shinagawa
 * Date: 24/02/14
 * Time: 14:43
 */

class StatsReportTest extends AbstractStatsTest {

    public function testAddStats() {
        $campaign_stats_report = new \ebussola\ads\reports\facebook\campaignstats\CampaignStatsReport();

        for ($i=0 ; $i<=500 ; $i++) {
            $campaign_stats = new \ebussola\ads\reports\facebook\campaignstats\CampaignStats($this->genCampaignStats());

            $campaign_stats_report->addStats($campaign_stats);
        }

        $this->assertNotNull($campaign_stats_report->cost);
        $this->assertNotNull($campaign_stats_report->clicks);
        $this->assertNotNull($campaign_stats_report->unique_social_impressions);
        $this->assertNotNull($campaign_stats_report->unique_social_clicks);
        $this->assertNotNull($campaign_stats_report->app_custom_event);
        $this->assertNotNull($campaign_stats_report->app_engagement);
        $this->assertNotNull($campaign_stats_report->app_story);
        $this->assertNotNull($campaign_stats_report->offsite_conversion);
        $this->assertNotNull($campaign_stats_report->page_engagement);
        $this->assertNotNull($campaign_stats_report->post_engagement);
        $this->assertNotNull($campaign_stats_report->social_clicks);
        $this->assertNotNull($campaign_stats_report->social_impressions);
        $this->assertNotNull($campaign_stats_report->unique_clicks);
        $this->assertNotNull($campaign_stats_report->unique_impressions);
        $this->assertNotNull($campaign_stats_report->time_end);
        $this->assertNotNull($campaign_stats_report->time_start);
    }

}