<?php

namespace App\Http\Controllers;

use App\Video;

use Illuminate\Http\Request;

use App\Http\Requests;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $videos = Video::where(array());

        // Checking request parameters
        if ($request->has('from')) {
          $videos->where('date', '>=', $request->from);
        }
        if ($request->has('to')) {
          $videos->where('date', '<=', $request->to);
        }
        if ($request->has('realisator')) {
          $videos->where('realisator', 'like', '%'.$request->realisator.'%');
        }

        $videos = $videos->get();

        return response()->json(['videos' => $videos->all(), 'count' => $videos->count()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // Default return value
      $new_video = null;

      // Checking request parameters
      if($request->has('title') && $request->has('realisator') && !empty($request->title) && !empty($request->realisator)) {

        // Defining video attributes
        $video = array();

        $video['title'] = $request->title;
        $video['date'] = date('Y-m-d H:i:s');
        $video['realisator'] = $request->realisator;

        // Create new video
        $new_video = Video::create($video);
      }

      return response()->json(['video' => $new_video]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $video = Video::find($id);
        return response()->json(['video' => $video]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $return = false;
        $video = Video::find($id);

        if(!is_null($video)) {
          $video->delete();
          $return = true;
        }

        return response()->json($return);
    }
}
