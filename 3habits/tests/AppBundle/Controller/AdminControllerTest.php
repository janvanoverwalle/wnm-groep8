<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AdminControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/index');

        $this->assertTrue(
            $client->getResponse()->isRedirect('/login/'),
            'response is a redirect to /login'
        );
    }

    public function testLogin() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form();

        // set some values
        $form['_username'] = 'coach';
        $form['_password'] = 'coach123';

        // submit the form
        $crawler = $client->submit($form);

        $this->assertTrue(
            $client->getResponse()->isRedirect('/coach/'),
            'response is a redirect to /coach'
        );
    }

    public function testCoachUsers() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form();

        // set some values
        $form['_username'] = 'coach';
        $form['_password'] = 'coach123';

        // submit the form
        $crawler = $client->submit($form);

        $this->assertTrue(
            $client->getResponse()->isRedirect('/coach/'),
            'response is a redirect to /coach'
        );

        $link = $crawler
            ->filter('a:contains("gebruikers")') // find all links with the text "gebruikers"
            ->eq(0) // select the second link in the list
            ->link()
        ;

        // and click it
        $crawler = $client->click($link);

        $this->assertTrue(
            $client->getResponse()->isRedirect('/coach/users'),
            'response is a redirect to /coach/users'
        );
    }

}
