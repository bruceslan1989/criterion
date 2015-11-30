<?php
/**
 * Created by PhpStorm.
 * User: Ruslans
 * Date: 11/30/2015
 * Time: 9:47 AM
 */

namespace Criterion\Contracts;

use Criterion\Criteria\Criteria;

/**
 * Interface CriteriaInterface
 */
interface CriteriaInterface
{
    /**
     * @param bool $status
     *
     * @return $this
     */
    public function skipCriteria($status = true);

    /**
     * @return mixed
     */
    public function getCriteria();

    /**
     * @param Criteria $criteria
     *
     * @return $this
     */
    public function getByCriteria(Criteria $criteria);

    /**
     * @param Criteria $criteria
     *
     * @return $this
     */
    public function pushCriteria(Criteria $criteria);

    /**
     * @return $this
     */
    public function applyCriteria();
}