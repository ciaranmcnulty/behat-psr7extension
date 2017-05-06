<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\AppFile;

use Cjm\Behat\Psr7Extension\Psr7LoaderException;

final class UnknownType extends Psr7LoaderException
{
    public function __construct($type)
    {
        parent::__construct('Do not know how to create an app from ' . $this->printableType($type));
    }

    private function printableType($type) : string
    {
        $str = gettype($type);

        if ($str == 'object') {
            $str = 'object:' . get_class($type);
        }

        return $str;
    }

}
