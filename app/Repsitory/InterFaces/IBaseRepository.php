<?php

namespace App\Repsitory\InterFaces;

interface IBaseRepository
{
 /**
     * get all rows in model using App\Scopes\LanguageScope
     *
     * @return array
     */
    public function All();
    /**
     * get all rows in model by Pagniate
     *
     * @return array
     */
    public function AllbyPagniate();
    /**
     * Get By Pagniate
     *
     * @param array $data
     *
     * @param int $number
     *
     * @return array
     */
    public function GetByPagniate(array $data = null,int $number = null);
    /**
     * get all rows in model without App\Scopes\LanguageScope
     *
     * @return array
     */
    public function AllWithOutLanguageScope();
    /**
     * get one row in model using App\Scopes\LanguageScope
     *
     * @param $id
     *
     * @return array
     */
    public function GetbyId($id);
    /**
     * get master details
     *
     * @param $id
     *
     * @param array $data
     *
     * @return array
     */
    public function GetbyIdWith(array $data, $id);
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
    public function GetbyColumsWith(array $data, $key, $value);
    /**
     * get master details
     *
     * @param $id
     *
     * @param array $data
     *
     * @return array|mixed
     */
    public function GetRowbyIdWith(array $data, $id);
    /**
     * get one row in model without App\Scopes\LanguageScope
     *
     * @param $id
     *
     * @return array
     */
    public function GetbyIdWithOutLanguageScope($id);
    /**
     * @param array $attributes
     *
     * @return void
     */
    public function Create(array $attributes);
    /**
     * Update
     *
     * @param array $attributes
     *
     * @param mixed $id
     *
     * @return void
     */
    public function Update(array $attributes, $id);
    /**
     * delete row by id
     *
     * @param mixed $id
     *
     * @return void
     */
    public function Delete($id);
    /**
     * get data with relation
     *
     * @param array $data
     *
     * @return array
     */
    public function GetAllWith(array $data);
    /**
     * @param array $attributes
     *
     * @param $key
     *
     * @param $value
     *
     * @return void
     */
    public function UpdateSelectKey(array $attributes, $key, $value);
    /**
     * Get Single Data By Where
     *
     * @param mixed $key
     *
     * @param mixed $value
     *
     * @return array
     */
    public function GetSingleDataByWhere($key, $value);
    /**
     * Get Single Data By Where
     *
     * @param mixed $key
     *
     * @param mixed $value
     *
     * @return array
     */
    public function DeleteByColum($key, $value);
    /**
     * Get Data By Where
     *
     * @param mixed $key
     *
     * @param mixed $value
     *
     * @return array
     */
    public function GetDataByWhere($key, $value);
    /**
     * Get Where Value In Key Is Null
     *
     * @param mixed $value
     *
     * @return array
     */
    public function GetWhereNull($value);
    /**
     * Get Where Value In Key Is Not Null
     *
     * @param mixed $value
     *
     * @return array
     */
    public function GetWhereNotNull($value);
}
