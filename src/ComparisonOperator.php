<?php

namespace Geccomedia\Weclapp;

/**
 * Class WeclappOperator.
 */
class ComparisonOperator
{
    const EQ = 'eq';
    const GT = 'gt';
    const GE = 'ge';
    const LT = 'lt';
    const LE = 'le';
    const NE = 'ne';
    const IN = 'in';
    const NOT_IN = 'notin';
    const NULL = 'null';
    const NOT_NULL = 'notnull';
    const LIKE = 'like';
    const NOT_LIKE = 'notlike';
    const ILIKE = 'ilike';
    const NOT_ILIKE = 'notilike';

    public static function getOperatorMapping()
    {
        return [
            '=' => static::EQ,
            '!=' => static::NE,
            '>' => static::GT,
            '>=' => static::GE,
            '<' => static::LT,
            '<=' => static::LE,
            'in' => static::IN,
            'not_in' => static::NOT_IN,
            'null' => static::NULL,
            'not_null' => static::NOT_NULL,
            'like' => static::LIKE,
            'not_like' => static::NOT_LIKE,
            'ilike' => static::ILIKE,
            'not_ilike' => static::NOT_ILIKE,
        ];
    }

    public static function getSupportedOperators()
    {
        return array_keys(static::getOperatorMapping());
    }

    public static function isValidOperator($operator)
    {
        $operator = strtolower($operator);

        $mapping = static::getOperatorMapping();

        return isset($mapping[$operator]);
    }

    public static function getWeclappOperator($operator)
    {
        $mapping = static::getOperatorMapping();

        $operator = strtolower($operator);

        return $mapping[$operator];
    }

    public static function getQuerySupportedOperators($isRangeKey = false)
    {
        if ($isRangeKey) {
            return [
                static::EQ,
                static::NE,
                static::GT,
                static::GE,
                static::LT,
                static::LE,
                static::IN,
                static::NOT_IN,
                static::NULL,
                static::NOT_NULL,
                static::LIKE,
                static::NOT_LIKE,
                static::ILIKE,
                static::NOT_ILIKE,
            ];
        }

        return [static::EQ];
    }

    public static function isValidQueryOperator($operator, $isRangeKey = false)
    {
        $dynamoDbOperator = static::getWeclappOperator($operator);

        return static::isValidQueryWeclappOperator($dynamoDbOperator, $isRangeKey);
    }

    public static function isValidQueryWeclappOperator($dynamoDbOperator, $isRangeKey = false)
    {
        return in_array($dynamoDbOperator, static::getQuerySupportedOperators($isRangeKey));
    }

    public static function is($op, $dynamoDbOperator)
    {
        $mapping = static::getOperatorMapping();
        return $mapping[strtolower($op)] === $dynamoDbOperator;
    }
}