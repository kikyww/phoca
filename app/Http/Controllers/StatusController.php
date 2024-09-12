<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StatusController extends Controller
{

  public function index()
  {
    return view("status.index");
  }
  public function store(Request $request)
    {
        Log::info('Received request data:', $request->all());

        $request->validate([
            'content' => 'required|string',
            'visibility' => 'sometimes|boolean',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::beginTransaction();

        try {
            $status = new Status();
            $status->user_id = auth()->id();
            $status->content = $request->content;
            $status->visibility = $request->has('visibility') ? 'secret' : 'public';
            $status->save();

            Log::info('Status saved:', ['status_id' => $status->id]);

            if ($request->hasFile('images')) {
                Log::info('Images found in request');
                foreach ($request->file('images') as $index => $image) {
                    $filename = time() . '_' . $image->getClientOriginalName();
                    $path = $image->storeAs('public/status_photos', $filename);

                    Log::info('Image stored:', ['path' => $path]);

                    $photo = new Photo();
                    $photo->status_id = $status->id;
                    $photo->photo_url = Storage::url($path);
                    $photo->photo_path = $path;
                    $photo->filename = $filename;
                    $photo->mime_type = $image->getClientMimeType();
                    $photo->size = $image->getSize();
                    $photo->order = $index;
                    $photo->save();

                    Log::info('Photo saved to database:', ['photo_id' => $photo->id]);
                }
            } else {
                Log::warning('No images found in request');
            }

            DB::commit();
            Log::info('Transaction committed successfully');
            return redirect()->route('status.index')->with('success', 'Status created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error occurred:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->with('error', 'An error occurred while creating the status. Please try again.');
        }
    }
}
