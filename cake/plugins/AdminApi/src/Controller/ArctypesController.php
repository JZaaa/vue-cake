<?php
namespace AdminApi\Controller;

use AdminApi\Controller\AppController;

/**
 * Arctypes Controller
 *
 * @property \AdminApi\Model\Table\ArctypesTable $Arctypes
 *
 * @method \AdminApi\Model\Entity\Arctype[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArctypesController extends AppController
{
    // 获取分类列表
    public function getList()
    {
        if ($this->getRequest()->is('post')) {
            
            $conditions = [];

            $items = $this->Arctypes->find('threaded')
                ->where($conditions)
                ->select([
                    'id', 'name', 'parent_id', 'sort', 'type', 'isshow', 'keywords', 'description', 'href', 'enable_columns', 'select_path'
                ])
                ->order([
                    'sort' => 'desc',
                    'id' => 'desc'
                ])->toArray();

            $this->apiResponse([
                'items' => $items
            ]);
        }

        $this->apiResponse([], 300);
    }


    /**
     * key-value 形式获取所有栏目类型
     */
    public function getListAll()
    {
        if ($this->getRequest()->is('post')) {

            $data = $this->Arctypes->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ])->toArray();

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
            $data = $this->Arctypes->newEntity();
            $data = $this->Arctypes->patchEntity($data, $this->getRequest()->getData());

            if ($this->Arctypes->save($data)) {
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
            $data = $this->Arctypes->get($id);

            $data = $this->Arctypes->patchEntity($data, $this->getRequest()->getData());

            if ($this->Arctypes->save($data)) {
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

            $have = $this->Arctypes->find()
                ->where([
                    'parent_id' => $id
                ])->first();

            if (empty($have)) {
                $data = $this->Arctypes->get($id);
                if ($this->Arctypes->delete($data)) {
                    $this->apiResponse($data, 200, null, true);
                }
            }

            $message = '删除失败,请先删除该菜单下的所有子类菜单!';
        }

        $this->apiResponse([], 300, $message);
    }
}
