<?php
namespace AdminApi\Controller;

use AdminApi\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Routing\Router;
use Cake\Utility\Security;

/**
 * Users Controller
 *
 * @property \AdminApi\Model\Table\UsersTable $Users
 *
 * @method \AdminApi\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * 登录
     */
    public function login()
    {

        $res = [];
        $code = 300;
        $msg = '登录失败';

        if ($this->getRequest()->is('post')) {
            $data = $this->getRequest()->getData();

            $user = $this->Users->find()
                ->where([
                    'username' => $data['username']
                ])
                ->contain([
                    'Roles' => [
                        'fields' => [
                            'name', 'id'
                        ]
                    ]
                ])
                ->select([
                    'Users.id', 'Users.username', 'Users.password', 'Users.state', 'name' => 'Users.nickname'
                ])
                ->first();

            $auth = (new DefaultPasswordHasher())->check($data['password'], $user['password']);

            if (!$auth) {
                $msg = '用户名密码错误';

            } elseif ($auth && $user['state'] == 1) {

                $token = Security::hash(Security::randomBytes(32), 'sha256', false);

                $user = $user->toArray();

                //头像
                $user['avatar'] = Router::url('/img/f778738c-e4f8-4870-b634-56703b4acafe.gif', true);

                $this->setToken($token, $user);

                $code = 200;
                $msg = '登录成功';

                $res = [
                    'token' => $token
                ];

            } elseif ($auth && $user['state'] == 2) {

                $msg = '您已被禁止登录，如有疑问，请联系管理员！';
            }

        }
        $this->apiResponse($res, $code, $msg);
    }


    /**
     * 获取用户信息
     */
    public function info()
    {
        $token = $this->getRequest()->getQuery('token');

        $data = [];

        if (!empty($token)) {
            $data = $this->getUserInfo($token);

            if ($data !== false) {
                $this->apiResponse($data, 200, null, false);
            }
        }

        $this->apiResponse($data, 403, null, false);

    }

    /**
     * 退出,删除token
     */
    public function logout()
    {
        $this->deleteToken();

        $this->apiResponse([]);
    }


    /**
     * 获取管理组列表
     */
    public function getList()
    {
        if ($this->getRequest()->is('post')) {

            $this->setPage();

            $conditions = [];


            if (!empty($this->getRequest()->getData('username'))) {
                $conditions['Users.username like'] = '%' . $this->getRequest()->getData('username') . '%';
            }

            $query = $this->Users->find()
                ->where($conditions)
                ->select([
                    'Users.id', 'Users.username', 'Users.nickname', 'Users.role_id', 'Users.state'
                ])
                ->order([
                    'Users.id' => 'desc'
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
     * 添加
     */
    public function add()
    {
        if ($this->getRequest()->is('post')) {
            $data = $this->Users->newEntity();
            $data = $this->Users->patchEntity($data, $this->getRequest()->getData());

            if ($this->Users->save($data)) {
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
            $data = $this->Users->get($id);
            $saveData = $this->getRequest()->getData();

            if (empty($saveData['password'])) {
                unset($saveData['password']);
            }

            $data = $this->Users->patchEntity($data, $saveData);
            if ($this->Users->save($data)) {
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
            $data = $this->Users->get($id);
            if ($this->Users->delete($data)) {
                $this->apiResponse($data, 200, null, true);
            }

        }

        $this->apiResponse([], 300, $message);
    }



}
