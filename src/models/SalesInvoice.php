<?php namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\WeclappModel;

class SalesInvoice extends WeclappModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'salesInvoice';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'invoiceDate'
    ];
}