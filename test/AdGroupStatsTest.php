<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Shinagawa
 * Date: 25/02/14
 * Time: 14:15
 */

class AdGroupStatsTest extends AbstractStatsTest {

    /**
     * @var \ebussola\facebook\ads\Ads
     */
    private $ads;

    /**
     * @var \ebussola\ads\reports\facebook\Facebook
     */
    private $facebook;

    public function setUp() {
        $config = include __DIR__ . '/config.php';

        $access_token_data = new AccessTokenData();
        $access_token_data->setLongAccessToken($config['long_access_token'], 3600);

        $core = new \ebussola\facebook\core\Core($config['app_id'], $config['secret'], $config['redirect_uri'], $access_token_data);
        $this->ads = new \ebussola\facebook\ads\Ads($core);
        $this->facebook = new \ebussola\ads\reports\facebook\Facebook($this->ads, $config['account_id']);
    }

    public function testConstruct() {
        $creative = unserialize('O:39:"ebussola\facebook\ads\creative\Creative":1:{s:49:" ebussola\facebook\ads\creative\Creative creative";O:8:"stdClass":6:{s:4:"name";s:59:"Histórico de opção "Curtir" de página nº 6004287241222";s:4:"type";i:9;s:9:"object_id";i:203064416403027;s:9:"image_url";s:0:"";s:11:"preview_url";s:71:"https://www.facebook.com/ads/api/creative_preview.php?cid=6004287241222";s:2:"id";s:13:"6004287241222";}}');
        $adgroup_stats = new \ebussola\ads\reports\facebook\adgroupstats\AdGroupStats($this->genAdGroupStats(), $creative);
        $adgroup_stats->refreshValues();

        $this->assertNotNull($adgroup_stats->impressions);
        $this->assertNotNull($adgroup_stats->app_custom_event);
        $this->assertNotNull($adgroup_stats->app_engagement);
        $this->assertNotNull($adgroup_stats->app_story);
        $this->assertNotNull($adgroup_stats->offsite_conversion);
        $this->assertNotNull($adgroup_stats->page_engagement);
        $this->assertNotNull($adgroup_stats->post_engagement);
        $this->assertNotNull($adgroup_stats->social_clicks);
        $this->assertNotNull($adgroup_stats->social_impressions);
        $this->assertNotNull($adgroup_stats->unique_clicks);
        $this->assertNotNull($adgroup_stats->unique_impressions);
        $this->assertNotNull($adgroup_stats->unique_social_clicks);
        $this->assertNotNull($adgroup_stats->unique_social_impressions);
        $this->assertNotNull($adgroup_stats->clicks);
        $this->assertNotNull($adgroup_stats->cost);
        $this->assertNotNull($adgroup_stats->comment);
        $this->assertNotNull($adgroup_stats->like);
        $this->assertNotNull($adgroup_stats->link_click);
        $this->assertNotNull($adgroup_stats->photo_view);
        $this->assertNotNull($adgroup_stats->post);
        $this->assertNotNull($adgroup_stats->post_like);
        $this->assertNotNull($adgroup_stats->video_play);
        $this->assertNotNull($adgroup_stats->video_view);
    }

    public function testMerge() {
        $creative = unserialize('O:39:"ebussola\facebook\ads\creative\Creative":1:{s:49:" ebussola\facebook\ads\creative\Creative creative";O:8:"stdClass":6:{s:4:"name";s:59:"Histórico de opção "Curtir" de página nº 6004287241222";s:4:"type";i:9;s:9:"object_id";i:203064416403027;s:9:"image_url";s:0:"";s:11:"preview_url";s:71:"https://www.facebook.com/ads/api/creative_preview.php?cid=6004287241222";s:2:"id";s:13:"6004287241222";}}');
        $adgroup_stats1 = new \ebussola\ads\reports\facebook\adgroupstats\AdGroupStats($this->genAdGroupStats(), $creative);
        $adgroup_stats1->refreshValues();

        $adgroup_stats2 = new \ebussola\ads\reports\facebook\adgroupstats\AdGroupStats($this->genAdGroupStats(), $creative);
        $adgroup_stats2->refreshValues();

        $adgroup_stats1->merge($adgroup_stats2);

        $this->assertGreaterThan($adgroup_stats2->impressions, $adgroup_stats1->impressions);
        $this->assertGreaterThan($adgroup_stats2->app_custom_event, $adgroup_stats1->app_custom_event);
        $this->assertGreaterThan($adgroup_stats2->app_engagement, $adgroup_stats1->app_engagement);
        $this->assertGreaterThan($adgroup_stats2->app_story, $adgroup_stats1->app_story);
        $this->assertGreaterThan($adgroup_stats2->offsite_conversion, $adgroup_stats1->offsite_conversion);
        $this->assertGreaterThan($adgroup_stats2->page_engagement, $adgroup_stats1->page_engagement);
        $this->assertGreaterThan($adgroup_stats2->post_engagement, $adgroup_stats1->post_engagement);
        $this->assertGreaterThan($adgroup_stats2->social_clicks, $adgroup_stats1->social_clicks);
        $this->assertGreaterThan($adgroup_stats2->social_impressions, $adgroup_stats1->social_impressions);
        $this->assertGreaterThan($adgroup_stats2->unique_clicks, $adgroup_stats1->unique_clicks);
        $this->assertGreaterThan($adgroup_stats2->unique_impressions, $adgroup_stats1->unique_impressions);
        $this->assertGreaterThan($adgroup_stats2->unique_social_clicks, $adgroup_stats1->unique_social_clicks);
        $this->assertGreaterThan($adgroup_stats2->unique_social_impressions, $adgroup_stats1->unique_social_impressions);
        $this->assertGreaterThan($adgroup_stats2->clicks, $adgroup_stats1->clicks);
        $this->assertGreaterThan($adgroup_stats2->cost, $adgroup_stats1->cost);
        $this->assertGreaterThan($adgroup_stats2->comment, $adgroup_stats1->comment);
        $this->assertGreaterThan($adgroup_stats2->like, $adgroup_stats1->like);
        $this->assertGreaterThan($adgroup_stats2->link_click, $adgroup_stats1->link_click);
        $this->assertGreaterThan($adgroup_stats2->photo_view, $adgroup_stats1->photo_view);
        $this->assertGreaterThan($adgroup_stats2->post, $adgroup_stats1->post);
        $this->assertGreaterThan($adgroup_stats2->post_like, $adgroup_stats1->post_like);
        $this->assertGreaterThan($adgroup_stats2->video_play, $adgroup_stats1->video_play);
        $this->assertGreaterThan($adgroup_stats2->video_view, $adgroup_stats1->video_view);
    }

}