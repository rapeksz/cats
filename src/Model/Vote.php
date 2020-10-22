<?php

declare(strict_types=1);

namespace Rszewc\Thecats\Model;

use Illuminate\Support\Collection;
use JsonSerializable;
use Carbon\Carbon;

class Vote implements JsonSerializable, ApiResponse
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

    /**
     * @return array
     */
    public function __toArray() : array
    {
        $vars = [
            'image_id' => $this->imageId,
            'value' => $this->value,
        ];
        if (!is_null($this->id)) {
            $vars['id'] = $this->id;
        }
        if (!is_null($this->subId)) {
            $vars['sub_id'] = $this->subId;
        }
        if (!is_null($this->createdAt)) {
            $vars['created_at'] = $this->createdAt;
        }
        if (!is_null($this->countryCode)) {
            $vars['country_code'] = $this->countryCode;
        }
        return $vars;
    }

    /**
     * @return string
     */
    public function jsonSerialize() : string
    {
        return json_encode($this->__toArray());
    }

}
