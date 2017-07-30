<?php
/**
 * User: diogo
 * Date: 30/07/17
 * Time: 16:16
 */

namespace ZendHunter\AmazonMwsFeed;


class AmazonMwsFeedSubmit
{
    /**
     * @var \MarketplaceWebService_Client
     */
    private $service;
    /**
     * @var \MarketplaceWebService_Model_SubmitFeedRequest
     */
    private $request;

    /**
     * @var \MarketplaceWebService_Model_SubmitFeedResponse
     */
    private $response;

    /**
     * @param \MarketplaceWebService_Client $service
     * @param \MarketplaceWebService_Model_SubmitFeedRequest $request
     * @exception \MarketplaceWebService_Exception
     */
    public function __construct($service, \MarketplaceWebService_Model_SubmitFeedRequest $request)
    {
        $response = $service->submitFeed($request);
        $response->isSetSubmitFeedResult();

        $this->service = $service;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return \MarketplaceWebService_Model_SubmitFeedResponse
     */
    public function getResponse()
    {
        return $this->response;
    }

    public function getFeedSubmissionInfo()
    {
        /** @var \MarketplaceWebService_Model_SubmitFeedResult $submitFeedResult */
        $submitFeedResult = $this->response->getSubmitFeedResult();

        if ($submitFeedResult->isSetFeedSubmissionInfo()) {
            if ($submitFeedResult->isSetFeedSubmissionInfo()) {
                /** @var \MarketplaceWebService_Model_FeedSubmissionInfo $feedSubmissionInfo */
                $feedSubmissionInfo = $submitFeedResult->getFeedSubmissionInfo();
                return $feedSubmissionInfo;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getResponseMetadata(\MarketplaceWebService_Model_SubmitFeedResponse $response)
    {
        if ($this->response->isSetResponseMetadata()) {
            /** @var \MarketplaceWebService_Model_ResponseMetadata $responseMetadata */
            $responseMetadata = $response->getResponseMetadata();

            if ($responseMetadata->isSetRequestId()) {
                return $responseMetadata;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }
}