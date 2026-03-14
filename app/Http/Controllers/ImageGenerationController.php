<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GeneratePromptRequest;
use App\Models\ImageGeneration;
use App\Services\GeminiService;
use Illuminate\Support\Str;

class ImageGenerationController extends Controller
{
    //

    public function __construct(private GeminiService $geminiService)
    {
        //
    }

    public function index() {

    }

    public function store(GeneratePromptRequest $request) {
        $user = $request->user();
        $image = $request->file('image');
        $originalName = $image->getClientOriginalName();
        $sanitizedName = preg_replace('/[^A-Za-z0-9._-]/', '', pathinfo($originalName, PATHINFO_FILENAME));
        $extension = $image->getClientOriginalExtension();  
        $safeFilename = $sanitizedName . '_' . Str::random(5) . $extension;
        $imagePath = $image->storeAs('uploads/images', $safeFilename, 'public');

        $generatedPrompt = $this->geminiService->generatePromptFromImage($image);

        $imageGeneration = ImageGeneration::create([
            'user_id' => $user->id,
            'generated_prompt' => $generatedPrompt,
            'image_path' => $imagePath,
            'original_filename' => $originalName,
            'file_size' => $image->getSize(),
            'mime_type' => $image->getMimeType(),
        ]);

        return response()->json($imageGeneration, 201);

    }
}
