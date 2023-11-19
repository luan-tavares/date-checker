<?php

namespace LTL\DateChecker;

use LTL\DateChecker\AbstractDate;

class BrazilDate extends AbstractDate
{
    protected array $formats = [
        'd/m/Y',
        'd/m/Y H:i',
        'd/m/Y H:i:s',
        'd/m/Y\TH:i',
        'd/m/Y\TH:i:s'
    ];

    protected function regex(): string
    {
        $timeRegex = '[T\s]([0-1][0-9]|2[0-3])\:([0-5][0-9])(\:([0-5][0-9]))?';

        $month31Regex = "(0?[1-9]|[1-2][0-9]|3[0-1])[\/](0?1|0?3|0?5|0?7|0?8|10|12)[\/]((19|2[0-9])\d{2})({$timeRegex})?";

        $month30Regex = "(0?[1-9]|[1-2][0-9]|30)[\/](0?4|0?6|0?9|11)[\/]((19|2[0-9])\d{2})({$timeRegex})?";

        $month28Regex = "(0?[1-9]|1[0-9]|2[0-8])[\/](0?2)[\/]((19|2[0-9])\d{2})({$timeRegex})?";

        $month29LeapYearRegex = "(0?[1-9]|[12][0-9])[\/](0?2)[\/]((([2468][048]|[13579][26])00)|(\d{2}([02468][48]|[2468][048]|[13579][26])))({$timeRegex})?";

        return "/^({$month31Regex})$|^({$month30Regex})$|^({$month28Regex})$|^({$month29LeapYearRegex})$/";
    }
}
