<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Panther\Client;

#[AsCommand(
    name: 'crawler:basic-example',
    description: 'Basic example API Platform.',
    hidden: false,
    aliases: ['crawler:basic-example']
)]
class BasicExampleCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Crawler Basic example',
            '============',
            '',
        ]);

        $client = Client::createFirefoxClient();

        $client->request('GET', 'https://api-platform.com');
        $client->clickLink('Getting started');

        $crawler = $client->waitFor('#installing-the-framework');
        // Alternatively, wait for an element to be visible
        // $crawler = $client->waitForVisibility('#installing-the-framework');

        echo $crawler->filter('#installing-the-framework')->text();
        $client->takeScreenshot('screen.png');

        return Command::SUCCESS;
    }
}
