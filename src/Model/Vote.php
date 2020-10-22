<?php

declare(strict_types=1);

namespace Rszewc\Thecats\Model;

use Illuminate\Support\Collection;
use Carbon\Carbon;

class Vote
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $imageId;

    /**
     * @var string
     */
    private $subId;

    /**
     * @var int
     */
    private $value;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $countryCode;

    public static function createFromArray(array $data) : Collection
    {
        $votes = new Collection();
        foreach ($data as $voteData) {
            $votes->push(self::create($voteData));
        }
        return $votes;
    }

    /**
     * @param array $data
     * @return \self
     */
    public static function create(array $data) : self
    {
        $model = new self();
        $model->id = $data['id'] ?? null;
        $model->imageId = $data['image_id'];
        $model->subId = $data['sub_id'] ?? null;
        $model->value = $data['value'];
        $model->countryCode = $data['country_code'] ?? null;
        if (isset($data['created_at'])) {
            $model->createdAt = Carbon::parse($data['created_at']);
        }
        return $model;
    }
}
