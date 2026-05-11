<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

/**
 * @property string $partyType
 */
class Customer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer';

    /**
     * Customer constructor.
     *
     * @codeCoverageIgnore
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (! in_array('partyType', array_keys($attributes))) {
            $this->partyType = 'ORGANIZATION';
        }
    }
}
