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
        $client = Client::createFirefoxClient();

        $crawler = $client->request('GET', 'https://php.locaweb.com.br/');
        $client->manage()->window()->maximize();

        $script = <<<JS
            const element = document.querySelector('#palestrantes');
            element.scrollIntoView();
        JS;

        $client->executeScript($script);
        $client->takeScreenshot('speakers.png');

        return Command::SUCCESS;
    }
}
