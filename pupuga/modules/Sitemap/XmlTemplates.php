<?php

namespace Pupuga\Modules\Sitemap;

final class XmlTemplates
{
    private $list;
    private $columns;
    private $options;
    private $sitemap = '';
    private $xmlRow = '
        <url>
            <loc>%%loc%%</loc>
            <lastmod>%%lastmod%%</lastmod>
            <changefreq>%%changefreq%%</changefreq>
            <priority>%%priority%%</priority>
        </url>';
    private $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">%%sitemap%%
        </urlset>';

    public function __construct($list, $columns, $options)
    {
        $this->list = $list;
        $this->columns = $columns;
        $this->options = $options;
        $this->setSiteMap();
    }

    private function setSiteMap()
    {
        foreach ($this->list as $item) {
            if (!in_array($item->id, $this->options['excluded'])) {
                $period = (isset($this->options['changed']->period->{$item->id})) ? $this->options['changed']->period->{$item->id} : $this->columns['period']['default'];
                $priority = (isset($this->options['changed']->priority->{$item->id})) ? $this->options['changed']->priority->{$item->id} : $this->columns['priority']['default'];
                $this->sitemap .= str_replace(
                    array('%%loc%%', '%%lastmod%%', '%%changefreq%%', '%%priority%%'),
                    array(get_permalink($item->id), $item->date . 'T00:01:00+00:00', $period, $priority),
                    $this->xmlRow
                );
            };
        }
    }

    public function getXml()
    {
        $xml = str_replace('%%sitemap%%', $this->sitemap, $this->xml);

        return $xml;
    }
}