<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;
/**
 *  @OA\Schema(
 *      schema="Users",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="api_token",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="create_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="update_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="jwt_token",
 *          type="string"
 *      )
 * )
 */

 /**
 *  @OA\Schema(
 *      schema="SampleUsersUpdate",
 *      @OA\Property(
 *          property="name",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="string"
 *      )
 * )
 */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token','jwt_token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

}
