<?php
/**
 * Created by PhpStorm.
 * User: Ruslans
 * Date: 11/30/2015
 * Time: 9:50 AM
 */

namespace Criterion\Eloquent;

use Criterion\Contracts\RepositoryInterface;
use Criterion\Contracts\CriteriaInterface;
use Criterion\Criteria\Criteria;
use Criterion\Entities\BaseModel;
use Criterion\Exceptions\RepositoryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

/**
 * Class EloquentRepository
 *
 * @package Criterion\Eloquent
 */
class EloquentRepository implements RepositoryInterface, CriteriaInterface
{
    /**
     * @var App
     */
    private $app;

    /**
     * @var
     */
    protected $model;

    /**
     * @var Collection
     */
    protected $criteria;

    /**
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     * @param App $app
     * @param Collection $collection
     *
     * @throws RepositoryException
     */
    public function __construct(App $app, Collection $collection)
    {
        $this->app = $app;
        $this->criteria = $collection;
        $this->resetScope();
        $this->makeModel();
    }

    /**
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        $this->applyCriteria();
        return $this->model->get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     *
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = ['*'])
    {
        $this->applyCriteria();
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param $id
     *
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $entity = $this->model->find($id);
        $entity = $entity->fill($data);
        $entity->save();

        return $entity;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        $this->applyCriteria();
        return $this->model->find($id, $columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = ['*'])
    {
        $this->applyCriteria();
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @return BaseModel
     *
     * @throws RepositoryException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());
        if (!$model instanceof BaseModel)
        {
            throw new RepositoryException("Class {$this->model()} must be an instance of Criterion\\Entities\\BaseModel;");
        }

        return $this->model = $model->newQuery();
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @param int $limit
     *
     * @return mixed
     */
    public function getBy($attribute, $value, $columns = ['*'], $limit = 10)
    {
        $this->applyCriteria();
        return $this->model->where($attribute, 'like', $value . '%')->limit($limit)->get($columns);
    }

    /**
     * @return $this
     */
    public function resetScope()
    {
        $this->skipCriteria(false);
        return $this;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function skipCriteria($status = true)
    {
        $this->skipCriteria = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @param Criteria $criteria
     *
     * @return $this
     */
    public function getByCriteria(Criteria $criteria)
    {
        $this->model = $criteria->apply($this->model, $this);
        return $this;
    }

    /**
     * @param Criteria $criteria
     *
     * @return $this
     */
    public function pushCriteria(Criteria $criteria)
    {
        $this->criteria->push($criteria);
        return $this;
    }

    /**
     * @return $this
     */
    public function  applyCriteria()
    {
        if($this->skipCriteria === true)
        {
            return $this;
        }

        foreach($this->getCriteria() as $criteria)
        {
            if($criteria instanceof Criteria)
            {
                $this->model = $criteria->apply($this->model, $this);
            }
        }

        return $this;
    }
}