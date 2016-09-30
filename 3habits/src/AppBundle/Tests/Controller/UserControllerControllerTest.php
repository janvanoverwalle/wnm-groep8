<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerControllerTest extends WebTestCase
{
    public function testShowhabits()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/habits');
    }

    public function testReachedhabits()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/reachedHabits');
    }

    public function testHabitsoverview()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/overview');
    }

}
