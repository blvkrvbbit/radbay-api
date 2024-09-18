<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\Image;

class AdController extends Controller
{
    //
    /**
     * Summary of create
     * @param \Illuminate\Http\Request $request
     * @return string[]|\Throwable
     */
    public function create(Request $request)
    {
        try {
            $ad = Ad::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'user_id' => $request->user()->id,
                'category_id' => $request->input('category_id')
            ]);
            if ($request->input('paths')) {
                $paths = $request->input('paths');
                foreach ($paths as $path) {
                    Image::create([
                        'ad_id' => $ad->id,
                        'url' => $path,
                        'hero' => false
                    ]);
                }

            }
            return [
                'message' => 'Successfully created ad',
            ];
        } catch (\Throwable $th) {
            return $th;
        }
    }
    /**
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @return string[]|\Throwable
     */
    public function update(Request $request, $id)
    {
        try {
            $ad = Ad::where('id', $id)->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'user_id' => $request->user()->id,
                'category_id' => $request->input('category_id')
            ]);
            return [
                'message' => 'Successfully updated ad',
            ];
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete(Request $request, $id)
    {
        Ad::destroy($id);
        return $id;
    }

    /**
     * Summary of getAll
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection<int, Ad>[]
     */
    public function getAll(Request $request)
    {
        $ads = Ad::with(['images', 'user'])->get();
        return [
            'ads' => $ads
        ];
    }

    /**
     * Summary of getOneById
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return \Illuminate\Database\Eloquent\Collection<int, Ad>[]
     */
    public function getOneById(Request $request, $id)
    {
        $ad = Ad::with(['images', 'user', 'category'])->where('id', $id)->get();
        return [
            'ad' => $ad
        ];
    }

    /**
     * 
     * Summary of getAllByUserId
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection<int, Ad>[]
     */
    public function getAllByUserId(Request $request)
    {
        $id = auth()->user()->id;
        $ads = Ad::with(['images'])->where('user_id', $id)->get();
        return [
            'ads' => $ads
        ];
    }
}
