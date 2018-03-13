<?php


namespace App\Enum;

/**
 * Class RankingTypeEnum
 * @package App\Enum
 */
class RankingTypeEnum
{

    const TYPE_HIGHER_BETTER = 1;
    const TYPE_LOWER_BETTER = 2;

    /**
     * @param $typeId
     * @return null|string
     */
    public static function getLabel($typeId) {
        switch ($typeId) {
            case self::TYPE_HIGHER_BETTER:
                return 'Higher is better';
            case self::TYPE_LOWER_BETTER:
                return 'Lower is better';
        }
        return null;
    }

}