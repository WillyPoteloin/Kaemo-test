<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoTest extends TestCase
{

    /**
     * Testing videos store method.
     *
     * @return void
     */
    public function testStoreVideo()
    {
        $response = $this->call('POST', '/api/videos', ['title' => 'The wire', 'realisator' => 'David Simon']);
        $this->assertResponseStatus(200);
        $data = json_decode($response->content(), true);

        $this->assertArrayHasKey('video', $data);

        $video = $data['video'];

        $this->assertArrayHasKey('id', $video);
        $this->assertArrayHasKey('title', $video);
        $this->assertArrayHasKey('date', $video);
        $this->assertArrayHasKey('realisator', $video);
        $this->assertEquals('The wire', $video['title']);
        $this->assertEquals('David Simon', $video['realisator']);
    }

    /**
     * Testing videos index method.
     *
     * @return void
     */
    public function testIndexVideos()
    {
        $response = $this->call('GET', '/api/videos');

        $this->assertResponseStatus(200);
        $data = json_decode($response->content(), true);

        $this->assertArrayHasKey('count', $data);
        $this->assertArrayHasKey('videos', $data);
    }

    /**
     * Testing videos index method with parameters.
     *
     * @return void
     */
    public function testIndexVideosWithParameters()
    {
        $response = $this->call('GET', '/api/videos?from=20150101&to=20151231');

        $this->assertResponseStatus(200);
        $data = json_decode($response->content(), true);

        $this->assertArrayHasKey('count', $data);
        $this->assertArrayHasKey('videos', $data);

        if(is_array($data['videos'])) {
          foreach ($data['videos'] as $key => $video) {
            $this->assertGreaterThanOrEqual(strtotime('2015-01-01'), strtotime($video['date']));
            $this->assertLessThanOrEqual(strtotime('2015-12-31'), strtotime($video['date']));
          }
        }
    }

    /**
     * Testing videos show method.
     *
     * @return void
     */
    public function testShowVideo()
    {
        $response = $this->call('GET', '/api/videos/1');

        $this->assertResponseStatus(200);
        $data = json_decode($response->content(), true);

        $this->assertArrayHasKey('video', $data);
        $video = $data['video'];

        $this->assertArrayHasKey('id', $video);
        $this->assertArrayHasKey('title', $video);
        $this->assertArrayHasKey('date', $video);
        $this->assertArrayHasKey('realisator', $video);
        $this->assertEquals(1, $video['id']);
    }

    /**
     * Testing video destroy method.
     *
     * @return void
     */
    public function testDestroyVideo()
    {
        $response = $this->call('DELETE', '/api/videos/1');

        $this->assertResponseStatus(200);
        $data = json_decode($response->content(), true);

        $this->assertEquals(true, $data);
    }
}
