<?php
/**
 * Created by PhpStorm.
 * User: diogo
 * Date: 30/07/17
 * Time: 10:30
 */

namespace ZendHunter\Test;

use PHPUnit\Framework\TestCase;
use ZendHunter\AmazonMwsFeed\AmazonMwsFeed;
use ZendHunter\AmazonMwsFeed\AmazonMwsFeedFactory;


class Test extends TestCase
{
    public function testCallableModule()
    {
        $factory = new AmazonMwsFeedFactory();
        $feedObject = $factory();
        $expected = AmazonMwsFeed::class;
        $this->assertInstanceOf($expected, $feedObject, 'Feed Factory não está retornando objeto esperado');
    }

    public function testLibrarySdk()
    {
        $factory = new AmazonMwsFeedFactory();
        /** @var AmazonMwsFeed $feedObject */
        $feedObject = $factory();

        $service = $feedObject->getFeedMarketplaceWebserviceClient();


        $feed = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<AmazonEnvelope xsi:noNamespaceSchemaLocation="amzn-envelope.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <Header>
        <DocumentVersion>1.01</DocumentVersion>
        <MerchantIdentifier>M_MWSTEST_49045593</MerchantIdentifier>
    </Header>
    <MessageType>OrderFulfillment</MessageType>
    <Message>
        <MessageID>1</MessageID>
        <OperationType>Update</OperationType>
        <OrderFulfillment>
            <AmazonOrderID>002-3275191-2204215</AmazonOrderID>
            <FulfillmentDate>2009-07-22T23:59:59-03:00</FulfillmentDate>
            <FulfillmentData>
                <CarrierName>Contact Us for Details</CarrierName>
                <ShippingMethod>Standard</ShippingMethod>
            </FulfillmentData>
            <Item>
                <AmazonOrderItemCode>42197908407194</AmazonOrderItemCode>
                <Quantity>1</Quantity>
            </Item>
        </OrderFulfillment>
    </Message>
</AmazonEnvelope>
EOD;

        $marketplaceIdArray = array("Id" => array('<Marketplace_Id_1>','<Marketplace_Id_2>'));

        $feedHandle = @fopen('php://memory', 'rw+');
        fwrite($feedHandle, $feed);
        rewind($feedHandle);

        $request = $feedObject->getNewRequestObject();
        $request->setMarketplaceIdList($marketplaceIdArray);
        $request->setFeedType('_POST_PRODUCT_DATA_');
        $request->setContentMd5(base64_encode(md5(stream_get_contents($feedHandle), true)));
        rewind($feedHandle);
        $request->setPurgeAndReplace(false);
        $request->setFeedContent($feedHandle);
        rewind($feedHandle);

        $feedResponse = $feedObject->submitFeed($service, $request);

        $info = $feedResponse->getFeedSubmissionInfo();

        $this->assertEquals('string', $info->getFeedType());


        @fclose($feedHandle);
    }
}
