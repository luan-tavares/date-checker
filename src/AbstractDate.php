<?php

namespace LTL\DateChecker;

use DateTime;
use LTL\DateChecker\Exceptions\DateCheckerException;

abstract class AbstractDate
{
    protected array $formats = [];

    private Datetime $datetime;
    
    public function __construct(int|string $datetime)
    {
        if(is_integer($datetime)) {
            $date = new DateTime;
            $date->setTimestamp($datetime);

            $this->datetime = $date;
            
            return;
        }

        $this->datetime = $this->getDatetime($datetime);
    }

    public static function check(int|string $datetime): DateTime
    {
        $checker = new static($datetime);
        
        return $checker->get();
    }

    abstract protected function regex(): string;

    private function getDatetime(string $datetime): DateTime
    {
        $regex = $this->regex();

        

        if(!preg_match($regex, $datetime, $match)) {
            $this->throwException($datetime);
        }
        
        foreach ($this->formats as $format) {
            $date = Datetime::createFromFormat($format, $datetime);

            if($date instanceof DateTime) {
                return $date;
            }
        }


        $this->throwException($datetime);
    }

    private function throwException(string $datetime): void
    {
        $fomatList = str_replace('\\', '', implode('", "', $this->formats));

        throw new DateCheckerException("\"{$datetime}\" is incorrect date format.\nUse \"{$fomatList}\".\nSee leap year.");
    }

    public function get(): DateTime
    {
        return $this->datetime;
    }
}
