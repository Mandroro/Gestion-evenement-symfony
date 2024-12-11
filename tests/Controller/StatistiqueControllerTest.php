<?php

namespace App\Tests\Controller;

use App\Entity\Statistique;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class StatistiqueControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/statistique/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Statistique::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Statistique index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'statistique[total_participants]' => 'Testing',
            'statistique[total_revenue]' => 'Testing',
            'statistique[evenement_id]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Statistique();
        $fixture->setTotal_participants('My Title');
        $fixture->setTotal_revenue('My Title');
        $fixture->setEvenement_id('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Statistique');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Statistique();
        $fixture->setTotal_participants('Value');
        $fixture->setTotal_revenue('Value');
        $fixture->setEvenement_id('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'statistique[total_participants]' => 'Something New',
            'statistique[total_revenue]' => 'Something New',
            'statistique[evenement_id]' => 'Something New',
        ]);

        self::assertResponseRedirects('/statistique/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTotal_participants());
        self::assertSame('Something New', $fixture[0]->getTotal_revenue());
        self::assertSame('Something New', $fixture[0]->getEvenement_id());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Statistique();
        $fixture->setTotal_participants('Value');
        $fixture->setTotal_revenue('Value');
        $fixture->setEvenement_id('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/statistique/');
        self::assertSame(0, $this->repository->count([]));
    }
}
