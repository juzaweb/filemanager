<?php

namespace Tadcms\FileManager\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Tadcms\FileManager\Models\FolderMedia
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int|null $parent_id
 * @property int|null $user_id
 * @property string|null $user_model
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|FolderMedia[] $childs
 * @property-read int|null $childs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Tadcms\FileManager\Models\Media[] $files
 * @property-read int|null $files_count
 * @property-read FolderMedia|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|FolderMedia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FolderMedia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FolderMedia query()
 * @method static \Illuminate\Database\Eloquent\Builder|FolderMedia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FolderMedia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FolderMedia whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FolderMedia whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FolderMedia whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FolderMedia whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FolderMedia whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FolderMedia whereUserModel($value)
 * @mixin \Eloquent
 */
class FolderMedia extends Model
{
    protected $table = 'folder_media';
    protected $fillable = [
        'name',
        'type',
        'parent_id',
        'user_id',
        'user_model',
    ];
    
    public function parent()
    {
        return $this->belongsTo('Tadcms\FileManager\Models\FolderMedia', 'parent_id', 'id');
    }
    
    public function childs()
    {
        return $this->hasMany('Tadcms\FileManager\Models\FolderMedia', 'parent_id', 'id');
    }
    
    public function files()
    {
        return $this->hasMany('Tadcms\FileManager\Models\Media', 'folder_id', 'id');
    }
}
