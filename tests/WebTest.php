<?php

use PHPUnit\Framework\TestCase;
use Goutte\Client;

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

	protected function setUp(): void
	{
		$this->client = new Client();
		$this->url = $_ENV['URL'];

		if (!$this->url) {
			$this->markTestSkipped('No URL defined in phpunit.xml.');
		}
	}

	public function testHome()
	{
		$crawler = $this->client->request('GET', $this->url);

		// check title
		$h2 = $crawler->filter('h2')->first()->text();
		$this->assertEquals('Together for an open, innovative and fair society', $h2);

		// check home news teasers
		$teasers = $crawler->filter('.HomeNews .Teaser');
		$this->assertGreaterThan(3, $teasers->count());
	}

	public function testBoard()
	{
		$crawler = $this->client->request('GET', $this->url);

		// go to board
		$crawler = $this->client->click($crawler->selectLink('About')->link());
		$crawler = $this->client->click($crawler->selectLink('Board')->link());

		// check board
		$h2 = $crawler->filter('h2')->first()->text();
		$this->assertEquals('Andreas Kellerhals', $h2);
	}

	public function testEvents()
	{
		$crawler = $this->client->request('GET', $this->url . 'events/');

		// check events
		$events = $crawler->filter('.EventsPast .Teaser');
		$this->assertGreaterThan(10, $events->count());
	}
}
