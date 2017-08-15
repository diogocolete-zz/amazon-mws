<?php
/**
 * Created by PhpStorm.
 * User: diogo
 * Date: 30/07/17
 * Time: 10:58
 */

namespace ZendHunter\AmazonMwsFeed;


class AmazonMwsFeed
{
    /**
     * @var array
     */
    private $config;

    /**
     * AmazonMwsFeed constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config['mws-config'];
    }

    /**
     * @return \MarketplaceWebService_Client
     */
    public function getFeedMarketplaceWebserviceClient()
    {
        if ($this->config['ENV'] != 'DEV') {
            $options = array (
                'ServiceURL' => $this->config['serviceUrl'],
                'ProxyHost' => null,
                'ProxyPort' => -1,
                'MaxErrorRetry' => 3,
            );

            $service = new \MarketplaceWebService_Client(
                $this->config['AWS_ACCESS_KEY_ID'],
                $this->config['AWS_SECRET_ACCESS_KEY'],
                $options,
                $this->config['APPLICATION_NAME'],
                $this->config['APPLICATION_VERSION']
            );
        } else {
            $service = new \MarketplaceWebService_Mock();
        }

        return $service;
    }

    public function getNewRequestObject()
    {
        $request = new \MarketplaceWebService_Model_SubmitFeedRequest();
        $request->setMerchant($this->config['MERCHANT_ID']);
        $request->setMWSAuthToken($this->config['MWS_AUTH_TOKEN']); // Optional
        return $request;
    }

    /**
     * @param $service
     * @param \MarketplaceWebService_Model_SubmitFeedRequest $request
     * @return AmazonMwsFeedSubmit
     */
    public function submitFeed($service, \MarketplaceWebService_Model_SubmitFeedRequest $request)
    {
        $submitFeedObject = new AmazonMwsFeedSubmit($service, $request);
        return $submitFeedObject;
    }
}