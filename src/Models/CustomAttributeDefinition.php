<?php

namespace Geccomedia\Weclapp\Models;

use Geccomedia\Weclapp\Model;
use Geccomedia\Weclapp\SubModels\CustomAttributeDefinitionConditions;
use Geccomedia\Weclapp\SubModels\CustomAttributeDefinitionListValue;
use Geccomedia\Weclapp\SubModels\CustomAttributeDefinitionPermission;
use Geccomedia\Weclapp\SubModels\CustomAttributeDefinitionTranslation;

/**
 * @property string|null $attributeKey
 * @property string|null $label
 * @property string|null $attributeType
 * @property string|null $entityType
 * @property bool|null $required
 * @property bool|null $active
 * @property list<CustomAttributeDefinitionListValue>|null $selectableValues
 * @property string|null $attributeDescription
 * @property string|null $attributeEntityType
 * @property list<CustomAttributeDefinitionTranslation>|null $attributeLabels
 * @property CustomAttributeDefinitionConditions|null $conditions
 * @property bool|null $defaultBooleanValue
 * @property string|null $defaultDateValue
 * @property float|null $defaultNumberValue
 * @property string|null $defaultStringValue
 * @property array|null $entities
 * @property string|null $groupName
 * @property bool|null $inheritOnCopy
 * @property array|null $legacyEntities
 * @property bool|null $mandatory
 * @property list<CustomAttributeDefinitionPermission>|null $permissions
 * @property array|null $publicPageTypes
 * @property bool|null $readOnly
 * @property bool|null $showAttributeEntityType
 * @property bool|null $showInOverview
 * @property bool|null $showOnCreationDialog
 * @property bool|null $systemCustomAttribute
 */
class CustomAttributeDefinition extends Model {}
