<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $files = File::all();
        return view('files.index', compact('files'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $fileName = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileStore = $fileName . '.' . $extension;

        $file->storeAs('uploads', $fileStore);

        // dd($fileName,$file,$extension,$originalName);
        File::create([
            'file_name' => $fileStore,
            'original_name' => $originalName,
        ]);

        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    public function download($id)
    {
        $file = File::findOrFail($id);
        $filePath = storage_path('app/uploads/' . $file->file_name);

        return response()->download($filePath);
    }

    public function delete($id)
    {
        $file = File::findOrFail($id);
        $filePath = storage_path('app/uploads/' . $file->file_name);

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $file->delete();

        return redirect()->back()->with('success', 'File deleted successfully.');
    }
}
