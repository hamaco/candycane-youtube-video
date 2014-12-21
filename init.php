<?php

$pluginContainer = ClassRegistry::getObject('PluginContainer');
$pluginContainer->installed('cc_youtube_video', '1.0.0');

App::uses('CakeEventManager', 'Event');
CakeEventManager::instance()->attach(function($event) {
    $text = preg_replace_callback('/{{youtube:(.+?)}}/', function($matches) {
        list($video_id, $width, $height) = explode(":", $matches[1]);

        App::uses('HtmlHelper', 'View/Helper');
        $helper = new HtmlHelper(new View());
        return $helper->tag('iframe', '', array(
            'src'             => '//www.youtube.com/embed/' . $video_id,
            'width'           => $width,
            'height'          => $height,
            'frameborder'     => 0,
            'allowfullscreen' => 'true',
        ));
    }, $event->data['text']);

    $event->data['text'] = $event->result['text'] = $text;
}, 'Helper.Candy.afterTextilizable');
