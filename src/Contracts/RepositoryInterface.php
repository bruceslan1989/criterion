<?php
/**
 * Created by PhpStorm.
 * User: Ruslans
 * Date: 11/30/2015
 * Time: 9:49 AM
 */

namespace Bruceslan\Criterion\Contracts;

/**
 * Interface RepositoryInterface
 *
 * @package Bruceslan\Criterion\Contracts
 */
interface RepositoryInterface
{
    /**
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * @param int $perPage
     * @param array $columns
     *
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = ['*']);

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param array $data
     * @param $id
     *
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*']);

    /**
     * @param $field
     * @param $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findBy($field, $value, $columns = ['*']);

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @param int $limit
     *
     * @return mixed
     */
    public function getBy($attribute, $value, $columns = ['*'], $limit = 10);
}