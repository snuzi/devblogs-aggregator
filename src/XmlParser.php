<?php
namespace EngBlogs;

class XmlParser {

    private SimpleXMLElement $simpleXMLElement;

    function __construct(SimpleXMLElement $simpleXMLElement) {
        $this->simpleXMLElement = $simpleXMLElement;
    }

    private function parsePostItem(string $xmlItem): Post {
        $title = (string) $xmlItem->title;
        $categories = (string) $xmlItem->categories;
        $link = (string) $xmlItem->link;
        $pubDate = $xmlItem->pubDate;

        $post = new Post();
        $post->setTitle($title);
        $post->setLink($link);

        return $post;
    }

    private function parseXml(): array {
        $posts = [];
        foreach($this->simpleXMLElement->channel->item as $item){
            $posts[] = $this->parsePostItem($item);
        }
    }

    public function getPosts(): array {
        
    }
}
