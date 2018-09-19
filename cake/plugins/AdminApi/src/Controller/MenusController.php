<?php
namespace AdminApi\Controller;

use AdminApi\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Menus Controller
 *
 * @property \AdminApi\Model\Table\MenusTable $Menus
 *
 * @method \AdminApi\Model\Entity\Menu[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MenusController extends AppController
{

    /**
     * 根据用户获取菜单
     */
    public function getMenus()
    {
        if ($this->getRequest()->is('post')) {
            $user = $this->getUserInfo();
            $Menus = TableRegistry::getTableLocator()->get('AdminApi.Roles')->find()
                ->where([
                    'id' => $user['role']['id']
                ])
                ->first();

            $menus = [];


            if (!empty($Menus->menus)) {
                $menus_ids = json_decode($Menus->menus);

                if (!empty($menus_ids)) {
                    $menus = $this->Menus->find('threaded')
                        ->where([
                            'id in' => $menus_ids
                        ])
                        ->order([
                            'sort' => 'desc',
                            'id' => 'desc'
                        ])
                        ->toArray();

                    $menus = $this->Menus->formatMenus($menus);
                }
            }

            $this->apiResponse($menus, 200, null, false);
        }

        $this->apiResponse([], 300);

    }

    /**
     * 获取管理组列表
     */
    public function getList()
    {
        if ($this->getRequest()->is('post')) {

            $this->setPage();

            $conditions = [];

            if (!empty($this->getRequest()->getData('title'))) {
                $conditions['Menus.title like'] = '%' . $this->getRequest()->getData('title') . '%';
            }

            $items = $this->Menus
                ->find('threaded')
                ->where($conditions)
                ->order([
                    'sort' => 'desc',
                    'id' => 'desc'
                ])->toArray();


            $data = [
                'items' => $items,
            ];


            $this->apiResponse($data);
        }

        $this->apiResponse([], 300);

    }

    /**
     * 添加
     */
    public function add()
    {
        if ($this->getRequest()->is('post')) {
            $data = $this->Menus->newEntity();
            $data = $this->Menus->patchEntity($data, $this->getRequest()->getData());

            if ($this->Menus->save($data)) {
                $this->apiResponse($data, 200, null, true);
            }
        }

        $this->apiResponse([], 300);

    }


    /**
     * 编辑
     */
    public function edit()
    {
        if ($this->getRequest()->is('post')) {
            $id = $this->getRequest()->getData('id');
            $data = $this->Menus->get($id);

            $data = $this->Menus->patchEntity($data, $this->getRequest()->getData());

            if ($this->Menus->save($data)) {
                $this->apiResponse($data, 200, null, true);
            }
        }

        $this->apiResponse([], 300);

    }


    /**
     * 删除
     */
    public function delete()
    {
        $message = null;
        if ($this->getRequest()->is('post')) {
            $id = $this->getRequest()->getData('id');

            $have = $this->Menus->find()
                ->where([
                    'parent_id' => $id
                ])->first();

            if (empty($have)) {
                $data = $this->Menus->get($id);
                if ($this->Menus->delete($data)) {
                    $this->apiResponse($data, 200, null, true);
                }
            }

            $message = '删除失败,请先删除该菜单下的所有子类菜单!';
        }

        $this->apiResponse([], 300, $message);
    }



}
