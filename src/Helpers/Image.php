<?php

namespace CarlosYassuo\Laravel\Helpers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class Image
{
    public static function get($filename = '', $params = ['content_type' => 'content', 'w' => 0, 'h' => 0, 'crop' => false, 'resize' => false, 'format' => 'webp']) {
        try {
            $publicStorage = Storage::disk('public');
            $find = '';

            $params['w'] = (int)$params['w'];
            $params['h'] = (int)$params['h'];

            if(empty($params['format'])) {
                $params['format'] = 'webp';
            }

            if (!$filename || !$publicStorage->exists($params['content_type'].'/'.$filename)) {
                $filename = 'placeholder.png';
            } else {
                $find = '';
            }

            //return 'https://via.placeholder.com/'. $params['w'].'x'. $params['h'] .'.png';

            //return $filename;

            if($params['format'] ?? null) {
                $output_file = sha1($filename . json_encode($params)) . substr($filename, strrpos($filename, '.'));
                foreach(['.jpg', '.png', '.gif', '.jpeg', '.webp'] as $format) {
                    $output_file = str_replace($format, '', $output_file);
                }
                $output_file = $output_file.'.'.$params['format'];
            } else {
                $output_file = sha1($filename.json_encode($params)).substr($filename, strrpos($filename, '.'));
            }

            $output_path = $params['content_type'].'/'.$output_file;

            if($publicStorage->exists(($output_path))) {
                return url(Storage::url($output_path));
            }

            $mime = $publicStorage->mimeType($params['content_type'].'/'.$filename);

            if(Str::contains($mime, 'gif')) {
                $publicStorage->put($output_path, $publicStorage->get($params['content_type'].'/'.$filename));
                return url(Storage::url($output_path));
            } else {
                $img = (new ImageManager())->make($publicStorage->get($params['content_type'].'/'.$filename));

                if($params['resize'] && $params['crop']) {
                    $img->fit($params['w'], $params['h']);
                } else if($params['resize']) {
                    $img->resizeDown($params['w'], $params['h']);
                } else if($params['crop']) {
                    $img->fit($params['w'], $params['h']);
                }

                $img->toWebp(95)->save(storage_path('app/public/'.$output_path));

                return url(Storage::url($output_path));
            }
        } catch(\Exception $ex){
            Log::info($ex->getMessage());
            return '';
        }
    }
}
