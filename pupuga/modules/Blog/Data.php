<?php

namespace Pupuga\Modules\Blog;

use Pupuga\Core\Carbon;
use Pupuga\Core\Posts\GetPosts;
use Pupuga\Libs\Files;

class Data
{
    private $data;
    private $block;
    private $wpdb;

    public function __construct(Init $block)
    {
        global $wpdb;

    	$this->block = $block;
    	$this->wpdb = $wpdb;
    }

    public function getData()
    {
        $method = 'get' . ucfirst($this->block->atts['template']);
        if (method_exists($this, $method)) {
            $this->data = $this->$method();
        }

        return $this->data;
    }

    private function getCategories()
    {
        $data = get_categories(array(
            'type'         => 'post',
            'child_of'     => 0,
            'orderby'      => 'name',
            'order'        => 'ASC',
            'hide_empty'   => 1,
            'hierarchical' => 1,
        ));

        return $data;
    }

    private function getArchives()
    {
        $tablePosts = $this->wpdb->posts;
        $query = "
        SELECT YEAR(post_date) AS 'year', 
        MONTH(post_date) AS 'month', 
        count(ID) as posts 
        FROM {$tablePosts}
        WHERE post_type = 'post' 
        AND post_status = 'publish' 
        GROUP BY YEAR(post_date), MONTH(post_date) 
        ORDER BY post_date DESC";
        $results = $this->wpdb->get_results($query);

        if ($results) {
            $monthHtml = '';
            $yearHtml = '';
            $year = null;
            $count = 0;
            $pageYear = get_query_var('year');
            foreach ($results as $result) {
                if (!is_null($year) && $year != $result->year) {
                    $class = ($pageYear == $year) ? ' class="current"' : '';
                    $yearHtml .= get_archives_link(get_year_link($year), $year, '', '<li'.$class.'>', '<span>('.$count.')</span><ul>' .$monthHtml.'</ul></li>');
                    $monthHtml = '';
                    $count = 0;
                }
                $monthHtml .= get_archives_link(get_month_link($result->year, $result->month ), \DateTime::createFromFormat('!m', $result->month)->format('F'), 'html', '', '<span>('.$result->posts.')</span>');
                $count += $result->posts;
                $year = $result->year;
            }
            if (!empty($monthHtml)) {
                $class = ($pageYear == $year) ? ' class="current"' : '';
                $yearHtml .= get_archives_link(get_year_link($year), $year, '', '<li'.$class.'>', '<span>('.$count.')</span><ul>'.$monthHtml.'</ul>');
            }
            $yearHtml = '<ul class="pupuga-list-tree pupuga-list-tree--archives">' . $yearHtml . '</ul>';
        }

        $output = $yearHtml ?? '';

        return $output;
    }

    private function getTags()
    {
        $data = get_tags(array(
            'number'       => 8,
            'orderby'      => 'count',
            'order'        => 'DESC',
        ));

        return $data;
    }

    private function getSearch()
    {
        return ;
    }


}