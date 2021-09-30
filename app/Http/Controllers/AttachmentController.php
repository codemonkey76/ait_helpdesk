<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required',
            'attachment-path' => 'required'
        ]);

        $file = $request->file('file');
        $url = '/' . Storage::disk('s3')->putFile($request->get('attachment-path'), $file);

        info($url);
        return response()->json(['path' => $url]);
    }

    public function show(Request $request, $year, $month, $day, $attachment)
    {
        $path = 'attachments/' . $year . '/' . $month . '/' . $day . '/' . $attachment;

        return Storage::disk('s3')->download($path);
    }
}
