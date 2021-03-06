<?php

namespace Chatty\Models;

use Illuminate\Database\Eloquent\Model;

/**
* 
*/
class Status extends Model
{
	protected $table = 'posts';

	protected $fillable = [
		'body',
		/*'landmark',*/
		'source',
		'stat',
		'location'
	];

	public function user()
	{
		return $this->belongsTo('Chatty\Models\User', 'user_id');
	}

	public function scopeNotReply($query)
	{
		return $query->whereNull('parent_id');
	}

	public function replies()
	{
		return $this->hasMany('Chatty\Models\Status', 'parent_id');
	}

}

?>