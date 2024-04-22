<?php

namespace Pupuga\Core\Db;

use Pupuga;
use Pupuga\Libs\Arrays;

class getData
{
	protected $sql;
	private $wpdb;
	private static $instance;

    function __construct()
    {
		global $wpdb;
		$this->wpdb = $wpdb;
	}

    /**
     * @return $this
     */
    public static function app()
    {
        self::$instance = new self();
        return self::$instance;
    }

	/**
	 * sets $sql
	 *
	 * @param string $sql
	 *
	 * @return $this
	 */
    public function sql($sql)
    {
        $this->sql = $this->sqlPrepare($sql);

		return $this;
	}

    public function sqlPrepare($sql)
    {
        $prepareArray = array(
            'table.options' => $this->wpdb->options
        );
        $array = Arrays\Transform::arrayToKeysValues($prepareArray);
        $sql = str_replace($array['keys'], $array['values'], $sql);


        return $sql;
    }

	/**
	 * gets all results
	 *
	 * @return array $results
	 */
    public function getResults()
    {
		$results = $this->wpdb->get_results($this->sql);
		return $results;
	}

}
