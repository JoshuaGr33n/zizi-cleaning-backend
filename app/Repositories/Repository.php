<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Repository
{
    protected $model;

    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    public function setQuery()
    {
        return $this->model->query();
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getObj()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);
        if ($record) {
            $record->update($data);
            return $record;
        }
        return null;
    }
    

    public function delete($id)
    {
        $record = $this->find($id);
        if ($record) {
            return $record->delete();
        }
        return null;
    }
}
