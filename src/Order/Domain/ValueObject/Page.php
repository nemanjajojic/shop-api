<?php

namespace App\Order\Domain\ValueObject;

class Page
{
    /**
     * @var int
     */
    private $skip;
    /**
     * @var int
     */
    private $limit;

    public function __construct(int $skip, int $limit)
    {
        if($skip < 0) {
            throw new \InvalidArgumentException('Skip value must not be less then 0.');
        }

        if($limit < 1 || $limit > 30) {
            throw new \InvalidArgumentException('Limit value must be between 1 and 30.');
        }

        $this->skip = $skip;
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getSkip(): int
    {
        return $this->skip;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }
}