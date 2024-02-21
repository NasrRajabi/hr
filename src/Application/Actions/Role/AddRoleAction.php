<?php
declare(strict_types=1);
namespace App\Application\Actions\Role;

use App\Application\Actions\Action;
use App\Application\Actions\Role\Util\ColorGenerator;

use App\Models\Os\OsModel;
use App\Models\permissions\PermissionsModel;
use Psr\Http\Message\ResponseInterface as Response;

class AddRoleAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        // Get all permissions
        $all = PermissionsModel::all();
        $all = $this->_group_by($all['result']);

        $cg = new ColorGenerator();

        return $this->view->render(
            $this->response,
            'role/add.twig',
            [
                'permissions' => $all,
                'cg' => $cg
            ]
        );
    }

    function _group_by($array) {
        $return = array();
        foreach($array as $val) {
            $return[$val->group_name][] = $val;
        }
        return $return;
    }
}