<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Panther\Client;

#[AsCommand(
    name: 'crawler:form',
    description: 'Submit form example.',
    hidden: false,
    aliases: ['crawler:form']
)]
class FormCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = Client::createChromeClient();

        $crawler = $client->request('GET', 'https://php.locaweb.com.br/');
        $client->manage()->window()->maximize();

        $script = <<<JS
            const element = document.querySelector('#patrocine');
            element.scrollIntoView();
        JS;

        $client->executeScript($script);
        $crawler
            ->filter('input[name="name"]')
            ->sendKeys('TEST NAME');
        $crawler
            ->filter('input[name="company"]')
            ->sendKeys('TEST COMPANY');
        $crawler
            ->filter('input[name="email"]')
            ->sendKeys('test@example.com');

        $loginButton = $crawler->selectButton('Enviar');
        // $loginButton->form()->setValues([
        //     'name' => 'Test Name',
        //     'company' => 'Test Company',
        //     'email' => 'test@example.com',
        // ]);

        $client->submit($loginButton->form());

        sleep(10);

        return Command::SUCCESS;
    }
}
