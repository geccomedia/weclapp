<?php

namespace Geccomedia\Weclapp\Models;

use Carbon\Carbon;
use Geccomedia\Weclapp\Model;

/**
 * @property string|null $assignedPoolingGroupId
 * @property string|null $assignedUserId
 * @property bool|null $billable
 * @property string|null $billableStatus
 * @property string|null $ccEmailAddresses
 * @property string|null $contactId
 * @property string|null $contractId
 * @property array|null $customAttributes
 * @property string|null $description
 * @property bool|null $disableEmailTemplates
 * @property string|null $email
 * @property array|null $entityReferences
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
 * @property array|null $watchers
 */
class Ticket extends Model {}
