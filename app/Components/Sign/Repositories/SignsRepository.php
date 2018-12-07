<?php

namespace App\Components\Sign\Repositories;

use App\Components\Sign\Models\Sign;
use App\Components\Core\BaseRepository;

/**
 * Class signsRepository
 * @package App\Repositories
 * @version September 21, 2018, 8:58 am UTC
 *
 * @method Sign findWithoutFail($id, $columns = ['*'])
 * @method Sign find($id, $columns = ['*'])
 * @method Sign first($columns = ['*'])
*/
class SignsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'sign_id',
        'mb_id',
        'mb_maker_id',
        'mb_name',
        'sign_company',
        'sign_pay',
        'sign_day',
        'sign_period',
        'sign_keyword',
        'sign_service',
        'sign_phone',
        'sign_email',
        'sign_comment',
        'sign_progress',
        'sign_receipt',
        'sign_homepage_url'
    ];

    public function __construct(Sign $model)
    {
        parent::__construct($model);
    }

    /**
     * list all signs
     *
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]|mixed[]
     */
    public function listSigns($params)
    {
        return $this->get($params,['user'],function($q) use ($params)
        {
            $q->ofCompany($params['company'] ?? '');
            $q->ofMbName($params['mb_name'] ?? '');
            return $q;
        });
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Sign::class;
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
            $Sign = $this->model->find($id);

            if(!$Sign)
            {
                return false;
            };

            //$Sign->groups()->detach();
            $Sign->delete();
        }

        return true;
    }
}
