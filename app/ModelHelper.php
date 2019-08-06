<?php


namespace App;
use Illuminate\Database\Eloquent\Builder;

/**
 * Этот класс создан для того, чтобы можно было распихивать аннотации магических методов по нему, чтобы легче было работать
 * @method static Builder where(\string $field, \string $operator, \string $value)
 * @method static Builder orderBy(\string $field, \string $sort)
 * @method static $this find(\int $value, array $columns=['*'])
 * @method static $this findOrFail(\int $value, array $columns=['*'])
 *
 * @method static Builder whereIn(\string $field, array $values)
 * @method static $this create(array $fields)
 *
 */

trait ModelHelper
{

}