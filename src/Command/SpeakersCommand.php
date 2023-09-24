<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Panther\Client;

#[AsCommand(
    name: 'crawler:speakers',
    description: '.',
    hidden: false,
    aliases: ['crawler:speakers']
)]
class SpeakersCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // $client = Client::createChromeClient();
        // Or, if you care about the open web and prefer to use Firefox
        $client = Client::createFirefoxClient();

        $crawler = $client->request('GET', 'https://php.locaweb.com.br/');
        $client->manage()->window()->maximize();
        // $client->clickLink('Getting started');

        // Wait for an element to be present in the DOM (even if hidden)
        // $crawler = $client->waitFor('#installing-the-framework');
        // // Alternatively, wait for an element to be visible
        // $crawler = $client->waitForVisibility('#installing-the-framework');

        $script = <<<JS
            const element = document.querySelector('#palestrantes');
            element.scrollIntoView();
        JS;

        $client->executeScript($script);

        // $elements = $crawler->filter('#app-speakers ul li h3');

        // foreach ($elements as $element) {
        //     echo $element->getText() . PHP_EOL;
        // }

        $client->takeScreenshot('speakers.png');

        return Command::SUCCESS;
    }
}