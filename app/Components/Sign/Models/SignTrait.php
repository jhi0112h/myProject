<?php
/**
 * Created by PhpStorm.
 * User: MY
 * Date: 2018-11-23
 * Time: 오전 11:54
 */


namespace App\Components\Sign\Models;

/**
 * Class SignTrait
 * @package App\Components\Sign\Models
 */
trait SignTrait
{

    /**
     * get validation rules
     *
     * @return array
     */
    public function getValidationRules()
    {
        return self::$rules;
    }

    public function scopeOfCompany($query, $company)
    {
        if( $company === null || $company === '' ) return false;

        return $query->where('company','LIKE',"%{$company}%");
    }

    public function scopeOfMbName($query, $mb_name)
    {
        if( $mb_name === null || $mb_name === '' ) return false;

        return $query->where('mb_name','LIKE',"%{$mb_name}%");
    }

    public function scopeOfEmail($query, $email)
    {
        if( $email === null || $email === '' ) return false;

        return $query->where('email','=',$email);
    }

}