<?php
namespace EngBlogs;

use SimpleXMLElement;

class XmlParser {
    private SimpleXMLElement $simpleXMLElement;
    private Blog $blog;

    function __construct(SimpleXMLElement $simpleXMLElement, Blog $blog) {
        $this->simpleXMLElement = $simpleXMLElement;
        $this->blog = $blog;
    }

    private function parsePostItem($xmlItem): Post {
        $title = (string) $xmlItem->title;
        $categories = [];
        $link = (string) $xmlItem->link;
        $pubDate = $xmlItem->pubDate;
        $description = $xmlItem->description;

        $post = new Post();
        $post->setTitle($title)
            ->setLink($link)
            ->setBlog($this->blog)
            ->setCategories($categories)
            ->setDescription($description)
            ->setPublishDate($pubDate);

        return $post;
    }

    private function parseXml(): array {
        $posts = [];
        foreach($this->simpleXMLElement->channel->item as $item){
            $post = $this->parsePostItem($item);
            $posts[] = $post->serialize();
        }

        return $posts;
    }

    public function getPosts(): array {
        return $this->parseXml();
    }
}
