<?php namespace Basket\Domain\Players;

interface PlayersRepository
{
    /**
     * Find All Players
     *
     * @return Array The list of active players
     */
    public function findAll();
 
    
    /**
     * Prepares the sort for a search 
     *
     * @param string $property The property the search is ordered by
     * @return PlayerRepository The repository able to find Players with the requested sort order
     */
    public function sortBy(string $property): PlayersRepository;

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