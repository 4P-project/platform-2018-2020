<?php

namespace App\Models\Api\Documents;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    const STATUS_NEW         = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_COMPLETED   = 3;
    const STATUS_ERROR       = 4;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'document_queue';

    public static function process()
    {
        /** @TODO */
    }
}
