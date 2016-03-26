<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 12.03.16
 * Time: 11:56
 */

namespace app\lib\yandex\direct;

use app\lib\yandex\direct\exceptions\ConnectionException;
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
    protected $authToken;

    /**
     * Connection constructor.
     * @param null $apiUrl
     * @param string|null $token
     */
    public function __construct($token = null, $apiUrl = null)
    {
        if (is_null($apiUrl)) {
            $this->apiUrl = \Yii::$app->params['yandex']['apiUrl'];
        } else {
            $this->apiUrl = $apiUrl;
        }
        $this->authToken = $token;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setApiUrl($url)
    {
        $this->apiUrl = $url;
        return $this;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->authToken = $token;
        return $this;
    }

    /**
     * @param string $resource
     * @param array $params
     * @param string $method
     * @return mixed
     * @throws ConnectionException
     */
    public function query($resource, array $params = [], $method = 'get')
    {
        $uri = rtrim($this->apiUrl, '/') . '/' . $resource;

        $jsonParams = json_encode([
            'method' => $method,
            'params' => $params
        ]);

        $response = $this->getHttpClient()
            ->setHeaders($this->getHeaders())
            ->setMethod('POST')
            ->setUri($uri)
            ->setAdapter('Zend\Http\Client\Adapter\Curl')
            ->setRawBody($jsonParams)
            ->send();

        if (!$response->isSuccess()) {
            throw new ConnectionException($response->getReasonPhrase(), $response->getStatusCode());
        }

        $body = $response->getBody();

        $result = json_decode($body, true);

        if (!is_array($result)) {
            throw new ConnectionException(json_last_error_msg());
        }

        if (!empty($result['error'])) {
            throw new ConnectionException($result['error']['error_detail'], $result['error']['error_code']);
        }

        return $result;
    }

    /**
     * @return array
     */
    private function getHeaders()
    {
        $headers = [
            'Accept-Language' => 'ru',
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.87 Safari/537.36',
            'Content-type' => 'application/json'
        ];
        if ($this->authToken) {
            $headers['Authorization'] = 'Bearer ' . $this->authToken;
        }

        return $headers;
    }

    /**
     * @return Client
     */
    protected function getHttpClient()
    {
        if (is_null($this->httpClient)) {
            $this->httpClient = new Client();
        }

        return $this->httpClient->reset();
    }
}
