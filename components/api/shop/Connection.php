<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 12.03.16
 * Time: 11:56
 */

namespace app\components\api\shop;

use Zend\Http\Client;

class Connection
{
    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $apiUrl;

    /**
     * @var string
     */
    protected $apiKey;

    public function __construct()
    {

    }


    /**
     * @param array $params
     * @return \Zend\Http\Response
     */
    public function query(array $params = [])
    {
        $params = array_merge((array)$params, ['apiKey' => $this->getApiKey()]);
        $query = http_build_query($params);

        $url = $this->apiUrl;
        if ($query) {
            $url .= '?' . $query;
        }

        return $this->getHttpClient()
            ->reset()
            ->setUri($url)
            ->send();
    }

    /**
     * @return Client
     */
    protected function getHttpClient()
    {
        if (is_null($this->httpClient)) {
            $this->httpClient = new Client();
        }

        return $this->httpClient;
    }
}