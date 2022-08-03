<?php
namespace Tests;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing;
use App\Controller\CarListController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Cars;

class GenericListTest extends WebTestCase{

    public function testAddCar(): void
    {
        
        $client = static::createClient();
        $crawler = $client->request('GET', '/add/car');
        $this->assertEquals(0, count($crawler->filter('li')));
        $this->assertResponseIsSuccessful();

        $crawler = $client->request('POST', '/add/car',["name"=>"car"]);
        $this->assertEquals(1, count($crawler->filter('li')));
        $this->assertResponseIsSuccessful();


  
    }


}