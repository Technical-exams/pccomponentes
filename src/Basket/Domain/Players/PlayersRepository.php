<?php namespace Basket\Domain\Players;

interface PlayersRepository
{
    /**
     * Find All Players
     * @param array $orderBy Player properties to be used for sorting the results
     * @return Array The list of active players
     */
    public function findAll(array $orderBy = []);
 
    /**
     * Adds or replaces a player
     *
     * @param Player $player
     * @return Player | null The old player data or null if did not exist
     */
    public function add(Player $player);

    /**
     * Remove a player
     *
     * @param PlayerNumValueObject $num
     * @return Player | null The removed player or null if did not exist
     */
    public function remove(PlayerNumValueObject $num);
}