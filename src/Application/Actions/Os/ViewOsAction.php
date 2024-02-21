<?php

declare(strict_types=1);

namespace App\Application\Actions\Os;

use App\Models\Os\OsModel;
use App\Models\Role\RoleModel;
use Slim\Views\Twig;
use App\Models\Job\JobModel;
use App\Application\Actions\Action;

use Psr\Http\Message\ResponseInterface as Response;

class ViewOsAction extends Action
{




    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
    
      
        $all = OsModel::all();
     
        $roles = RoleModel::all();
        $job_list = JobModel::all();
        $tree = $this->buildTree(is_array($all['result'])? $all['result'] : [$all['result']] );

        return $this->view->render(
            $this->response,
            'os/view.twig',
            [ 'tree' => $tree, 'roles' => $roles['result'], 'job_list' => $job_list['result'] ]
      
        );

       

    }
    private function buildTree(array $array,int $parentId = 0) {
        $tree = array();
    
        foreach ($array as $element) {
            if ($element->parent_id == $parentId) {
                $children = $this->buildTree($array, $element->id);
                if ($children) {
                    $element->children = $children;
                }
                $tree[] = $element;
            }
        }
    
        return $tree;
    }

}
