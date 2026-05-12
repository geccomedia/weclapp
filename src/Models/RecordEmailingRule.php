<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool|null $active
 * @property bool|null $attachPurchaseOrderRequestCsvFile
 * @property bool|null $attachRecordDocument
 * @property bool|null $attachReturnLabel
 * @property bool|null $attachShippingLabel
 * @property array|null $bccRecipients
 * @property array|null $ccRecipients
 * @property string|null $event
 * @property string|null $mailAccountId
 * @property string|null $name
 * @property array|null $otherRecipients
 * @property list<OnlyId>|null $paymentMethods
 * @property array|null $performanceRecordInvoicingModes
 * @property string|null $recipientType
 * @property array|null $salesChannels
 * @property array|null $salesInvoiceOrigins
 * @property array|null $salesInvoiceTypes
 * @property array|null $salesOrderOrigins
 * @property array|null $shipmentOutTypes
 * @property string|null $templateId
 */
class RecordEmailingRule extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'paymentMethods' => OnlyId::class,
    ];

    /**
     * @return BelongsTo
     */
    public function template()
    {
        return $this->belongsTo(MailTemplate::class, 'templateId');
    }
}
