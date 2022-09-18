<?php

namespace App\Validators\Rules;

class Csv implements Rule
{
    /**
     * @var string $regex regular expression for csv line
     */
    private $regex;

    /**
     * @var bool $skipFirstLine
     */
    private $skipFirstLine;

    /**
     * @param string $scheme scheme file name
     */
    public function __construct($regex, $skipFirstLine=false)
    {
        $this->regex = $regex;
        $this->skipFirstLine = $skipFirstLine;
    }

    public function validate($value): bool
    {
        if (! is_readable($filename = $value['tmp_name'])) {
            return false;
        }

        foreach (file($filename) as $i => $line) {
            if ($this->skipFirstLine and ! $i) {
                continue;
            }

            if (! $this->isValidLine($line)) {
                return false;
            }
        }

        return true;
    }

    public function message(): string
    {
        return 'CSV file in invalid.';
    }

    /**
     * Validation csv line
     * 
     * @param string $line csv line
     * @return bool
     */
    private function isValidLine($line)
    {
        if (! preg_match($this->regex, trim($line))) {
            return false;
        }

        return true;
    }
}
