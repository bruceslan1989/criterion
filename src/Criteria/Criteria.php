<?php
/**
 * Created by PhpStorm.
 * User: Ruslans
 * Date: 11/30/2015
 * Time: 9:48 AM
 */

namespace Bruceslan\Criterion\Criteria;

use Bruceslan\Criterion\Contracts\RepositoryInterface as Repository;

/**
 * Class Criteria
 *
 * @package Bruceslan\Criterion\Criteria
 */
abstract class Criteria
{
    /**
     * @param $model
     * @param Repository $repository
     *
     * @return mixed
     */
    public abstract function apply($model, Repository $repository);
}