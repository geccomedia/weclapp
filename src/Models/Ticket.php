<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttribute;
use Geccomedia\Weclapp\SubModels\EntityReference;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $assignedPoolingGroupId
 * @property string|null $assignedUserId
 * @property bool|null $billable
 * @property string|null $billableStatus
 * @property string|null $ccEmailAddresses
 * @property string|null $contactId
 * @property string|null $contractId
 * @property list<CustomAttribute>|null $customAttributes
 * @property string|null $description
 * @property bool|null $disableEmailTemplates
 * @property string|null $email
 * @property list<EntityReference>|null $entityReferences
 * @property Carbon|null $finishedDate
 * @property string|null $firstName
 * @property Carbon|null $followUpDate
 * @property string|null $invoicingStatus
 * @property bool|null $isTemplate
 * @property string|null $language
 * @property string|null $lastName
 * @property string|null $legacyArticleId
 * @property bool|null $legacyTimeAndMaterialTicket
 * @property string|null $mail2TicketId
 * @property string|null $mobilePhoneNumber
 * @property string|null $note
 * @property string|null $partyId
 * @property string|null $performanceRecordedStatus
 * @property string|null $phoneNumber
 * @property Carbon|null $publicPageExpirationDate
 * @property string|null $publicPageUuid
 * @property bool|null $resolvedYourIssue
 * @property string|null $responsibleUserId
 * @property string|null $room
 * @property string|null $salesOrderId
 * @property Carbon|null $solutionDueDate
 * @property string|null $subject
 * @property array|null $tags
 * @property string|null $ticketCategoryId
 * @property string|null $ticketChannelId
 * @property string|null $ticketNumber
 * @property string|null $ticketPriorityId
 * @property string|null $ticketRating
 * @property string|null $ticketRatingComment
 * @property Carbon|null $ticketRatingDate
 * @property string|null $ticketServiceLevelAgreementId
 * @property string|null $ticketStatusId
 * @property string|null $ticketTypeId
 * @property list<OnlyId>|null $watchers
 */
class Ticket extends Model
{
    /**
     * @var array<string, class-string|string>
     */
    protected $casts = [
        'customAttributes' => CustomAttribute::class,
        'entityReferences' => EntityReference::class,
        'watchers' => OnlyId::class,
    ];

    /**
     * @return BelongsTo
     */
    public function assignedPoolingGroup()
    {
        return $this->belongsTo(TicketPoolingGroup::class, 'assignedPoolingGroupId');
    }

    /**
     * @return BelongsTo
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assignedUserId');
    }

    /**
     * @return BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Party::class, 'contactId');
    }

    /**
     * @return BelongsTo
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contractId');
    }

    /**
     * @return BelongsTo
     */
    public function legacyArticle()
    {
        return $this->belongsTo(Article::class, 'legacyArticleId');
    }

    /**
     * @return BelongsTo
     */
    public function party()
    {
        return $this->belongsTo(Party::class, 'partyId');
    }

    /**
     * @return BelongsTo
     */
    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsibleUserId');
    }

    /**
     * @return BelongsTo
     */
    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'salesOrderId');
    }

    /**
     * @return BelongsTo
     */
    public function ticketCategory()
    {
        return $this->belongsTo(TicketCategory::class, 'ticketCategoryId');
    }

    /**
     * @return BelongsTo
     */
    public function ticketServiceLevelAgreement()
    {
        return $this->belongsTo(TicketServiceLevelAgreement::class, 'ticketServiceLevelAgreementId');
    }

    /**
     * @return BelongsTo
     */
    public function ticketStatus()
    {
        return $this->belongsTo(TicketStatus::class, 'ticketStatusId');
    }

    /**
     * @return BelongsTo
     */
    public function ticketType()
    {
        return $this->belongsTo(TicketType::class, 'ticketTypeId');
    }

    public function ticketChannel(): BelongsTo
    {
        return $this->belongsTo(TicketChannel::class, 'ticketChannelId');
    }

    /**
     * POST /createPerformanceRecord
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPerformanceRecord(array $params = []): ?array
    {
        return $this->callAction('createPerformanceRecord', $params, 'POST');
    }

    /**
     * POST /createPublicPage
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function createPublicPage(array $params = []): ?array
    {
        return $this->callAction('createPublicPage', $params, 'POST');
    }

    /**
     * POST /disablePublicPage
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function disablePublicPage(array $params = []): ?array
    {
        return $this->callAction('disablePublicPage', $params, 'POST');
    }

    /**
     * POST /linkSalesOrder
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function linkSalesOrder(array $params = []): ?array
    {
        return $this->callAction('linkSalesOrder', $params, 'POST');
    }

    /**
     * POST /unlinkSalesOrder
     *
     * @param  array<mixed>  $params  JSON body forwarded to the API.
     * @return array<mixed>|null
     */
    public function unlinkSalesOrder(array $params = []): ?array
    {
        return $this->callAction('unlinkSalesOrder', $params, 'POST');
    }
}
