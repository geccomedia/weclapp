<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $subject
 * @property string|null $senderAddress
 * @property string|null $recipientAddresses
 * @property string|null $ccAddresses
 * @property string|null $bccAddresses
 * @property string|null $body
 * @property string|null $entityName
 * @property string|null $entityId
 * @property string|null $status
 * @property bool|null $incoming
 * @property Carbon|null $emailDate
 * @property string|null $fromAddress
 * @property string|null $messageIdentifier
 * @property string|null $replyToAddress
 * @property string|null $toAddresses
 * @property string|null $receivedDate
 */
class ArchivedEmail extends Model
{
    protected bool $creatable = false;

    protected bool $deletable = false;
}
