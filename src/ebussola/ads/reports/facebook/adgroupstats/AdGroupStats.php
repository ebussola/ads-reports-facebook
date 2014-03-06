<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Shinagawa
 * Date: 25/02/14
 * Time: 11:29
 */

namespace ebussola\ads\reports\facebook\adgroupstats;


use ebussola\ads\reports\facebook\AbstractStats;
use ebussola\facebook\ads\AdGroup;
use ebussola\facebook\ads\Creative;

class AdGroupStats extends AbstractStats implements \ebussola\ads\reports\facebook\AdGroupStats {

    public $body;
    public $image_url;
    public $title;
    public $comment;
    public $like;
    public $link_click;
    public $photo_view;
    public $post;
    public $post_like;
    public $video_play;
    public $video_view;

    public function __construct($stats, Creative $creative) {
        parent::__construct($stats);

        $this->object_id = &$stats->adgroup_id;

        if (!property_exists($creative, 'body')) {
            $creative->body = $creative->name;
            $creative->name = $stats->adgroup_name;
            $creative->title = $stats->adgroup_name;
        }

        if ($creative->image_url == null) {
            $creative->image_url = 'https://graph.facebook.com/'.$creative->object_id.'/picture?type=normal';
        }

        $this->name = &$creative->name;
        $this->body = &$creative->body;
        $this->image_url = &$creative->image_url;
        $this->title = &$creative->title;
        $this->comment = &$stats->actions[$this->findActionIndex($stats->actions, 'comment')]->value;
        $this->like = &$stats->actions[$this->findActionIndex($stats->actions, 'like')]->value;
        $this->link_click = &$stats->actions[$this->findActionIndex($stats->actions, 'link_click')]->value;
        $this->photo_view = &$stats->actions[$this->findActionIndex($stats->actions, 'photo_view')]->value;
        $this->post = &$stats->actions[$this->findActionIndex($stats->actions, 'post')]->value;
        $this->post_like = &$stats->actions[$this->findActionIndex($stats->actions, 'post_like')]->value;
        $this->video_play = &$stats->actions[$this->findActionIndex($stats->actions, 'video_play')]->value;
        $this->video_view = &$stats->actions[$this->findActionIndex($stats->actions, 'video_view')]->value;
    }

    /**
     * @param \ebussola\ads\reports\facebook\AdGroupStats $stats
     */
    public function merge(\ebussola\ads\reports\Stats $stats) {
        $this->object_id = $this->object_id . ' + ' . $stats->object_id;
        $this->name = $this->name . ' + ' . $stats->name;
        $this->comment = $this->comment + $stats->comment;
        $this->like = $this->like + $stats->like;
        $this->link_click = $this->link_click + $stats->link_click;
        $this->photo_view = $this->photo_view + $stats->photo_view;
        $this->post = $this->post + $stats->post;
        $this->post_like = $this->post_like + $stats->post_like;
        $this->video_play = $this->video_play + $stats->video_play;
        $this->video_view = $this->video_view + $stats->video_view;

        parent::merge($stats);
    }

}