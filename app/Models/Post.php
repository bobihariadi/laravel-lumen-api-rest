<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Post extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     *  @OA\Schema(
     *      schema="Posts",
     *      @OA\Property(
     *          property="id",
     *          type="integer",
     *          format="int64"
     *      ),
     *      @OA\Property(
     *          property="title",
     *          type="string"
     *      ),
     *      @OA\Property(
     *          property="body",
     *          type="string"
     *      ),
     *      @OA\Property(
     *          property="view",
     *          type="integer",
     *          format="int64"
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
     *      )
     * )
     */

    /**
     *  @OA\Schema(
     *      schema="SamplePostsInsert",
     *      @OA\Property(
     *          property="title",
     *          type="string"
     *      ),
     *      @OA\Property(
     *          property="body",
     *          type="string"
     *      ),
     *      @OA\Property(
     *          property="views",
     *          type="integer",
     *          format="int64"
     *      )
     * )
     */
    protected $fillable = [
        'title', 'body', 'views'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s'
    ];

}
