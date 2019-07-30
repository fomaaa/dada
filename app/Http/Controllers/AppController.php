<?php

namespace App\Http\Controllers;

use App\Models\Blocks;
use App\Models\Cases;
use App\Models\MetaData;
use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;


class AppController extends Controller
{


    public function generate(Request $request)
    {
        $files = scandir(base_path() .'/storage/app/public/blocks/images/thumbs');

        foreach($files as $key => $item) {
            print_r($item);
        }

        exit();
    }
    //
    //      Главная
    //
    public function index(Request $request)
    {
        // \Tinify\setKey("h9bvWWFbLFoNT3b8Y8DIVxaIM6egcdYl");
        // $full_path = base_path() .'/storage/app/public/blocks/images';
        // $files = scandir($full_path);

        // foreach($files as $key => $file) {
        //     if ($file == '.' || $file == '..' || $file == 'thumbs') continue;

        //     // echo '<pre>';
        //     // print_r($file);
        //     // echo '</pre>';

        //     $source = \Tinify\fromFile($full_path . '/' . $file);
        //     $resized = $source->resize(array(
        //         "method" => "fit",
        //         "width" => 150,
        //         "height" => 150
        //     ));
        //     $source->toFile($full_path . '/' . $file);
        //     $resized->toFile($full_path . '/thumbs/' . $file);


        //     if ($key == 5) break;
        // }

        // exit();

        
        $meta = MetaData::orderBy('created_at', 'desc')->where('page', 0)->first();
        $lang = $request->lang;
        if (isset($meta)) {
            if ($lang == 'en') {
                $meta->title = $meta->title_en;
                $meta->description = $meta->description_en;
            } else {
                $meta->title = $meta->title_ru;
                $meta->description = $meta->description_ru;
            }
            $meta->og_image = '/' . $lang . $meta->image;
            $meta->og_url = url()->current();
            $meta = $meta->only(['title', 'description', 'og_image', 'og_url']);

        } else {
            $meta = new MetaData;
            $meta->title = 'DADA Агенство';
            $meta->description = 'We do it differently, to make it better. If you want to get an outstanding result, you’ve chosen the right agency.';
            $meta->og_image = '/static/img/dadaagency.png';
            $meta->og_url = url()->current();
        }
        return view('welcome', ['lang' => $request->lang, 'meta' => $meta]);
    }

    //
    //      Агенство
    //
    public function agency(Request $request)
    {
        $lang = $request->lang;
        $meta = MetaData::orderBy('created_at', 'desc')->where('page', 2)->first();
        if (isset($meta)) {
            if ($lang == 'en') {
                $meta->title = $meta->title_ru;
                $meta->description = $meta->description_ru;

            } else {
                $meta->title = $meta->title_en;
                $meta->description = $meta->description_en;
            }
            $meta->og_image = '/' . $lang . $meta->image;
            $meta->og_url = url()->current();
            $meta = $meta->only(['title', 'description', 'og_image', 'og_url']);
        } else {
            $meta = new MetaData;
            $meta->title = 'DADA Агенство';
            $meta->description = 'We do it differently, to make it better. If you want to get an outstanding result, you’ve chosen the right agency.';
            $meta->og_image = '/static/img/dadaagency.png';
            $meta->og_url = url()->current();
        }
        return view('welcome', ['lang' => $lang, 'meta' => $meta]);

    }
    //
    //      Кейс
    //
    public function cases(Request $request)
    {
        $lang = $request->lang;
        $case = str_replace('/' . $lang . '/', '', $request->getRequestUri());
        $meta = Cases::orderBy('created_at', 'desc')->where('url', $case)->first(['id', 'campaign_'.$lang, 'title_'.$lang]);
        if (isset($meta)) {
            $meta->og_url = url()->current();
            $preview = Blocks::where('case_id', $meta->id)
                ->where('type', 0)
                ->first(['content']);
            $letterHead = Blocks::where('case_id', $meta->id)
                ->where('type', 1)
                ->first(['content']);

            $mainText = Blocks::where('case_id', $meta->id)
                ->where('type', 1)
                ->withText($lang)
                ->first(['content']);
            if (!isset($mainText)) {
                // Собираем content для metatags
                $mainText = Blocks::where('case_id', $meta->id)
                    ->where('sort', '!=', null)
                    ->orderBy('sort', 'asc')
                    ->whereIn('type', array(2, 3))
                    ->withText($lang)
                    ->first(['content']);
                if (!isset($mainText)) {
                    $mainText = Blocks::where('case_id', $meta->id)
                        ->where('sort', null)
                        ->orderBy('id', 'asc')
                        ->whereIn('type', array(2, 3))
                        ->withText($lang)
                        ->first(['content']);
                    if (!isset($mainText)) {
                        $mainText = null;
                    }
                }
            }
            // Если нашёл блок с текстом
            if (isset($mainText)) {

                if ($lang == 'en') {
                    $meta->description = $mainText->removeTags($mainText->content, 'en');
                } else {
                    $meta->description = $mainText->removeTags($mainText->content, 'ru');
                }
            } // Если не нашел блок с текстом
            else {
                $meta->description = '';
            }

            if($lang == 'en') {
                $meta->title = $meta->title_en;
                $meta->campaign = $meta->campaign_en;
            } else {
                $meta->title = $meta->title_ru;
                $meta->campaign = $meta->campaign_ru;
            }
            if (isset($preview)) {
                $preview_image = $preview->content['image'];
                $meta->og_image = '/' . $lang . '/storage/app/public' . $preview_image;
            } else {
                $meta->og_image = '';
            }

        } else {
            return redirect()->action('AppController@index', ['lang' => $lang]);
        }
        // dd($meta);
        $meta = $meta->only(['title', 'description', 'og_image', 'og_url', 'campaign', 'title', 'content']);
        return view('welcome', ['lang' => $lang, 'meta' => $meta]);
    }

    //
    //      Работы
    //
    public function works(Request $request)
    {
        $lang = $request->lang;
        $meta = MetaData::orderBy('created_at', 'desc')->where('page', 1)->first();
        if (isset($meta)) {
            if ($lang == 'en') {
                $meta->title = $meta->title_ru;
                $meta->description = $meta->description_ru;

            } else {
                $meta->title = $meta->title_en;
                $meta->description = $meta->description_en;
            }
            $meta->og_image = '/' . $lang . $meta->image;
            $meta->og_url = url()->current();
            $meta = $meta->only(['title', 'description', 'og_image', 'og_url']);
        } else {
            $meta = new MetaData;
            $meta->title = 'DADA Агенство';
            $meta->description = 'We do it differently, to make it better. If you want to get an outstanding result, you’ve chosen the right agency.';
            $meta->og_image = '/static/img/dadaagency.png';
            $meta->og_url = url()->current();
        }
        return view('welcome', ['lang' => $lang, 'meta' => $meta]);
    }


    // Возвращает пустые карточки от count до threshold для team
    public function generateFakeCards($count, $threshold)
    {
        $arr = array();
        while ($count != $threshold) {
            $emptyCard = null;
            array_push($arr, $emptyCard);
            $count++;
        }
        return $arr;
    }

    //
    //      Команда API
    //
    public function team($lang)
    {
        $people = People::where('sort', '!=', null)
            ->orderBy('sort', 'asc')
            ->get(['id', 'position', 'photo_white', 'photo_black', 'sort', 'name_' . $lang]);
        $people_null = People::where('sort', null)
            ->orderBy('created_at', 'asc')
            ->get(['id', 'position', 'photo_white', 'photo_black', 'sort', 'name_' . $lang]);
        $people = $people->merge($people_null);
        foreach ($people as $key => $item) {
            // Отправляем property title вне зависимости от языка
            if ($lang == 'ru') {
                $item->name = $item->name_ru;

            } else if ($lang == 'en') {
                $item->name = $item->name_ru;
            }
        }
        $people = $people->map(function ($person) {
            return collect($person->toArray())
                ->only(['id', 'name', 'photo_black', 'photo_white', 'position', 'sort', 'created_at']);
        });

        $peeps = $people->toArray();
        $count = $people->count() % 34;
        // Заполняем пустыми карточками до конца строки (если нужно)
        if (($count != 7) && ($count != 14) && ($count != 24) && ($count != 34)) {
            switch ($count) {
                case $count < 7:
                    $peeps = array_merge($peeps, AppController::generateFakeCards($count, 7));
                    break;
                case $count < 14:
                    $peeps = array_merge($peeps, AppController::generateFakeCards($count, 14));
                    break;
                case $count < 24:
                    $peeps = array_merge($peeps, AppController::generateFakeCards($count, 24));
                    break;
                case $count < 34:
                    $peeps = array_merge($peeps, AppController::generateFakeCards($count, 34));
                    break;
            }
        }
        $grid =
            [
                0 => 'big', 1 => 'small', 2 => 'small', 3 => 'small', 4 => 'small',
                5 => 'big', 6 => 'big',

                7 => 'big', 8 => 'big', 9 => 'small', 10 => 'small', 11 => 'small',
                12 => 'small', 13 => 'big',

                14 => 'big', 15 => 'small', 16 => 'small', 17 => 'small', 18 => 'small',
                19 => 'big', 20 => 'small', 21 => 'small', 22 => 'small', 23 => 'small',

                24 => 'small', 25 => 'small', 26 => 'small', 27 => 'small', 28 => 'big',
                29 => 'small', 30 => 'small', 31 => 'small', 32 => 'small', 33 => 'big',
            ];
        // Собираем коллекцию для сетки
        $arr = array();
        $person_i = 0;
        $tree_i = 0;
        $children_i = 0;
        foreach ($peeps as $person) {
            $grid_index = $person_i % 34;
            switch ($grid[$grid_index]) {
                case 'small':
                    $arr[$tree_i][$children_i] = $person;
                    $children_i++;
                    if ($children_i >= 4) {
                        $tree_i++;
                        $children_i = 0;
                    }
                    $person_i++;
                    break;
                case 'big':
                    $arr[$tree_i] = $person;
                    $person_i++;
                    $tree_i++;
                    break;
            }

        }
        $collection = collect($arr);
        return response()->json($collection);
    }

    //
    //      Работы API (возвращаем 4 самые свежих кейса)
    //

    public function latestWorksWithTag($lang, $tag, $date = null)
    {
        // Тег в нижний кейс
        $tag = mb_strtolower($tag, 'UTF-8');

        if ($tag == 'null' || $tag == 'all') {
            return AppController::latestWorks($lang, $date);
        } else {
            $blocks = Blocks::where('type', 1)->where('content', 'like', '%"tag":"%' . $tag . '%')
                ->join('cases', 'cases.Id', '=', 'blocks.case_id')
                ->get(['case_id']);
        }
        $casesIds = $blocks->pluck('case_id');
        if ($date) {
            $cases = Cases::whereIn('id', $casesIds)
                ->sort()
                ->where('created_at', '<', $date)
                ->paginate(4);

        } else {
            $cases = Cases::whereIn('id', $casesIds)
                ->sort()
                ->paginate(4);
        }
        foreach ($cases as $key => $item) {
            // Отправляем property title вне зависимости от языка
            if ($lang == 'ru') {
                $item->title = $item->title_ru;
                $item->campaign = $item->campaign_ru;

            } else if ($lang == 'en') {
                $item->title = $item->title_en;
                $item->campaign = $item->campaign_en;
            }

            if (is_object($item->blocks)) {
                foreach ($item->blocks as $block) {
                    if ($block->type == 0) {
                        $content = $block->content;
                        if (isset($content['cursor_color'])) {
                            $item->cursor_color = $content['cursor_color'];
                        }
                        $item->preview_type = 0;
                        $item->video_preview_type = 0;
                        if (isset($content['preview_type'])) {
                            $item->preview_type = $content['preview_type'];
                            switch($content['preview_type']) {
                                case 0 : {
                                    $item->cases_preview = $content['image_preview'];
                                    break;
                                }
                                case 1 : {
                                    $item->video_preview_type = $content['video_preview_type'];
                                    if (!$item->video_preview_type) {
                                        $item->cases_preview = $content['video_preview'];
                                    } else {
                                        $item->cases_preview = $content['link_preview'];
                                    }
                                    break;
                                } 
                                case 2 : {
                                    $item->cases_preview = $block->preview;
                                    break;
                                }
                            }
                        }
                    }
                } 

            }
        }
        $cases = $cases->map(function ($case) {
            return collect($case->toArray())
                ->only(['created_at', 'id', 'sort', 'url',  'cases_preview','title', 'tags', 'campaign', 'cursor_color', 'preview_type', 'video_preview_type']);
        });
        return response()->json($cases);
    }

    public function latestWorks($lang, $date = null)
    {
        if ($date) {
            $cases = Cases::sort()
                ->where('created_at', '<', $date)
                ->paginate(4);
        } else {
            $cases = Cases::sort()
                ->paginate(4);

        }


        foreach ($cases as $key => $item) {
            // Отправляем property title вне зависимости от языка
            if ($lang == 'ru') {
                $item->title = $item->title_ru;
                $item->campaign = $item->campaign_ru;

            } else if ($lang == 'en') {
                $item->title = $item->title_en;
                $item->campaign = $item->campaign_en;
            }

            if (is_object($item->blocks)) {
                foreach ($item->blocks as $block) {
                    if ($block->type == 0) {
                        $content = $block->content;
                        if (isset($content['cursor_color'])) {
                            $item->cursor_color = $content['cursor_color'];
                        }
                        $item->preview_type = 0;
                        $item->video_preview_type = 0;
                        if (isset($content['preview_type'])) {
                            $item->preview_type = $content['preview_type'];
                            switch($content['preview_type']) {
                                case 0 : {
                                    $item->cases_preview = $content['image_preview'];
                                    break;
                                }
                                case 1 : {
                                    $item->video_preview_type = $content['video_preview_type'];
                                    if (!$item->video_preview_type) {
                                        $item->cases_preview = $content['video_preview'];
                                    } else {
                                        $item->cases_preview = $content['link_preview'];
                                    }
                                    break;
                                } 
                                case 2 : {
                                    $item->cases_preview = $block->preview;
                                    break;
                                }
                            }
                        }
                    }
                } 

            }
        }

        $cases = $cases->map(function ($case) {
            return collect($case->toArray())
                ->only(['created_at', 'id', 'sort', 'url',  'cases_preview','title', 'tags', 'campaign', 'cursor_color', 'preview_type', 'video_preview_type']);
        });
        return response()->json($cases);
    }

    //
    //      Кейс API
    //
    public function caseContent($lang, $case, $tag = null)
    {
        // Только ru или en доходят до контроллера, hopefully
        // but still
        if (($lang != 'ru') && ($lang != 'en')) {
            $lang = 'ru';
        }
        $cases = Cases::where('url', $case)
            ->first(['title_' . $lang, 'id', 'created_at', 'campaign_' . $lang, 'sort']);
        if (!isset($cases)) {
            return view('404');
        }

        $cases_to_send = Cases::where('url', $case)->first(['id', 'url']);

        // NEXT
        $next_case = Cases::sort()
            ->get(['id', 'title_' . $lang, 'campaign_' . $lang, 'url']);
        $caseId = $next_case->where('url', $cases_to_send->url)->keys()->first();
        if (isset($next_case[$caseId + 1])) {
            $next_case = $next_case[$caseId + 1];
        } else {
            $next_case = $next_case[0];
        }
        $cases_to_send->urlNext = $next_case->url;
        $cases_to_send->titleNext = ($lang == 'en') ? $next_case->title_en : $next_case->title_ru;
        $cases_to_send->campaignNext = ($lang == 'en') ? $next_case->campaign_en : $next_case->campaign_ru;

        // PREV
        $prev_case = Cases::sort()
            ->get(['id', 'title_' . $lang, 'campaign_' . $lang, 'url']);

        // Первый кейс, возвращаем последний
        if (isset($prev_case[$caseId - 1])) {
            $prev_case = $prev_case[$caseId - 1];
        } else {
            $prev_case = $prev_case->last();
        }
        $cases_to_send->urlPrev = $prev_case->url;
        $cases_to_send->titlePrev = ($lang == 'en') ? $prev_case->title_en : $prev_case->title_ru;
        $cases_to_send->campaignPrev = ($lang == 'en') ? $prev_case->campaign_en : $prev_case->campaign_ru;

        if ($lang == 'en') {
            $cases_to_send->title = $cases->title_en;
            $cases_to_send->campaign = $cases->campaign_en;
        } else {
            $cases_to_send->title = $cases->title_ru;
            $cases_to_send->campaign = $cases->campaign_ru;
        }

        $blocksAll = Blocks::where('case_id', $cases->id)
            ->where('type', '!=', 0)
            ->get(['id', 'type', 'sort']);
        $blocksContent = Blocks::where('case_id', $cases->id)
            ->where('type', '!=', 0)
            ->get(['content']);

        $headBlock = Blocks::where('case_id', $cases->id)
            ->where('type', '=', 0)
            ->get(['content']);

        if (!empty($headBlock['0'])) {
            $headBlock = $headBlock[0]->content;
            unset($headBlock['text_en']);
            unset($headBlock['text_ru']);
            unset($headBlock['text2_en']);
            unset($headBlock['text2_ru']);
            unset($headBlock['indent']);
            unset($headBlock['wide']);
            unset($headBlock['description_ru']);
            unset($headBlock['description_en']);            
            unset($headBlock['description2_ru']);
            unset($headBlock['description2_en']);
            unset($headBlock['site_url']);
            unset($headBlock['tags']);
            unset($headBlock['gallery']);
            unset($headBlock['image']);
            unset($headBlock['image2']);
        }
        // print_r($headBlock);

        foreach ($blocksContent as $key => $item) {
            Blocks::fillContentData($blocksAll[$key], $item, $lang);
        }

        $blocksAll = Blocks::sortBlocks($blocksAll);
        $cases_to_send = $cases_to_send->only(['id', 'url', 'preview', 'title', 'tags', 'urlNext', 'urlPrev', 'titleNext', 'titlePrev', 'campaignNext', 'campaignPrev', 'campaign']);
        return response()->json(['blocks' => $blocksAll, 'cases' => $cases_to_send, 'headBlock' => $headBlock]);
    }


}