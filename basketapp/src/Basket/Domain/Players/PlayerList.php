<?php namespace Basket\Domain\Players;

interface PlayerList
{
    /**
     * Append a player to the list
     *
     * @param Player $player
     * @return void
     * 
     * @throws \InvalidArgumentException if player was already in the list
     */
    public function append(Player $player) : void;

    /**
     * Extract a player out the list
     *
     * @param PlayerNumValueObject $number the number of the player to be extracted
     * @return Player
     * 
     * @throws \InvalidArgumentException if player was not in the list
     */
    public function extract(PlayerNumValueObject $num) : Player;

    /**
     * Gets an array with the list of Players
     *
     * @return array[Player]
     */
    public function list() : array;

    /**
     * Sorts the players list
     *
     * @param string $property the property name
     * @return void
     * @throw \InvalidArgumentException
     */
    public function sort(string $property) : void;

    
}