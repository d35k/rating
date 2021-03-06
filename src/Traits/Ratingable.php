<?php

namespace d35k\Rating\Traits;

use d35k\Rating\Models\Rating;
use Illuminate\Database\Eloquent\Model;

trait Ratingable
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }

    /**
     *
     * @return mix
     */
    public function avgRating()
    {
        return $this->ratings()->avg('rating');

    }

    /**
     *
     * @param column
     * @param filter
     * @return mix
     */
    public function avgRatingByFilter($column, $filter)
    {
        return $this->ratings()->where($column, $filter)->avg('rating');

    }

    /**
     *
     * @return mix
     */
    public function sumRating()
    {
        return $this->ratings()->sum('rating');
    }

    /**
     * @param $max
     *
     * @return mix
     */ 
    public function ratingPercent($max = 5)
    {
        $quantity = $this->ratings()->count();
        $total = $this->sumRating();
        return ($quantity * $max) > 0 ? $total / (($quantity * $max) / 100) : 0;
    }

    /**
     *
     * @return mix
     */
    public function countPositive()
    {
        return $this->ratings()->where('rating', '>', '0')->count();
    }

    /**
     *
     * @return mix
     */
    public function countNegative()
    {
        $quantity = $this->ratings()->where('rating', '<', '0')->count();
        return ("-$quantity");
    }
    
    /**
     * @param $data
     * @param Model      $author
     * @param Model|null $parent
     *
     * @return static
     */
    public function rating($data, Model $author, Model $parent = null)
    {
        return (new Rating())->createRating($this, $data, $author);
    }

    /**
     * @param $data
     * @param Model      $author
     * @param Model|null $parent
     *
     * @return static
     */
    public function ratingUnique($data, Model $author, Model $parent = null)
    {
        return (new Rating())->createUniqueRating($this, $data, $author);
    }

    /**
     * @param $data
     * @param Model      $author
     * @param Model|null $parent
     *
     * @return static
     */
    public function ratingQuestionUnique($data, Model $author, Model $parent = null)
    {
        return (new Rating())->createUniqueQuestionRating($this, $data, $author);
    }
    
    /**
     * @param $id
     * @param $data
     * @param Model|null $parent
     *
     * @return mixed
     */
    public function updateRating($id, $data, Model $parent = null)
    {
        return (new Rating())->updateRating($id, $data);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function deleteRating($id)
    {
        return (new Rating())->deleteRating($id);
    }

    public function getAvgRatingAttribute()
    {
        return $this->avgRating();
    }

    public function getratingPercentAttribute()
    {
        return $this->ratingPercent();
    }

    public function getSumRatingAttribute()
    {
        return $this->sumRating();
    }

    public function getCountPositiveAttribute()
    {
        return $this->countPositive();
    }

    public function getCountNegativeAttribute()
    {
        return $this->countNegative();
    }
}
