<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    /**
	 * Get the category children
	 */
	public function children() {
		return $this->hasMany('App\Models\Category','parent_category_id');
	}

	/**
	 * Get the category parent
	 */
	public function parent() {
		return $this->belongsTo('App\Models\Category','parent_category_id');
	}
}
