<?php

namespace Laravellive\Poster;

use Illuminate\Database\Eloquent\Model;
use Laravellive\Poster\Notifications\PosterNotification;
use Illuminate\Support\Facades\Storage;

class Poster extends Model
{
    protected $fillable = ['content', 'via', 'image'];

    public static function storeAndNotify($request)
    {
        (new static)->saveImage($request);
        (new static)->notify($request);
        (new static)->store($request);
    }

    protected function store($request)
    {
        $this->content  = $request->content;
        $this->via      = json_encode($request->via);
        $this->image    = $request->image_path;
        $this->save();
    }

    protected function notify($request)
    {
        try {
            auth()->user()->notify(new PosterNotification($request));
        } catch (\Throwable $th) {
            // deleting uploaded image if something wrong happens
            Storage::delete($request->image_path);
            throw $th;
        }
    }

    protected function saveImage($request)
    {
        if ($request->hasFile('image')) {
            $path                  = $request->image->store('public');
            $request['image_path'] = $path;
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
