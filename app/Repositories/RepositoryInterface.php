<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function setModel();
    public function getModel();

    /**
     * Get all
     * @return mixed
     */
    public function getAll();

    /**
     * Get all
     * @return mixed
     */
    public function getAllWithTrashed();

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function findWithTrashed($id);

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function check($id);

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function checkWithTrashed($id);

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function createModel($attributes);

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function updateModel($id, array $attributes);

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function deleteModel($id);

    /**
     * forceDeleteDelete
     * @param $id
     * @return mixed
     */
    public function forceDeleteModel($id);

    /**
     * restore
     * @param $id
     * @return mixed
     */
    public function restoreModel($id);

}