<?php

namespace Acme\FriendshipBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RelationshipControllerShowActionTest extends WebTestCase
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
        $crawler = $client->request('GET', '/relationship/1');

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertEquals(200,
            $client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for GET /relationship/"
        );
    }

    /**
     * @depends testCreateClient
     */
    public function testHttpBadRequest($client)
    {
        $crawler = $client->request('GET', '/relationship/-1');

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $this->assertFalse($client->getResponse()->isNotFound());

        $this->assertEquals(400,
            $client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for GET /relationship/-1"
        );

    }

    /**
     * @depends testCreateClient
     */
    public function testHttpNotFound($client)
    {
        $crawler = $client->request('GET', '/relationship');

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $this->assertTrue($client->getResponse()->isNotFound());

        $this->assertEquals(404,
            $client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for GET /relationship"
        );

    }
}
