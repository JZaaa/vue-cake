<?php
namespace AdminApi\Controller;

use AdminApi\Controller\AppController;
use Cake\Filesystem\File;
use Cake\Routing\Router;

/**
 * Articles Controller
 *
 * @property \AdminApi\Model\Table\ArticlesTable $Articles
 *
 * @method \AdminApi\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController
{

    /**
     * 获取文章列表
     */
    public function getList()
    {

        if ($this->getRequest()->is('post')) {
            $this->setPage();

            $conditions = [];

            if (!empty($this->getRequest()->getData('title'))) {
                $conditions['Articles.title like'] = '%' . $this->getRequest()->getData('title') . '%';
            }

            $query = $this->Articles->find()
                ->where($conditions)
                ->select([
                    'id', 'arctype_id', 'title', 'color', 'pubdate', 'isshow', 'istop'
                ])
                ->order([
                    'Articles.isshow' => 'asc',
                    'Articles.istop' => 'asc',
                    'Articles.id' => 'desc'
                ]);


            $items = $this->paginate($query);

            $formatItems = [];

            foreach ($items as $item) {

                $item['pubdate'] = date('Y-m-d H:i:s', strtotime($item['pubdate']));

                $formatItems[] = $item;
            }

            $data = [
                'items' => $formatItems,
                'total' => $this->getPageCount($this->getRequest()->getParam('controller'))
            ];

            $this->apiResponse($data);
        }

        $this->apiResponse([], 300);

    }


    /**
     * 获取文章具体数据
     */
    public function getData()
    {
        if ($this->getRequest()->is('post')) {
            $id = $this->getRequest()->getData('id');

            if (!empty($id)) {
                $data = $this->Articles->find()
                    ->select([
                        'Articles.title', 'Articles.id', 'Articles.arctype_id', 'Articles.shorttitle', 'Articles.color', 'Articles.description', 'Articles.keywords', 'Articles.content', 'Articles.pubdate', 'Articles.image', 'Articles.isshow', 'Articles.istop', 'Articles.url'
                    ])
                    ->where([
                        'Articles.id' => $id
                    ])
                    ->first()->toArray();

                $data = $this->Articles->formatData($data);

                $this->apiResponse($data);
            }
        }
        $this->apiResponse([], 300);
    }


    /**
     * 新增
     */
    public function add()
    {
        if ($this->getRequest()->is('post')) {
            $data = $this->getRequest()->getData();
            $data['image'] = post_img_format($data['image']);
            $entity = $this->Articles->newEntity();
            $data = $this->Articles->patchEntity($entity, $data);

            if ($this->Articles->save($data)) {
                $data = $this->Articles->formatData($data);
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

            $data = $this->Articles->get($id);

            $newData = $this->getRequest()->getData();

            $newData['image'] = post_img_format($newData['image']);

            $data = $this->Articles->patchEntity($data, $newData);

            if ($this->Articles->save($data)) {
                $data = $this->Articles->formatData($data);
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
        if ($this->getRequest()->is('post')) {
            $id = $this->getRequest()->getData('id');

            $data = $this->Articles->get($id);

            if ($this->Articles->delete($data)) {
                $data = $this->Articles->formatData($data);
                $this->apiResponse($data, 200, null, true);
            }
        }

        $this->apiResponse([], 300);
    }

}
