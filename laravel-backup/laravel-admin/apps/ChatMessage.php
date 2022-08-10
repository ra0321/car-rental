<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ChatMessage
 *
 * @property-read \App\Chat $trip
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ChatMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ChatMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ChatMessage query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $chat_id
 * @property int $user_id
 * @property string|null $message
 * @property string|null $image_path
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ChatMessage whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ChatMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ChatMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ChatMessage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ChatMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ChatMessage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ChatMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ChatMessage whereUserId($value)
 */
class ChatMessage extends Model
{
	protected $table = 'chat_messages';

    public function trip()
    {
        return $this->belongsTo(Chat::class);
    }
}
