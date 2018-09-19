<?php
namespace AdminApi\Controller;

use AdminApi\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Roles Controller
 *
 * @property \AdminApi\Model\Table\RolesTable $Roles
 *
 * @method \AdminApi\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolesController extends AppController
{
    /**
     * 获取管理组列表
     */
    public function getList()
    {
        if ($this->getRequest()->is('post')) {

            $this->setPage();

            $conditions = [];

            if (!empty($this->getRequest()->getData('name'))) {
                $conditions['Roles.name like'] = '%' . $this->getRequest()->getData('name') . '%';
            }

            $query = $this->Roles->find()
                ->where($conditions)
                ->select([
                    'id', 'name', 'sort', 'note', 'menus', 'menus_key'
                ])
                ->order([
                    'sort' => 'desc',
                    'id' => 'desc'
                ]);

            $items = $this->paginate($query)->toArray();

            $data = [
                'items' => $items,
                'total' => $this->getPageCount($this->getRequest()->getParam('controller'))
            ];

            $this->apiResponse($data);
        }

        $this->apiResponse([], 300);

    }

    /**
     * 返回所有用户组，通过key-value形式返回
     */
    public function getListAll()
    {
        if ($this->getRequest()->is('post')) {

            $data = $this->Roles->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ])
                ->toArray();

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
            $role = $this->Roles->newEntity();
            $role = $this->Roles->patchEntity($role, $this->getRequest()->getData());
            if ($this->Roles->save($role)) {
                $this->apiResponse($role, 200, null, true);
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
            $data = $this->Roles->get($id);

            $data = $this->Roles->patchEntity($data, $this->getRequest()->getData());
            if ($this->Roles->save($data)) {
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

            $have = TableRegistry::getTableLocator()->get('AdminApi.Users')->find()
                ->where([
                    'role_id' => $id
                ])->first();

            if (empty($have)) {
                $data = $this->Roles->get($id);
                if ($this->Roles->delete($data)) {
                    $this->apiResponse($data, 200, null, true);
                }
            }

            $message = '删除失败,请先删除该用户组下所有用户!';
        }

        $this->apiResponse([], 300, $message);
    }

}
