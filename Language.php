<?php namespace App\Modules\Language;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {

	protected $table    = 'languages';
	protected $fillable = ['key', 'title', 'description', 'flag', 'is_active', 'is_default'];
	protected $casts    = ['is_active' => 'boolean', 'is_default' => 'boolean'];

	public function getIsActiveAttribute($value)
	{
		return $value ? 'True' : 'False';
	}

	public function getIsDefaultAttribute($value)
	{
		return $value ? 'True' : 'False';
	}
}
