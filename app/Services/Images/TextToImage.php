<?php

namespace App\Services\Images;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TextToImage
{

    /**
     * Создание картинки из текста
     * @param string $text
     * @return string
     */
    public function make(string $text): string
    {
        $font_size = 32;
        $font_file = public_path('fonts/GTWalsheimProMedium.ttf');

        $image = new \Imagick();
        $draw = new \ImagickDraw();
        $pixel = new \ImagickPixel( 'rgb(1, 1, 1)' );
        /* New image */

        /* Black text */
        $draw->setFillColor('rgb(255, 255, 255)');

        /* Font properties */
        $draw->setFont($font_file);
        $draw->setFontSize( $font_size );
        $imageInfo = $image->queryFontMetrics($draw, $text);
        $image_width = $imageInfo['textWidth'] + 10;
        $image_height = $imageInfo['textHeight'] + 10;

        $image->newImage($image_width, $image_height, $pixel);
        $x = 5; // Padding of 5 pixels.
        $y = $font_size + 5; // So that the text is vertically centered.
        /* Create text */
        $image->annotateImage($draw, $x, $y, 0,
            $text);

        /* Give image a format */
        $image->setImageFormat('png');

        $filepath = 'phones/' . Str::random() . '.png';

        // выгружаем в облако
        Storage::disk('spaces')->put($filepath, $image, [
            'visibility' => 'public',
            'mimetype' => 'image/png'
        ]);

        return $filepath;
    }
}
