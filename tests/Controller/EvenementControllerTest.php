<?php

namespace App\Tests\Controller;

use App\Entity\Evenement;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class EvenementControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/evenement/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Evenement::class);

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
        self::assertPageTitleContains('Evenement index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'evenement[tittre]' => 'Testing',
            'evenement[description]' => 'Testing',
            'evenement[lieu]' => 'Testing',
            'evenement[date]' => 'Testing',
            'evenement[capacite]' => 'Testing',
            'evenement[programme]' => 'Testing',
            'evenement[organisteur_id]' => 'Testing',
            'evenement[notification]' => 'Testing',
            'evenement[inscription]' => 'Testing',
            'evenement[commentaire]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Evenement();
        $fixture->setTittre('My Title');
        $fixture->setDescription('My Title');
        $fixture->setLieu('My Title');
        $fixture->setDate('My Title');
        $fixture->setCapacite('My Title');
        $fixture->setProgramme('My Title');
        $fixture->setOrganisteur_id('My Title');
        $fixture->setNotification('My Title');
        $fixture->setInscription('My Title');
        $fixture->setCommentaire('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Evenement');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Evenement();
        $fixture->setTittre('Value');
        $fixture->setDescription('Value');
        $fixture->setLieu('Value');
        $fixture->setDate('Value');
        $fixture->setCapacite('Value');
        $fixture->setProgramme('Value');
        $fixture->setOrganisteur_id('Value');
        $fixture->setNotification('Value');
        $fixture->setInscription('Value');
        $fixture->setCommentaire('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'evenement[tittre]' => 'Something New',
            'evenement[description]' => 'Something New',
            'evenement[lieu]' => 'Something New',
            'evenement[date]' => 'Something New',
            'evenement[capacite]' => 'Something New',
            'evenement[programme]' => 'Something New',
            'evenement[organisteur_id]' => 'Something New',
            'evenement[notification]' => 'Something New',
            'evenement[inscription]' => 'Something New',
            'evenement[commentaire]' => 'Something New',
        ]);

        self::assertResponseRedirects('/evenement/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTittre());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getLieu());
        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getCapacite());
        self::assertSame('Something New', $fixture[0]->getProgramme());
        self::assertSame('Something New', $fixture[0]->getOrganisteur_id());
        self::assertSame('Something New', $fixture[0]->getNotification());
        self::assertSame('Something New', $fixture[0]->getInscription());
        self::assertSame('Something New', $fixture[0]->getCommentaire());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Evenement();
        $fixture->setTittre('Value');
        $fixture->setDescription('Value');
        $fixture->setLieu('Value');
        $fixture->setDate('Value');
        $fixture->setCapacite('Value');
        $fixture->setProgramme('Value');
        $fixture->setOrganisteur_id('Value');
        $fixture->setNotification('Value');
        $fixture->setInscription('Value');
        $fixture->setCommentaire('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/evenement/');
        self::assertSame(0, $this->repository->count([]));
    }
}
