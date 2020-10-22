<?php

declare(strict_types=1);

namespace Rszewc\Thecats\Model;

class StatusResponse implements ApiResponse
{
    /**
     * @var string|null
     */
    private $message;

    /**
     * @var int|null
     */
    private $id;

    /**
     * @param array $data
     * @return \self
     */
    public static function create(array $data) : self
    {
        $model = new self();
        $model->message = $data['message'] ?? null;
        $model->id = $data['id'] ?? null;
        return $model;
    }

    /**
     * @return string|null
     */
    public function getMessage() : ?string
    {
        return $this->message;
    }

    /**
     * @return int|null
     */
    public function getId() : ?int
    {
        return $this->code;
    }
}