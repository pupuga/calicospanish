<?php

namespace Pupuga\Modules\Amp;

use Pupuga\Core\Db\getData;

abstract class Page
{
    protected static $instance;
    protected $post;
    protected $taxonomy;
    protected $urlAmp = null;
    protected $find;
    protected $template;
    protected $initObject;

    abstract public function init();

    abstract protected function action();

    /**
     * @param Init $object
     */
    protected function __construct(Init $object)
    {
        $this->initObject = $object;
    }

    protected function checkPage()
    {
        if (!is_front_page()) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    protected function setItemObject($id = null)
    {
        if ($this->checkPage()) {
            if (is_null($id)) {
                global $post;
                $this->post = $post;
            } else {
                $this->post = get_post($id);
            }
            $amp = $this->initObject->getAmp();
            if (isset($amp['taxonomy']) && is_array($amp['taxonomy']) && count($amp['taxonomy']) > 0) {
                $this->taxonomy = $this->getTermsByItemId($this->post->ID);
            }

            if ($this->findPost()) {
                $this->action();
            } elseif(!is_null($id)) {
                wp_redirect(home_url());
                exit();
            }
        }
    }

    protected function getTermsByItemId($id)
    {
        $find = false;
        if ($id) {
            global $wpdb;
            $sql =
                'SELECT tt.taxonomy ' .
                'FROM ' . $wpdb->term_relationships . ' tr ' .
                'INNER JOIN ' . $wpdb->terms . ' t ' .
                'ON tr.term_taxonomy_id = t.term_id ' .
                'INNER JOIN wp_term_taxonomy tt ' .
                'ON t.term_id = tt.term_taxonomy_id ' .
                'WHERE tr.object_id = ' . $id . ' '.
                'GROUP BY tt.taxonomy';
            $results = getData::app()->sql($sql)->getResults();
            $find = $results[0];
        }

        return $find;
    }

    protected function findPost()
    {
        $find = false;
        $filters = array(
            'type',
            'taxonomy',
            'id'
        );
        for ($i = 0; $i < count($filters) && $find == false; $i++) {
            $find = $this->filterPost($filters[$i]);
            if ($find) {
                $this->find = $filters[$i];
            }
        }

        return $this->find;
    }

    protected function filterPost($filter)
    {
        $result = false;
        $find = false;
        switch ($filter) {
            case 'type':
                $find = $this->post->post_type;
                break;
            case 'taxonomy':
                $find = $this->taxonomy;
                break;
            case 'id':
                $find = $this->post->ID;
                break;
        }

        $amp = $this->initObject->getAmp();
        if (isset($amp[$filter]) && $find && $amp[$filter][$find]) {
            $typeFilter = $amp[$filter];
            $this->template = $typeFilter[$find];
            $result = true;
        }

        return $result;
    }


    protected function createAmpUrl()
    {
        if ($this->post || is_null($this->urlAmp)) {
            $urlCurrent = rtrim(get_permalink($this->post->id), '/');
            $exchange = $this->initObject->getExchange();
            foreach ($exchange as $search => $replace){
                $urlCurrent = str_replace('/'.$search.'/', '/'.$replace.'/', $urlCurrent);
            }
            $urlStart = home_url() . '/' . $this->post->post_type;
            if ($this->post->post_type != 'page' && $this->post->post_type != 'post' && strpos($urlCurrent, $urlStart) === false){
                $this->urlAmp = str_replace(home_url(), $urlStart , $urlCurrent) . '/amp/';
            } else {
                $this->urlAmp = $urlCurrent . '/amp/';
            }
        } else {
            $this->urlAmp = '';
        }

        return $this->urlAmp;
    }

    protected function clearAmpUrl()
    {
        $request = explode('/', trim(urldecode($_SERVER['REQUEST_URI']), '/'));
        unset($request[count($request) - 1]);
        $url = '/' . implode('/', $request) . '/';

        return $url;
    }
}