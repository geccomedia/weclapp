<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\Campaign;
use Geccomedia\Weclapp\Models\CampaignParticipant;
use Geccomedia\Weclapp\Models\CashAccountSheet;
use Geccomedia\Weclapp\Models\Comment;
use Geccomedia\Weclapp\Models\CostCenter;
use Geccomedia\Weclapp\Models\MailTemplate;
use Geccomedia\Weclapp\Models\PriceCalculationParameter;
use Geccomedia\Weclapp\Models\Rebate;
use Geccomedia\Weclapp\Models\RecordEmailingRule;
use Geccomedia\Weclapp\Models\Reminder;
use Geccomedia\Weclapp\Models\VariantArticle;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class RelationsATest extends OrchestraTestCase
{
    use UsesServiceProvider;

    // ── PriceCalculationParameter ──────────────────────────────────────────

    public function test_price_calculation_parameter_article_category(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PriceCalculationParameter)->articleCategory());
    }

    public function test_price_calculation_parameter_article(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new PriceCalculationParameter)->article());
    }

    // ── Comment ───────────────────────────────────────────────────────────

    public function test_comment_author_user(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Comment)->authorUser());
    }

    public function test_comment_parent_comment(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Comment)->parentComment());
    }

    // ── CampaignParticipant ────────────────────────────────────────────────

    public function test_campaign_participant_campaign(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CampaignParticipant)->campaign());
    }

    public function test_campaign_participant_party(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CampaignParticipant)->party());
    }

    // ── Campaign ──────────────────────────────────────────────────────────

    public function test_campaign_responsible_user(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Campaign)->responsibleUser());
    }

    // ── CashAccountSheet ──────────────────────────────────────────────────

    public function test_cash_account_sheet_cash_account(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CashAccountSheet)->cashAccount());
    }

    // ── CostCenter ────────────────────────────────────────────────────────

    public function test_cost_center_cost_center_group(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new CostCenter)->costCenterGroup());
    }

    // ── MailTemplate ──────────────────────────────────────────────────────

    public function test_mail_template_creator(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new MailTemplate)->creator());
    }

    // ── Rebate ────────────────────────────────────────────────────────────

    public function test_rebate_customer(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Rebate)->customer());
    }

    // ── RecordEmailingRule ────────────────────────────────────────────────

    public function test_record_emailing_rule_template(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new RecordEmailingRule)->template());
    }

    // ── Reminder ──────────────────────────────────────────────────────────

    public function test_reminder_user(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Reminder)->user());
    }

    // ── VariantArticle ────────────────────────────────────────────────────

    public function test_variant_article_primary_article(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new VariantArticle)->primaryArticle());
    }
}
