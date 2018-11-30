<?php
/**
 * Created by PhpStorm.
 * User: darryl
 * Date: 10/10/2017
 * Time: 8:29 PM
 */

namespace App\Components\File\Repositories;


use App\Components\Core\BaseRepository;
use App\Components\File\Models\FileGroup;

class FileGroupRepository extends BaseRepository
{
    public function __construct(FileGroup $model)
    {
        parent::__construct($model);
    }

    /**
     * @author darryldecode <darrylfernandez.com>
     * @since  v1.0
     *
     * @param $id
     *
     * @return bool
     * @throws \Exception
     */
    public function deleteRecordAndFile($id)
    {
        /** @var File $fileRecord */
        $fileRecord = $this->model->find($id);

        // delete record
        $fileRecord->delete();

        return true;
    }

    /**
     * list resource
     *
     * @param array $params
     * @return FileGroupRepository[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]|mixed[]
     */
    public function index($params)
    {
        return $this->get($params,[],function($q) use ($params)
        {
            $name = array_get($params,'name',null);

            if($name) $q = $q->where('name','like',"%{$name}%");

            return $q;
        });
    }
}