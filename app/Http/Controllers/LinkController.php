<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLinkRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateLinkRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 0);

        if ($limit == 0) {
            $links = Link::where('user_id', auth()->user()->id)->get();
        } else {
            $links = Link::where('user_id', auth()->user()->id)->paginate($limit);
        }

        return response()->json([
            'message' => 'Success',
            'data' => $links,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLinkRequest $request)
    {
        $name = 'http://api.qrserver.com/v1/create-qr-code/?data=kevin-andreas.com/s/' . $request->slug . '&size=500x500';

        $request['qr_code'] = $name;

        Link::create([
            'user_id' => auth()->user()->id,
            'slug' => $request->slug,
            'destination' => $request->destination,
            'expires_at' => $request->expires_at,
            'qr_code' => $request->qr_code,
        ]);

        return response()->json([
            'message' => 'Link created successfully',
            'data' => $request->all(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        $link = Link::find($link->id);

        return response()->json([
            'message' => 'Success',
            'data' => $link,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLinkRequest $request, Link $link)
    {
        $link = Link::find($link->id);

        if ($request->slug) {
            $name = 'http://api.qrserver.com/v1/create-qr-code/?data=kevin-andreas.com/s/' . $request->slug . '&size=500x500';

            $request['qr_code'] = $name;
        }

        $link->update($request->all());

        return response()->json([
            'message' => 'Link updated successfully',
            'data' => $link,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        $link = Link::find($link->id);

        $link->delete();

        return response()->json([
            'message' => 'Link deleted successfully',
        ]);
    }

    /**
     * Find a link by its slug.
     */
    public function findBySlug($slug)
    {
        $link = Link::where('slug', $slug)->first();

        if (!$link) {
            return response()->json([
                'message' => 'Link not found',
            ], 404);
        }

        Link::where('slug', $slug)->update([
            'visits' => $link->visits + 1,
        ]);

        return response()->json([
            'message' => 'Success',
            'data' => [
                'slug' => $link->slug,
                'destination' => $link->destination,
                'expires_at' => $link->expires_at,
            ],
        ]);
    }
}
