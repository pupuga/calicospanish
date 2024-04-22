<?php

namespace Pupuga\Modules\Sitemap;

final class DataSecure
{
    private static $instance;
    private $membershipsOption;

    private function __construct()
    {
        $this->getData();
    }

    /**
     * @return $this
     */
    public static function app()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getData()
    {
        $this->membershipsOption = get_option('wc_memberships_rules');

        return $this;
    }

    public function getIds()
    {
        $ids = $this->getPosts();

        return $ids;
    }

    public function getPosts(): array
    {
        $ids = array();
        foreach ($this->membershipsOption as $item) {
            if (isset($item['object_ids']) && is_array($item['object_ids'])) {
                foreach ($item['object_ids'] as $id) {
                    $ids[$id] = $id;
                }
            }
        };

        return $ids;
    }
}