<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Gemini\Data\Blob;
use Gemini\Enums\MimeType;
use Gemini\Laravel\Facades\Gemini;

class GeminiService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function generatePromptFromImage(UploadedFile $image): array
    {
        $mimeTypeString = $image->getMimeType();

        $mimeTypeEnum = MimeType::tryFrom($mimeTypeString);

        if (! $mimeTypeEnum) {
            throw new \InvalidArgumentException("Unsupported image type: {$mimeTypeString}");
        }

        /*
        // Dynamically match the string to the Enum case
        $mimeTypeEnum = match ($mimeTypeString) {
        'image/png'               => MimeType::IMAGE_PNG,
        'image/jpeg', 'image/jpg' => MimeType::IMAGE_JPEG,
        'image/heic'              => MimeType::IMAGE_HEIC,
        'image/heif'              => MimeType::IMAGE_HEIF,
        'image/webp'              => MimeType::IMAGE_WEBP,
        default => throw new \InvalidArgumentException("Unsupported image type: {$mimeTypeString}"),
        };
        */

        $result = Gemini::generativeModel(model: 'gemini-2.5-flash')
        ->generateContent([
        'Analyze this image and generate a detailed, descriptive, and comprehensive *STRICTLY JSON prompt* FORMAT that could be used 
        to replicate the image with AI image generation tools. The prompt should be 
        comprehensive, describing the visual elements, style, composition, lighting, colors, 
        and any other relevant details. Make it detailed enough that AI models could use it to 
        generate a similar image',

        new Blob(
            mimeType: $mimeTypeEnum,
            data: base64_encode(
                file_get_contents($image->getPathname())
            )
        )
        ]);

        $raw = trim($result->text());

        $clean = preg_replace('/^```(?:json)?\s*|\s*```$/i', '', $raw);
        $clean = trim((string) $clean);

        $decoded = json_decode($clean, true, 512, JSON_THROW_ON_ERROR);

        return is_array($decoded) ? $decoded : ['prompt' => $decoded];
    }
}
        