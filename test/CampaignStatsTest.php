<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Shinagawa
 * Date: 24/02/14
 * Time: 11:38
 */

class StatsTest extends AbstractStatsTest {
    
    public function testMerge() {
        $campaign_stats1 = new \ebussola\ads\reports\facebook\campaignstats\CampaignStats($this->genCampaignStats());
        $campaign_stats1->refreshValues();

        $campaign_stats2 = new \ebussola\ads\reports\facebook\campaignstats\CampaignStats($this->genCampaignStats());
        $campaign_stats2->refreshValues();
        
        $campaign_stats1->merge($campaign_stats2);

        $this->assertGreaterThan($campaign_stats2->impressions, $campaign_stats1->impressions);
        $this->assertGreaterThan($campaign_stats2->app_custom_event, $campaign_stats1->app_custom_event);
        $this->assertGreaterThan($campaign_stats2->app_engagement, $campaign_stats1->app_engagement);
        $this->assertGreaterThan($campaign_stats2->app_story, $campaign_stats1->app_story);
        $this->assertGreaterThan($campaign_stats2->offsite_conversion, $campaign_stats1->offsite_conversion);
        $this->assertGreaterThan($campaign_stats2->page_engagement, $campaign_stats1->page_engagement);
        $this->assertGreaterThan($campaign_stats2->post_engagement, $campaign_stats1->post_engagement);
        $this->assertGreaterThan($campaign_stats2->social_clicks, $campaign_stats1->social_clicks);
        $this->assertGreaterThan($campaign_stats2->social_impressions, $campaign_stats1->social_impressions);
        $this->assertGreaterThan($campaign_stats2->unique_clicks, $campaign_stats1->unique_clicks);
        $this->assertGreaterThan($campaign_stats2->unique_impressions, $campaign_stats1->unique_impressions);
        $this->assertGreaterThan($campaign_stats2->unique_social_clicks, $campaign_stats1->unique_social_clicks);
        $this->assertGreaterThan($campaign_stats2->unique_social_impressions, $campaign_stats1->unique_social_impressions);
        $this->assertGreaterThan($campaign_stats2->clicks, $campaign_stats1->clicks);
        $this->assertGreaterThan($campaign_stats2->cost, $campaign_stats1->cost);
    }

}