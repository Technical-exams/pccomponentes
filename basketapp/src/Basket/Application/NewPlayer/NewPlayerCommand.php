<?php

namespace Basket\Application\NewPlayer;

use Basket\Application\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class NewPlayerCommand 
    extends Command
{
    protected static $defaultName = 'basket:new-player';


    protected function configure()
    {
        $this
            ->setDescription('Add a player')
            ->setHelp('Adds or updates a player asking the number (to identify his/her), the name, the position and the rating')
            ->addArgument('number', InputArgument::REQUIRED, 'Player number (any positive integer)')
            ->addArgument('name', InputArgument::REQUIRED, 'Player name (nom empty string)')
            ->addArgument('position', InputArgument::REQUIRED, 'Player position (one among "BASE","ESCOLTA","ALERO","ALA-PIVOT" or "PIVOT")')
            ->addArgument('rating', InputArgument::REQUIRED, 'Player rating (integer between 0 and 100)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $valid_roles = ['BASE','ESCOLTA','ALERO','ALA-PIVOT','PIVOT'];

        $num = $input->getArgument('number');
        $label = $input->getArgument('name');
        $role =  $input->getArgument('position');
        $rating =  $input->getArgument('rating');

        try {
            assert(is_int($num) && 0<=$num, "Bad number provided, please type any positive integer as player number");
            assert(is_string($label) && !empty($label=trim($label)), "Bad name provided, please type an not empty string for player name");
            assert(is_string($role) && in_array(strtoupper($role),$valid_roles), "Bad position provided, please choose one of the following:\n".explode(', ',$valid_roles));
            assert(is_int($rating) && 0<=$rating && 100>=$rating, "Bad rating provided, please type any positive integer between 0 and 100");

            $request = new NewPlayerRequest($num, $label, $role, $rating);
            $response = $this->commandBus()->handle($request);

            $action = $response->action;
            $output = $this->formatter()->format($response->player);

            $io->success(sprintf('Player has been %s the roster. Now looks like this:', $action==$response::ACTION_ADDED?"added to":"updated on"));
            $io->write($output);
            $io->writeln(["",""]);

        }catch (\Throwable $error){
            $io->error($error->getMessage());
            return static::FAILURE;
        }
        
    }
}
