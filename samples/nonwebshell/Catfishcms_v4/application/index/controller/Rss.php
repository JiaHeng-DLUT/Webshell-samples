<?php
/**
 * Project: Catfish.
 * Author: A.J
 * Date: 2017/8/9
 */
namespace app\index\controller;

use think\Controller;

class Rss extends Controller
{
    private $channel;
    private $currentItem;
    private $rss;
    private $dom;
    public function _initialize()
    {
        $this->dom = new \DOMDocument('1.0', 'UTF-8');
        $this->dom->formatOutput = true;
        $rssElement = $this->dom->createElement( 'rss' );
        $rssElement->setAttribute( 'version', '2.0' );
        $this->rss = $this->dom->appendChild( $rssElement );
    }
    public function addChannel() {
        $channelElement = $this->dom->createElement( 'channel' );
        $this->channel = $this->rss->appendChild( $channelElement );
    }
    public function addChannelElement( $element, $value, $attr = array() ) {
        $element = $this->dom->createElement( $element, $value );
        foreach ( $attr as $key => $value )
            $element->setAttribute( $key, $value );
        $this->channel->appendChild( $element );
    }
    public function addChannelElementWithSub( $element, $sub ) {
        $element = $this->dom->createElement( $element );
        foreach ( $sub as $key => $value ) {
            $subElement = $this->dom->createElement( $key, $value );
            $element->appendChild( $subElement );
        }
        $this->channel->appendChild( $element );
    }
    public function addItem() {
        $item = $this->dom->createElement( 'item' );
        $this->currentItem = $this->channel->appendChild( $item );
    }
    public function addItemElement( $element, $value, $attr = array() ) {
        $element = $this->dom->createElement( $element, $value );
        foreach ( $attr as $key => $value )
            $element->setAttribute( $key, $value );
        $this->currentItem->appendChild( $element );
    }
    public function toString() {
        return $this->dom->saveXML();
    }
}