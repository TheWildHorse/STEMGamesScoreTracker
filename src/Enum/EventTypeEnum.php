<?php


namespace App\Enum;

/**
 * Class EventTypeEnum
 * @package App\Enum
 */
class EventTypeEnum
{

    const TYPE_1V1 = 1;
    const TYPE_PLACEMENT = 2;

    /**
     * @param $typeId
     * @return null|string
     */
    public static function getLabel($typeId) {
        switch ($typeId) {
            case self::TYPE_1V1:
                return '1v1 games (tournament)';
            case self::TYPE_PLACEMENT:
                return 'Placement (each team independenly + rank list)';
        }
        return null;
    }

}