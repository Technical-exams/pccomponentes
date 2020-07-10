<?php

namespace Basket\Application\ListPlayers;


use Basket\Application\Command\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Basket\Application\ListPlayers\ListPlayersRequest;

class ListPlayersCommand 
    extends Command
{
    protected static $defaultName = 'roster';

    protected function configure()
    {
        $this
            ->setDescription('List all players')
            ->setHelp('List all players by their registration date.')
            ->addOption('order',null,InputOption::VALUE_OPTIONAL,"Which sorting order whould you want to apply to the list (by 'num', by 'rating' or 'none')",'none')            
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $given_order = $input->getOption('order');
        $order = [];
        if (in_array($given_order,['num','rating']))
            $order[]=$given_order;

        $request = new ListPlayersRequest($order);        
        $response = $this->commandBus()->handle($request);
       
        $io->success(sprintf('There are %s players in the roster.', count($response->players)));
        foreach ($response->players as $player){
            $io->section(sprintf("Player #%s",$player->num));
            $output = $this->formatter()->format($player);
            $io->write($output);
        }        
        $io->writeln(["",""]);

        return static::SUCCESS;
    }
}
