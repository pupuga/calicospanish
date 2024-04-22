<?php

namespace Pupuga\Custom\ThemeMethods;

use Pupuga\Modules\Calicosources\User;

class GetFile {

    protected $idFiles;

    public function __construct()
    {
        $userId = get_current_user_id();
        if(User::app($userId)->isMember()) {
            add_filter('request', array($this, 'request'), 1, 1);
        }
    }

    public function request($query)
    {
        if (is_array($query) && isset($query['name']) && ($query['name'] == 'filesource' || $query['name'] == 'filesource-view') && isset($query['page']) && !empty($query['page']))  {
            $id = intval($query['page']);
            $file = get_attached_file($id);
            $fileName = strtolower(basename($file));
            $pathPats = pathinfo($file);
            if ($pathPats['extension'] == 'pdf') {
                $hash = md5($id);
                $contentDisposition = ($query['name'] == 'filesource-view') ? 'inline' : 'attachment';
                header('Content-type: application/pdf');
                header('Content-Disposition: ' . $contentDisposition . '; filename=calicospanish-' . $fileName);
                echo file_get_contents($file);
            }

            exit;
        }

        return $query;
    }

}

new GetFile();