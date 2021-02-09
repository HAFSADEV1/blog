<?php

namespace Tests\Feature;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
   
    use RefreshDatabase;

    public function testSavePost()
    {
        $post=new Post();
        $post->id=45;
        $post->name="new post to test";
        $post->save();
        $this->assertDatabaseHas('posts',[
            'name'=>'new post to test'
        ]);
    }
    ////////     Test Store Method     /////////
     public function testPostStoreValide(){
        $data=[
            'id'=>457,
            'name'=>'test valid'
        ];
        $this->post("/posts",$data)->assertStatus(302)->assertSessionHas('status');
        $this->assertEquals(session('status'),'post created successfully');
    }
     ////////     Test Update Method     /////////
    public function testPostUpdate(){
        $post=new Post();
        $post->id=450;
        $post->name="new post to test";
        $post->save();
        $this->assertDatabaseHas('posts',$post->toArray());
        $data=[
            'id'=>450,
            'name'=>'test updated successfully'
        ];
       $this->put("/posts/{$post->id}",$data)->assertStatus(302)->assertSessionHas('status');
       $this->assertDatabaseHas('posts',[
           'name'=>$data['name']
       ]);
    }
       ////////     Test Update Method     /////////
       public function testDeletePost(){
        $post=new Post();
        $post->id=407;
        $post->name="new post to test";
        $post->save();
        $this->assertDatabaseHas('posts',$post->toArray());
        $this->delete("/posts/{$post->id}")->assertStatus(302)->assertSessionHas('status');
        $this->assertEquals(session('status'),'post was Deleted');
        $this->assertDatabaseMissing('posts',$post->toArray());
       }
}
