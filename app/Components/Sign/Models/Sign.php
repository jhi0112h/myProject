<?php

namespace App\Components\Sign\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class signs
 * @package App\Components\Sign\Models
 * @version September 21, 2018, 8:58 am UTC
 *
 * @property integer mb_id
 * @property string company
 * @property integer pay
 * @property string day
 * @property integer period
 * @property string keyword
 * @property string service
 * @property string phone
 * @property string email
 * @property string comment
 * @property string file
 * @property string progress
 * @property string receipt
 * @property string homepage_url
 * @property mixed user
 */
class Sign extends Model
{
    use Searchable;

    public $table = 'signs';

    protected $searchable = [
        'company',
        'mb_name',
        'phone',
        'email'
    ];

    public $fillable = [
        'mb_id',
        'company',
        'pay',
        'day',
        'period',
        'keyword',
        'service',
        'phone',
        'email',
        'comment',
        'file',
        'progress',
        'receipt',
        'homepage_url'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'mb_id' => 'integer',
        'company' => 'string',
        'pay' => 'integer',
        'day' => 'string',
        'period' => 'integer',
        'keyword' => 'string',
        'service' => 'string',
        'phone' => 'string',
        'email' => 'string',
        'comment' => 'string',
        'file' => 'string',
        'progress' => 'string',
        'receipt' => 'string',
        'homepage_url' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company' => 'required',
        'email' => 'required',
    ];

    public function user()
    {
        return $this->belongsTo('App\Components\User\Models\User', 'mb_id');
    }

    /**
     * the productProcess related
     *
     * @return mixed
     */
    public function productProcess()
    {
        return $this->hasMany('App\Components\Sign\Models\ProductProcess', 'sign_id');
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $signs = $this->toArray();

        // user infomation
        $signs['mb_name'] = $this->user->name;

        if(count($this->productProcess) > 0) {
            $signs['progress'] = $this->productProcess[0]['state'];
        }

        return $signs;
    }
}
