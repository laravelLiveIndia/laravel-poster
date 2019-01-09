<?php

namespace Laravellive\Poster;

use Illuminate\Database\Eloquent\Model;
use Laravellive\Poster\Notifications\PosterNotification;

class Poster extends Model
{
    protected $fillable = ['content', 'via', 'image'];

    public static function storeAndNotify($request)
    {
        (new static)->store($request);
        (new static)->notify($request);
    }

    protected function store($request)
    {
        $this->content  = $request->content;
        $this->via      = json_encode($request->via);
        $this->saveImage($request);
        $this->save();
    }

    protected function notify($request)
    {
        auth()->user()->notify(new PosterNotification($request));
    }

    protected function saveImage($request)
    {
        if ($request->hasFile('image')) {
            $path                  = $request->image->store('public');
            $request['image_path'] = $path;
            $this->image           = $path;
        }
    }

    public function getImageAttribute($value)
    {
        return $this->attributes['image'] = url('storage/' . str_replace('public/', '', $value));
    }

    public function getViaAttribute($value)
    {
        return $this->attributes['via'] = json_decode($value);
    }
}
