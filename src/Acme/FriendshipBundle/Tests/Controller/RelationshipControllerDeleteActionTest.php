<?php

namespace Acme\FriendshipBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RelationshipControllerDeleteActionTest extends WebTestCase
{

    public function testCreateClient()
    {
        return static::createClient();
    }

    /**
     * @depends testCreateClient
     */
    public function testHttpOk($client)
    {
        $crawler = $client->request('DELETE', '/relationship/delete/1/2');

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(200,
            $client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for DELETE /relationship/delete/1/2"
        );

        if ($profile = $client->getProfile()) {
            // check the number of requests
            $this->assertLessThan(
                8,
                $profile->getCollector('db')->getQueryCount()
            );

            // check the time spent in the framework
            $this->assertLessThan(
                500,
                $profile->getCollector('time')->getDuration()
            );
        }

    }

    /**
     * @depends testCreateClient
     */
    public function testHttpBadRequest($client)
    {
        $crawler = $client->request('DELETE', '/relationship/delete/1/asd');

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
        $this->assertFalse($client->getResponse()->isSuccessful());

        $this->assertEquals(400,
            $client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for DELETE /relationship/delete/1/asd"
        );

        if ($profile = $client->getProfile()) {
            // check the number of requests
            $this->assertEquals(
                0,
                $profile->getCollector('db')->getQueryCount()
            );

            // check the time spent in the framework
            $this->assertLessThan(
                500,
                $profile->getCollector('time')->getDuration()
            );
        }

    }

    /**
     * @depends testCreateClient
     */
    public function testHttpNotFound($client)
    {
        $crawler = $client->request('DELETE', '/relationship/delete/');

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $this->assertFalse($client->getResponse()->isSuccessful());
        $this->assertEquals(404,
            $client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for DELETE /relationship/delete/"
        );

        if ($profile = $client->getProfile()) {
            // check the number of requests
            $this->assertEquals(
                0,
                $profile->getCollector('db')->getQueryCount()
            );

            // check the time spent in the framework
            $this->assertLessThan(
                500,
                $profile->getCollector('time')->getDuration()
            );
        }
    }

}
