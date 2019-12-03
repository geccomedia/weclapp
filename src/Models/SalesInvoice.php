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
    protected $dates = [
        'createdDate',
        'deliveryDate',
        'dueDate',
        'invoiceDate',
        'lastModifiedDate',
        'pricingDate',
        'servicePeriodFrom',
        'servicePeriodTo',
        'shippingDate'
    ];
}
