<?php namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;

class SalesInvoice extends Model
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
    protected $casts = [
        'createdDate' => 'datetime',
        'deliveryDate' => 'datetime',
        'dueDate' => 'datetime',
        'invoiceDate' => 'datetime',
        'lastModifiedDate' => 'datetime',
        'pricingDate' => 'datetime',
        'servicePeriodFrom' => 'datetime',
        'servicePeriodTo' => 'datetime',
        'shippingDate' => 'datetime'
    ];
}
