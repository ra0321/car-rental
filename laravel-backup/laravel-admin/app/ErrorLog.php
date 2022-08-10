<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ErrorLog
 *
 * @property int $id
 * @property string|null $status_code
 * @property string|null $message
 * @property string|null $file
 * @property string|null $line
 * @property string|null $code
 * @property string|null $sql_error
 * @property string|null $error_info
 * @property string|null $model
 * @property string|null $exception_trace
 * @property string|null $headers
 * @property string|null $ids
 * @property string|null $exception_previous
 * @property string|null $severity
 * @property int|null $user_id
 * @property int|null $car_id
 * @property int|null $trip_id
 * @property int|null $trip_bill_id
 * @property int|null $chat_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereCarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereErrorInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereExceptionPrevious($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereExceptionTrace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereHeaders($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereSeverity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereSqlError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereStatusCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereTripBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $request_uri
 * @property string|null $redirect_uri
 * @property string|null $referer
 * @property string|null $user_agent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereRedirectUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereReferer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereRequestUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ErrorLog query()
 */
class ErrorLog extends Model
{
	protected $fillable = [
		'request_uri', 'redirect_uri', 'referer', 'user_agent', 'exception_trace', 'exception_previous', 'file', 'line',
		'message', 'code', 'severity', 'model', 'ids', 'status_code', 'headers', 'error_info', 'sql_error', 'user_id'
	];
}
