<?php

namespace AdminApi\Controller;

use App\Controller\ApiController as BaseController;
use Cake\Cache\Cache;

class AppController extends BaseController
{

    //设置不需要token验证的controller
    protected $authController = [
    ];

    //设置controller中允许不验证的action
    protected $authAllow = [
        'Users' => [
            'login'
        ]
    ];

    public $TOKEN_NAME = 'admin_token';

    public function setLogFile($data)
    {
        parent::setLogFile($data);
    }


    public function initialize()
    {
        parent::initialize();

        $this->setApiAuth();

    }

    /**
     * api 返回接口
     * @param $data
     * @param int $code
     * @param null $message
     * @param bool|'auto' $autoMessage 是否自动显示消息
     */
    public function apiResponse($data, $code = 200, $message = null, $autoMessage = 'auto')
    {
        if (empty($message)) {
            switch ($code) {
                case 200:
                    $message = '操作成功';
                    break;
                case 300:
                    $message = '操作失败';
                    break;
                case 403:
                    $message = '无权限访问';
                    break;
                default:
                    $message = '未知错误';
            }
        }

        if ($autoMessage === 'auto') {
            if ($code == 200) {
                $autoMessage = false;
            } else {
                $autoMessage = true;
            }
        }

        return parent::apiResponse([
            'data' => $data,
            'code' => $code,
            'message' => $message,
            'autoMessage' => $autoMessage
        ]);
    }

    /**
     * 获取token ,当前token保存在header中
     * @return mixed
     */
    public function getRequestToken()
    {
        $x_token = $this->getRequest()->getHeader('x-token');
        return !empty($x_token) ? $x_token[0] : null;
    }


    /**
     * 权限查看
     */
    protected function setApiAuth()
    {
        $controller = $this->getRequest()->getParam('controller');
        $action = $this->getRequest()->getParam('action');

        if (!in_array($controller, $this->authController)) {
            $allow = isset($this->authAllow[$controller]) ? $this->authAllow[$controller] : [];
            if (empty($allow) || !in_array($action, $allow)) {
                //验证是否登录
                $token = $this->getRequestToken();
                if (empty($token) || ($this->getUserInfo($token) === false)) {
                    $this->apiResponse([], 403, '无权限访问');
                    exit;
                }

            }
        }

    }


    /**
     * 根据token获取用户信息
     * @param $token
     * @return mixed
     */
    public function getUserInfo($token = null)
    {
        if (empty($token)) {
            $token = $this->getRequestToken();
        }

        return Cache::read($token, $this->TOKEN_NAME);
    }


    public function setToken($token, $info) {
        Cache::write($token, $info, $this->TOKEN_NAME);
    }

    /**
     * 删除用户token
     * @param null $token
     */
    public function deleteToken($token = null)
    {
        if (empty($token)) {
            $token = $this->getRequestToken();
        }

        Cache::delete($token, $this->TOKEN_NAME);
    }


    /**
     * 分页初始化
     * @param int $limit
     * @return array
     */
    public function setPage($limit = 20)
    {
        $page = !empty($this->getRequest()->getData('page')) ? $this->getRequest()->getData('page') :
            (!empty($this->getRequest()->getQuery('page')) ? $this->getRequest()->getQuery('page') : 1);

        $limit = !empty($this->getRequest()->getData('limit')) ? $this->getRequest()->getData('limit') :
            (!empty($this->getRequest()->getQuery('limit')) ? $this->getRequest()->getQuery('limit') : $limit);

        $this->paginate['page'] = $page;
        $this->paginate['limit'] = $limit;

        return [
            'page' => $page,
            'limit' => $limit,
        ];
    }

    /**
     * 获取数据总数
     * @param $controller string 一般可用 $this->getRequest()->getParam('controller')获取,或直接传入，如 Users
     * @return mixed
     */
    public function getPageCount($controller)
    {
        return $this->Paginator->getPaginator()->getPagingParams()[$controller]['count'] ?: 1;
    }
}
