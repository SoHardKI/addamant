<?php

namespace App\Services\ReaderService\Interfaces;

/**
 * Interface ReaderInterface
 * @package App\Services\ReaderService\Interfaces
 */
interface ReaderInterface
{
    /**
     * @param string $filePath
     */
    public function readFile(string $filePath):void;
}
