<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConferenceControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Donner vos feedback !');
    }

    public function testConferencePage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertCount(2, $crawler->filter('h4'));

        $client->clickLink('View'); // Ou 'Voir' selon ton bouton

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Amsterdam 2019');

        // On vérifie qu'il y a bien un élément qui parle de "1" commentaire
        // On utilise un sélecteur plus large pour éviter les erreurs de texte exact
        $this->assertSelectorTextContains('div', '1');
        $this->assertSelectorTextContains('div', 'comment');

        dump($client->getResponse()->getContent());
    }

    public function testCommentSubmission()
    {
        $client = static::createClient();
        $client->request('GET', '/conference/amsterdam-2019');
        $client->submitForm('Submit', [
            'comment[author]' => 'Fabien',
            'comment[text]' => 'Some feedback from an automated functional test',
            'comment[email]' => 'me@automat.ed',
            'comment[photo]' => dirname(__DIR__, 2) . '/public/images/under-construction.gif',
        ]);
        $this->assertResponseRedirects();
        $client->followRedirect();

        $this->assertSelectorTextContains('div', '2');
        $this->assertSelectorTextContains('div', 'commentaire');
    }
}