<?php

namespace Geccomedia\Weclapp\Tests\Model;

use Geccomedia\Weclapp\Models\Contact;
use Geccomedia\Weclapp\Models\Customer;
use Geccomedia\Weclapp\SubModelCast;
use Geccomedia\Weclapp\SubModels\OnlyId;
use Geccomedia\Weclapp\SubModels\SalesOrderItem;
use Geccomedia\Weclapp\Tests\Concerns\UsesServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * Verifies that assigning a full Model instance to an OnlyId-casted list
 * automatically reduces it to {"id": "..."} in the serialised payload.
 */
class OnlyIdCoercionTest extends OrchestraTestCase
{
    use UsesServiceProvider;

    public function test_model_instance_in_only_id_list_is_reduced_to_id(): void
    {
        $contact = new Contact;
        $contact->id = '42';

        $cast = new SubModelCast(OnlyId::class);
        $result = $cast->set(new Customer, 'contacts', [$contact], []);

        $this->assertSame(['contacts' => [['id' => '42']]], $result);
    }

    public function test_only_id_instance_passes_through_unchanged(): void
    {
        $onlyId = new OnlyId(['id' => '7']);

        $cast = new SubModelCast(OnlyId::class);
        $result = $cast->set(new Customer, 'contacts', [$onlyId], []);

        $this->assertSame(['contacts' => [['id' => '7']]], $result);
    }

    public function test_mixed_list_of_models_and_only_ids_is_coerced(): void
    {
        $contact = new Contact;
        $contact->id = '1';

        $onlyId = new OnlyId(['id' => '2']);

        $cast = new SubModelCast(OnlyId::class);
        $result = $cast->set(new Customer, 'contacts', [$contact, $onlyId], []);

        $this->assertSame(['contacts' => [['id' => '1'], ['id' => '2']]], $result);
    }

    public function test_non_only_id_cast_does_not_reduce_model_to_id_only(): void
    {
        // For non-OnlyId casts, a Model cast to array keeps all its attributes
        // (falls through to (array) $item — no silent data loss for other SubModels).
        $cast = new SubModelCast(SalesOrderItem::class);

        // A plain array is the common case; verify it still passes through.
        $result = $cast->set(new Customer, 'orderItems', [['articleId' => 'X']], []);

        $this->assertSame(['orderItems' => [['articleId' => 'X']]], $result);
    }
}
