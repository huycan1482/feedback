<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use App\User;
use Exception;

abstract class EloquentRepository implements RepositoryInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $_model;

    /**
     * EloquentRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get model
     * @return string
     */
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->_model = app()->make(
            $this->getModel()
        );
    }

    /**
     * Get All
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->_model->latest()->get();
    }

    public function getAllWithTrashed()
    {
        return $this->_model->onlyTrashed()->latest()->get();
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->_model->find($id);

        return $result;
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function findWithTrashed($id)
    {
        $result = $this->_model->withTrashed()->find($id);

        return $result;
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function check($id)
    {
        $result = $this->_model->find($id);

        if (empty($result)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function checkWithTrashed($id)
    {
        $result = $this->_model->withTrashed()->find($id);

        if (empty($result)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function createModel($attributes)
    {
        try {
            return $this->_model->create($attributes);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function updateModel($id, array $attributes)
    {
        try {
            $result = $this->_model->find($id);
            if ($result) {
                $result->update($attributes);
                return $result;
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Delete
     *
     * @param $id
     * @return bool
     */
    public function deleteModel($id)
    {
        try {
            $result = $this->_model->find($id);
            if ($result) {
                $result->delete();
                return true;
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }


    /**
     * forceDeleteDelete
     * @param $id
     * @return mixed
     */
    public function forceDeleteModel($id)
    {
        try {
            $result = $this->_model->withTrashed()->find($id);
            if ($result) {
                $result->forceDelete();
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * restore
     * @param $id
     * @return mixed
     */
    public function restoreModel($id)
    {
        try {
            $result = $this->_model->withTrashed()->find($id);
            if ($result) {
                $result->restore();
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}
