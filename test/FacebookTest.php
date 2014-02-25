<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Shinagawa
 * Date: 24/02/14
 * Time: 16:03
 */

class FacebookTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \ebussola\ads\reports\facebook\Facebook
     */
    private $facebook;

    /**
     * @var \ebussola\facebook\ads\Ads
     */
    private $ads;

    public function setUp() {
        $config = include __DIR__ . '/config.php';

        $access_token_data = new AccessTokenData();
        $access_token_data->setLongAccessToken($config['long_access_token'], 3600);

        $core = new \ebussola\facebook\core\Core($config['app_id'], $config['secret'], $config['redirect_uri'], $access_token_data);
        $this->ads = new \ebussola\facebook\ads\Ads($core);
        $this->facebook = new \ebussola\ads\reports\facebook\Facebook($this->ads, $config['account_id']);
    }

    public function testCreateDailyCampaignStats() {
        $config = include __DIR__ . '/config.php';

        $campaigns = $this->ads->getAdSetsFromAccount($config['account_id']);
        $campaign_ids = \ebussola\facebook\ads\adcampaign\AdCampaignHelper::extractIds($campaigns);

        $daily_campaign_reports = $this->facebook->createDailyCampaignStats($campaign_ids, new DateTime('-30 days'), new DateTime('today'));
        foreach ($daily_campaign_reports as $daily_campaign_report) {
            $this->assertInstanceOf('\ebussola\ads\reports\facebook\campaignstats\CampaignStatsReport', $daily_campaign_report);

            foreach ($daily_campaign_report as $daily_campaign_stats) {
                $this->assertInstanceOf('\ebussola\ads\reports\facebook\CampaignStats', $daily_campaign_stats);
            }
        }
    }

}