<?php

declare(strict_types=1);

namespace Rszewc\Thecats\Model;

use Illuminate\Support\Collection;

abstract class ModelFactory
{
    public static function createFromArray(array $data) : Collection
    {
        $modelCollection = new Collection();
        foreach ($data as $modelData) {
            $modelCollection->push(static::create($modelData));
        }
        return $modelCollection;
    }

}
