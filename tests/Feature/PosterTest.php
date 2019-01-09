<?php

namespace Laravellive\Poster\Tests\Feature;

use Laravellive\Poster\Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Laravellive\Poster\Notifications\PosterNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Laravellive\Poster\Poster;

class PosterTest extends TestCase
{
    /** @test */
    public function it_shows_post_page()
    {
        $this->authUser();
        $this->get(route('post.index'))
        ->assertOk()
        ->assertSee('Write something to post');
    }

    /** @test */
    public function it_send_notification()
    {
        $user = $this->authUser();
        Notification::fake();
        $this->post(route('post.send'), [
            'content' => 'This is content',
            'via'     => ['twitter', 'facebook']
        ]);
        Notification::assertSentTo($user, PosterNotification::class);
    }

    /** @test */
    public function poster_must_need_content_and_via_fields()
    {
        $this->authUser();
        $this->withExceptionHandling();
        $res = $this->post(route('post.send'));
        $res->assertSessionHasErrors(['content', 'via']);
    }

    /** @test */
    public function if_there_is_image_then_it_save_image()
    {
        $user = $this->authUser();
        Storage::fake('image');
        Notification::fake();

        $this->post(route('post.send'), [
            'content' => 'This is content',
            'via'     => ['twitter'],
            'image'   => UploadedFile::fake()->image('image.jpg')
        ]);
        $image = Poster::first()->image;
        Storage::assertExists($image);
    }

    /** @test */
    public function it_store_all_data()
    {
        $this->authUser();
        Notification::fake();

        $res = $this->post(route('post.send'), [
            'content' => 'This is content',
            'via'     => ['twitter'],
            'image'   => UploadedFile::fake()->image('image.jpg')
        ]);

        $this->assertDatabaseHas('posters', [
            'content' => 'This is content'
        ]);
    }

    /** @test */
    public function it_can_show_all_the_posts()
    {
        $this->authUser();
        Notification::fake();

        $res = $this->post(route('post.send'), [
            'content' => 'This is content',
            'via'     => ['twitter'],
            'image'   => UploadedFile::fake()->image('image.jpg')
        ]);

        $res = $this->post(route('post.send'), [
            'content' => 'This is content 2',
            'via'     => ['twitter'],
            'image'   => UploadedFile::fake()->image('image.jpg')
        ]);

        $this->get(route('post.show'))->assertSee('This is content 2');
    }
}
