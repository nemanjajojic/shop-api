<?php

namespace App\Order\Domain\ValueObject;

class SortBy
{
    const VALID_FIELDS_FOR_SORTING = [
        'totalAmount' => 'total',
        'createdAt'   => 'created_at'
    ];
    const VALID_DIRECTIONS = [
        'asc',
        'desc'
    ];
    /**
     * @var string
     */
    private $direction;
    /**
     * @var string
     */
    private $fieldName;

    public function __construct(
        ?string $fieldName,
        ?string $direction
    ) {

        if ($direction !== null) {
            if (!in_array(strtolower($direction), self::VALID_DIRECTIONS)) {
                throw new \InvalidArgumentException('Invalid direction value. Use asc or desc.');
            }
        }

        if ($fieldName !== null) {
            if (!array_key_exists($fieldName, self::VALID_FIELDS_FOR_SORTING)) {
                throw new \InvalidArgumentException('Invalid sorting field value.');
            }
        }

        $this->direction = $direction;
        $this->fieldName = $fieldName;
    }

    /**
     * @return string
     */
    public function getFieldName(): string
    {
        if ($this->fieldName === null) {
            return self::VALID_FIELDS_FOR_SORTING['createdAt'];
        }

        return  self::VALID_FIELDS_FOR_SORTING[$this->fieldName];
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        if ($this->direction === null) {
            return self::VALID_DIRECTIONS[1];
        }

        return $this->direction;
    }
}