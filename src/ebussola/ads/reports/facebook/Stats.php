<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Shinagawa
 * Date: 20/02/14
 * Time: 11:27
 */

namespace ebussola\ads\reports\facebook;

/**
 * Interface Stats
 * @package ads\reports\facebook
 *
 * @property int $social_impressions
 * @property int $social_clicks
 * @property int $unique_impressions
 * @property int $unique_clicks
 * @property int $unique_social_impressions
 * @property int $unique_social_clicks
 *
 * old actions
 * @property int $app_engagement
 * @property int $app_story
 * @property int $page_engagement
 * @property int $post_engagement
 * @property int $offsite_conversion
 * @property int $app_custom_event
 */
interface Stats extends \ebussola\ads\reports\Stats {

}