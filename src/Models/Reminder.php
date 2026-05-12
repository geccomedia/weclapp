<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property array|null $additionalRecipients
 * @property bool|null $ccMail
 * @property string|null $entityId
 * @property string|null $entityName
 * @property Carbon|null $lastReminderSentDate
 * @property string|null $message
 * @property array|null $recurringEvent
 * @property Carbon|null $reminderDate
 * @property string|null $sendType
 * @property string|null $subject
 * @property string|null $userId
 */
class Reminder extends Model {}
