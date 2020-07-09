<?php

namespace Basket\Application\RemovePlayer;

use Basket\Application\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RemovePlayerCommand extends Command
{
    protected static $defaultName = 'basket:remove-player';

    protected function configure()
    {
        $this
            ->setDescription('Remove a player')
            ->setHelp('Removes a player asking the number (to identify his/her)')
            ->addArgument('number', InputArgument::REQUIRED, 'Player number (any positive integer)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $num = $input->getArgument('number');
        $num = filter_var($num,\FILTER_VALIDATE_INT,["options" => ["min_range" => 0]]);

        try {
            assert(is_int($num) && 0<=$num, "Bad number provided, please type any positive integer as player number");

            $request = new RemovePlayerRequest($num);
            $response = $this->commandBus()->handle($request);

            $action = $response->action;
            if ($action == $response::ACTION_NOT_FOUND){
                $io->warning(sprintf("Player with number #%s was not found in the roster",$num));
            }else{
                $output = $this->formatter()->format($response->player);
                $io->success(sprintf('Player has been removed from the roster.'));
                $io->section(sprintf("Former player #%s registered data",$num));
                $io->write($output);
                $io->writeln(["",""]);                
            }
        }catch (\Throwable $error){
            $io->error($error->getMessage());
            return static::FAILURE;
        }
        
        return static::SUCCESS;            
    }
}
