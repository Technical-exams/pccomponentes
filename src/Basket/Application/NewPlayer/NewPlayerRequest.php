<?php namespace Basket\Application\NewPlayer;

use Basket\Application\Command\CommandRequest;

class NewPlayerRequest
    implements CommandRequest
{
    
    protected $num;

    protected $label;

    protected $position;

    protected $rating;

    
    public function __construct(int $num, string $label, string $position, int $rating){
        $this->num = $num;
        $this->label = $label;
        $this->position = $position;
        $this->rating = $rating;
    }

    /**
     * Getter for $num
     *
     * @return int
     */
    public function num(): int
    {
        return $this->num;
    }

    /**
     * Getter for $label
     *
     * @return string
     */
    public function label(): string
    {
        return $this->label;
    }

    /**
     * Getter for $position
     *
     * @return string
     */
    public function position(): string
    {
        return $this->position;
    }

    /**
     * Getter for $rating
     *
     * @return int
     */
    public function rating(): int
    {
        return $this->rating;
    }
}