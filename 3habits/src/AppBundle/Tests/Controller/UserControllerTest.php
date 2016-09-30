<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testShowhabits()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/habits/1');
    }

    public function testUseroverview()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/overview/1');
    }

}
