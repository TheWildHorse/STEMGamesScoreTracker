<?php


namespace App\Enum;

/**
 * Class EventStateEnum
 * @package App\Enum
 */
class EventStateEnum
{

    const STATE_SCHEDULED = 1;
    const STATE_PROGRESS = 2;
    const STATE_ENDED = 3;

    /**
     * @param $stateId
     * @return null|string
     */
    public static function getLabel($stateId) {
        switch ($typeId) {
            case self::STATE_SCHEDULED:
                return 'Scheduled';
            case self::STATE_PROGRESS:
                return 'In Progres';
            case self::STATE_ENDED:
                return 'Ended';
        }
        return null;
    }

}