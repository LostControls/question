<?php


namespace LostControls\Question;

use GuzzleHttp\Client;
use LostControls\Question\Exceptions\HttpException;
use LostControls\Question\Exceptions\InvalidArgumentException;

class Question
{
    protected $key;

    protected $url = 'http://v.juhe.cn/jztk/query';

    protected $guzzleOptions = [];

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    public function setGuzzleOptions($options)
    {
        $this->guzzleOptions = $options;
    }

    /**
     * Notes: 获取题目
     * Created by PhpStorm.
     * User: ChenYiWen
     * DateTime: 2020/11/13 16:05
     * @param $subject 选择考试科目类型，1：科目1；4：科目4
     * @param $model 驾照类型，可选择参数为：c1,c2,a1,a2,b1,b2；当subject=4时可省略
     * @param $testType 测试类型，rand：随机测试（随机100个题目），order：顺序测试（所选科目全部题目）
     * @return mixed
     * @throws HttpException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getQuestion($subject, $model, $testType)
    {
        if (!is_int($subject) || !is_string($model) || !is_string($testType)) {
            throw new InvalidArgumentException("参数类型有误");
        }

        $query = ([
            'key' => $this->key,
            'subject' => $subject,
            'model' => $model,
            'testType' => $testType,
        ]);

        try {
            $response = $this->getHttpClient()->get($this->url,[
                'query' => $query,
            ])->getBody()->getContents();

            return json_decode($response, true);
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(),$e->getCode(), $e);
        }
    }
}