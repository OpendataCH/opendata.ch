<?php

use PHPUnit\Framework\TestCase;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

class WebTest extends TestCase
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $url;

    public function setUp()
    {
        $this->client = new Client();
        $this->url = $_ENV['URL'];
    }

    public function testHome()
    {
        $crawler = $this->client->request('GET', $this->url);

        // check title
        $h2 = $crawler->filter('h2')->first()->text();
        $this->assertContains('Opendata.ch ist die Schweizer Sektion der Open Knowledge Foundation.', $h2);

        // check posts
        $posts = $crawler->filter('#content .post');
        $this->assertGreaterThan(3, $posts->count());
    }

    public function testVorstand()
    {
        $crawler = $this->client->request('GET', $this->url);

        // go to Vorstand
        $crawler = $this->client->click($crawler->selectLink('Vorstand')->link());

        // check Vorstand
        $h2 = $crawler->filter('h2')->first()->text();
        $this->assertEquals('André Golliez, Präsident', $h2);
    }

    public function testEvents()
    {
        $crawler = $this->client->request('GET', $this->url . 'events/');

        // check events
        $events = $crawler->filter('#projects .project');
        $this->assertGreaterThan(10, $events->count());
    }
}
