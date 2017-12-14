<?php namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\WeclappModel;

class Customer extends WeclappModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer';

    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if(!in_array('partyType', array_keys($attributes)))
        {
            $this->partyType = "ORGANIZATION";
        }
    }
}