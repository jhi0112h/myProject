<?php

namespace App\Components\Sign\Repositories;

use App\Components\Sign\Models\ProductProcess;
use App\Components\Core\BaseRepository;

/**
 * Class ProductProcessRepository
 * @package App\Components\Sign\Repositories
 * @version September 21, 2018, 8:58 am UTC
 *
 * @method Sign findWithoutFail($id, $columns = ['*'])
 * @method Sign find($id, $columns = ['*'])
 * @method Sign first($columns = ['*'])
 */
class ProductProcessRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'state',
        'name',
    ];

    public function __construct(Sign $model)
    {
        parent::__construct($model);
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProductProcess::class;
    }

    /**
     * delete a user by id
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        $ids = explode(',',$id);

        foreach ($ids as $id)
        {
            /** @var Sign $User */
            $Process = $this->model->find($id);

            if(!$Process)
            {
                return false;
            };

            //$Process->groups()->detach();
            $Process->delete();
        }

        return true;
    }
}
