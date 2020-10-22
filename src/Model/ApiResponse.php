<?php

declare(strict_types=1);

namespace Rszewc\Thecats\Model;

interface ApiResponse
{
    public static function create(array $data);
}