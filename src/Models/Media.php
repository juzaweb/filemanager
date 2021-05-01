<?php

namespace Tadcms\FileManager\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Tadcms\FileManager\Models\Media
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property int $size
 * @property string $extension
 * @property string $mimetype
 * @property string $type
 * @property int|null $folder_id
 * @property int|null $user_id
 * @property string|null $user_model
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereFolderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereMimetype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUserModel($value)
 * @mixin \Eloquent
 * @property-read \Tadcms\FileManager\Models\FolderMedia|null $folder
 */
class Media extends Model
{
    protected $table = 'media';
    protected $fillable = [
        'name',
        'type',
        'mimetype',
        'path',
        'size',
        'extension',
        'folder_id',
        'user_id',
        'user_model',
    ];
    
    public function folder() {
        return $this->belongsTo('Tadcms\FileManager\Models\FolderMedia', 'folder_id', 'id');
    }
}
