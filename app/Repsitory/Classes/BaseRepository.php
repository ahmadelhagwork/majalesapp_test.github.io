<?php

namespace App\Repsitory\Classes;

use App\Scopes\LanguageScope;
use Illuminate\Database\Eloquent\Model;
use App\Repsitory\InterFaces\IBaseRepository;

class BaseRepository implements IBaseRepository
{
    /**
     * @var object
     */
    protected $model;
    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    /**
     * get all rows in model using App\Scopes\LanguageScope
     *
     * @return array
     */
    public function All()
    {
        return $this->model->get();
    }
    /**
     * get all rows in model by Pagniate
     *
     * @return array
     */
    public function AllbyPagniate()
    {
        return $this->model->paginate(4);
    }
    /**
     * Get By Pagniate
     *
     * @param array $data
     *
     * @param int $number
     *
     * @return array
     */
    public function GetByPagniate(array $data = null, int $number = null)
    {
        $number = ($number != null) ? $number : $number;

        $query = ($data != null) ? $this->model->with($data)->paginate($number) : $this->model->paginate($number);

        return $query;
    }
    /**
     * get all rows in model without App\Scopes\LanguageScope
     *
     * @return array
     */
    public function AllWithOutLanguageScope()
    {
        return $this->model
            ->withoutGlobalScope(LanguageScope::class)
            ->get();
    }
    /**
     * get one row in model using App\Scopes\LanguageScope
     *
     * @param $id
     *
     * @return array
     */
    public function GetbyId($id)
    {
        return $this->model->find($id);
    }
    /**
     * get master details
     *
     * @param $id
     *
     * @param array $data
     *
     * @return array
     */
    public function GetbyIdWith(array $data, $id)
    {
        return $this->model->with($data)->where('id', $id)->get();
    }
    /**
     * get master details
     *
     * @param mixed $key
     *
     * @param mixed $value
     *
     * @param array $data
     *
     * @return array
     */
    public function GetbyColumsWith(array $data, $key, $value)
    {
        return $this->model->with($data)->where($key, $value)->get();
    }
    /**
     * get master details
     *
     * @param $id
     *
     * @param array $data
     *
     * @return array|mixed
     */
    public function GetRowbyIdWith(array $data, $id)
    {
        return $this->model->with($data)->where('id', $id)->firstOrFail();
    }
    /**
     * get one row in model without App\Scopes\LanguageScope
     *
     * @param $id
     *
     * @return array
     */
    public function GetbyIdWithOutLanguageScope($id)
    {
        return $this->model
            ->withoutGlobalScope(LanguageScope::class)
            ->find($id);
    }

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function Create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * Update
     *
     * @param array $attributes
     *
     * @param mixed $id
     *
     * @return void
     */
    public function Update(array $attributes, $id)
    {
        return $this->model
            ->withoutGlobalScope(LanguageScope::class)
            ->where('id', $id)
            ->update($attributes);
    }
    /**
     * delete row by id
     *
     * @param mixed $id
     *
     * @return void
     */
    public function Delete($id)
    {
        return $this->model->where('id', $id)->delete();
    }
    /**
     * Get Single Data By Where
     *
     * @param mixed $key
     *
     * @param mixed $value
     *
     * @return array
     */
    public function DeleteByColum($key, $value)
    {
        return $this->model->where($key, $value)->delete();
    }
    /**
     * get data with relation
     *
     * @param array $data
     *
     * @return array
     */
    public function GetAllWith(array $data)
    {
        return $this->model->with($data)->get();
    }
    /**
     * @param array $attributes
     *
     * @param $key
     *
     * @param $value
     *
     * @return void
     */
    public function UpdateSelectKey(array $attributes, $key, $value)
    {
        return $this->model->where($key, $value)->update($attributes);
    }
    /**
     * Get Single Data By Where
     *
     * @param mixed $key
     *
     * @param mixed $value
     *
     * @return array
     */
    public function GetSingleDataByWhere($key, $value)
    {
        return $this->model->where($key, $value)->firstOrFail();
    }
    /**
     * Get Data By Where
     *
     * @param mixed $key
     *
     * @param mixed $value
     *
     * @return array
     */
    public function GetDataByWhere($key, $value)
    {
        return $this->model->where($key, $value)->get();
    }
    /**
     * Get Where Value In Key Is Null
     *
     * @param mixed $value
     *
     * @return array
     */
    public function GetWhereNull($value)
    {
        return $this->model->whereNull($value)->get();
    }
    /**
     * Get Where Value In Key Is Not Null
     *
     * @param mixed $value
     *
     * @return array
     */
    public function GetWhereNotNull($value)
    {
        return $this->model->whereNotNull($value)->get();
    }
}
