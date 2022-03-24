<?php

namespace PhalApi\Restful;

use PhalApi\Request;

class RestfulRequest extends Request
{

    /**
     * @var array $put 备用数据源 getInput
     */
    protected $put = array();

    /**
     * @var array $delete 备用数据源 getInput
     */
    protected $delete = array();

    public function __construct($data = NULL)
    {
        parent::__construct($data);
        $this->post = $this->requestMethod('POST') ? $this->getInput() : [];
        $this->put = $this->requestMethod('PUT') ? $this->getInput() : [];
        $this->delete = $this->requestMethod('DELETE') ? $this->getInput() : [];
    }

    /**
     *  判断请求方法
     * @param $source
     * @return array
     */
    public function requestMethod($source)
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        return strtoupper($source) === strtoupper($httpMethod) ? true : false;
    }

    /**
     * 重写
     * @param array $data
     * @return array
     */
    protected function genData($data)
    {
        if (!isset($data) || !is_array($data)) {
            $data = $_REQUEST;
            if (in_array(strtoupper($_SERVER['REQUEST_METHOD']), ['POST','PUT','DELETE'])) {
                $input = $this->getInput();
                $data = array_merge($data, $input);
            }
        }

        return $data;
    }

    /**
     *
     * 重写
     * 根据来源标识获取数据集
     * ```
     * |----------|---------------------|
     * | post     | $_POST              |
     * | put      | RawJson             |
     * | get      | $_GET               |
     * | cookie   | $_COOKIE            |
     * | server   | $_SERVER            |
     * | request  | $_REQUEST           |
     * | header   | $_SERVER['HTTP_X']  |
     * |----------|---------------------|
     *
     * ```
     * - 当需要添加扩展其他新的数据源时，可重载此方法
     *
     * @throws InternalServerErrorException
     * @return array
     */
    protected function &getDataBySource($source)
    {
        switch (strtoupper($source)) {
            case 'POST' :
                return $this->post;
            case 'PUT' :
                return $this->put;
            case 'DELETE' :
                return $this->delete;
            case 'GET'  :
                return $this->get;
            case 'COOKIE':
                return $this->cookie;
            case 'HEADER':
                return $this->headers;
            case 'SERVER':
                return $_SERVER;
            case 'REQUEST':
                return $this->request;
            default:
                break;
        }

        throw new InternalServerErrorException
        (T('unknow source: {source} in rule', array('source' => $source)));
    }

    /**
     * 根据数据流获取数据
     * @return array
     */
    public function getInput()
    {
        $str = file_get_contents('php://input');
        $data = json_decode($str, true);
        if (json_last_error()) {
            parse_str($str, $data);
        }

        return $data;
    }
}