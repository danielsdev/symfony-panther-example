<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Panther\Client;

#[AsCommand(
    name: 'crawler:google',
    description: 'Google search example.',
    hidden: false,
    aliases: ['crawler:google']
)]
class GoogleCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = Client::createChromeClient();

        $crawler = $client->request('GET', 'https://google.com.br/');
        $client->manage()->window()->maximize();

        $crawler->filter('textarea[type="search"]')->sendKeys('LOCAWEB');

        $searchButton = $crawler->selectButton('Pesquisa Google');
        $client->submit($searchButton->form());

        sleep(10);

        return Command::SUCCESS;
    }
}
