<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Claim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AttachmentController extends Controller
{
    /**
     * Store a newly created attachment
     */
    public function store(Request $request, Claim $claim)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:10240', // 10MB max
            'type' => 'required|in:Image,PDF,Other',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('attachments', $fileName, 'local');

            $attachment = Attachment::create([
                'claim_id' => $claim->id,
                'file_path' => $filePath,
                'type' => $request->type,
            ]);

            return redirect()->back()
                ->with('success', 'Attachment uploaded successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error uploading file: ' . $e->getMessage());
        }
    }

    /**
     * Download an attachment
     */
    public function download(Attachment $attachment)
    {
        if (!Storage::disk('local')->exists($attachment->file_path)) {
            return redirect()->back()
                ->with('error', 'File not found.');
        }

        return Storage::disk('local')->download($attachment->file_path);
    }

    /**
     * Delete an attachment
     */
    public function destroy(Attachment $attachment)
    {
        try {
            // Delete file from storage
            if (Storage::disk('local')->exists($attachment->file_path)) {
                Storage::disk('local')->delete($attachment->file_path);
            }

            // Delete database record
            $attachment->delete();

            return redirect()->back()
                ->with('success', 'Attachment deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting attachment: ' . $e->getMessage());
        }
    }
}
