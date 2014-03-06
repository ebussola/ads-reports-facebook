<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Shinagawa
 * Date: 24/02/14
 * Time: 14:44
 */

class AbstractStatsTest extends PHPUnit_Framework_TestCase {

    protected function genCampaignStats() {
        $stats = new stdClass();
        $stats->campaign_id = uniqid();
        $stats->date_start = date('Y-m-d', strtotime('- '.rand(15, 30).' days'));
        $stats->date_stop = date('Y-m-d', strtotime('- '.rand(1, 15).' days'));
        $stats->impressions = rand(100, 10000);
        $stats->clicks = rand(0, 1000);
        $stats->social_impressions = rand(0, 1000);
        $stats->social_clicks = rand(0, 1000);
        $stats->unique_impressions = rand(0, 1000);
        $stats->unique_clicks = rand(0, 1000);
        $stats->unique_social_impressions = rand(0, 1000);
        $stats->unique_social_clicks = rand(0, 1000);

        $stats->actions[0] = new stdClass();
        $stats->actions[0]->action_type = 'app_engagement';
        $stats->actions[0]->value = rand(0, 1000);

        $stats->actions[1] = new stdClass();
        $stats->actions[1]->action_type = 'app_story';
        $stats->actions[1]->value = rand(0, 1000);

        $stats->actions[2] = new stdClass();
        $stats->actions[2]->action_type = 'page_engagement';
        $stats->actions[2]->value = rand(0, 1000);

        $stats->actions[3] = new stdClass();
        $stats->actions[3]->action_type = 'post_engagement';
        $stats->actions[3]->value = rand(0, 1000);

        $stats->actions[4] = new stdClass();
        $stats->actions[4]->action_type = 'offsite_conversion';
        $stats->actions[4]->value = rand(0, 1000);

        $stats->actions[5] = new stdClass();
        $stats->actions[5]->action_type = 'app_custom_event';
        $stats->actions[5]->value = rand(0, 1000);

        $stats->spend = rand(0, 1000);
        $stats->campaign_name = 'Teste Campanha';

        return $stats;
    }

    protected function genAdGroupStats() {
        $stats = new stdClass();
        $stats->adgroup_id = uniqid();
        $stats->date_start = date('Y-m-d', strtotime('- '.rand(15, 30).' days'));
        $stats->date_stop = date('Y-m-d', strtotime('- '.rand(1, 15).' days'));
        $stats->impressions = rand(100, 10000);
        $stats->clicks = rand(0, 1000);
        $stats->social_impressions = rand(0, 1000);
        $stats->social_clicks = rand(0, 1000);
        $stats->unique_impressions = rand(0, 1000);
        $stats->unique_clicks = rand(0, 1000);
        $stats->unique_social_impressions = rand(0, 1000);
        $stats->unique_social_clicks = rand(0, 1000);

        $stats->actions[0] = new stdClass();
        $stats->actions[0]->action_type = 'comment';
        $stats->actions[0]->value = rand(0, 1000);

        $stats->actions[1] = new stdClass();
        $stats->actions[1]->action_type = 'like';
        $stats->actions[1]->value = rand(0, 1000);

        $stats->actions[2] = new stdClass();
        $stats->actions[2]->action_type = 'link_click';
        $stats->actions[2]->value = rand(0, 1000);

        $stats->actions[3] = new stdClass();
        $stats->actions[3]->action_type = 'photo_view';
        $stats->actions[3]->value = rand(0, 1000);

        $stats->actions[4] = new stdClass();
        $stats->actions[4]->action_type = 'post';
        $stats->actions[4]->value = rand(0, 1000);

        $stats->actions[5] = new stdClass();
        $stats->actions[5]->action_type = 'post_like';
        $stats->actions[5]->value = rand(0, 1000);

        $stats->actions[6] = new stdClass();
        $stats->actions[6]->action_type = 'video_play';
        $stats->actions[6]->value = rand(0, 1000);

        $stats->actions[7] = new stdClass();
        $stats->actions[7]->action_type = 'video_view';
        $stats->actions[7]->value = rand(0, 1000);

        $stats->actions[8] = new stdClass();
        $stats->actions[8]->action_type = 'app_engagement';
        $stats->actions[8]->value = rand(0, 1000);

        $stats->actions[9] = new stdClass();
        $stats->actions[9]->action_type = 'app_story';
        $stats->actions[9]->value = rand(0, 1000);

        $stats->actions[10] = new stdClass();
        $stats->actions[10]->action_type = 'page_engagement';
        $stats->actions[10]->value = rand(0, 1000);

        $stats->actions[11] = new stdClass();
        $stats->actions[11]->action_type = 'post_engagement';
        $stats->actions[11]->value = rand(0, 1000);

        $stats->actions[12] = new stdClass();
        $stats->actions[12]->action_type = 'offsite_conversion';
        $stats->actions[12]->value = rand(0, 1000);

        $stats->actions[13] = new stdClass();
        $stats->actions[13]->action_type = 'app_custom_event';
        $stats->actions[13]->value = rand(0, 1000);

        $stats->spend = rand(0, 1000);
        $stats->adgroup_name = 'Teste AdGroup';

        return $stats;
    }

}