<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\Horoscope;
use Exception;
use Log;

class SpiderService {   
    public function get($i) 
    {
        try {
            $today = date('Y-m-d');
            $client = new Client();
            $res = $client->request('GET', 'https://astro.click108.com.tw/daily_1.php?iAcDay=' . $today . '&iAstro=' . $i . '&iType=4');
        
            $content = $res->getBody();  

            $filterRows = preg_match_all('/<div class="TODAY_CONTENT">([\s\S]+)<\/div>/', $content, $matchs);
            $filteredContent = $matchs[1][0];

            preg_match('/<h3>(.*)<\/h3>/', $filteredContent, $zodiacMatchs);
            preg_match('/<span class="txt_green">(.*)<\/span><\/p><p>([\S]+)<\/p>/', $filteredContent, $entiretyMatchs);
            preg_match('/<span class="txt_pink">(.*)<\/span><\/p><p>([\S]+)<\/p>/', $filteredContent, $loveMatchs);
            preg_match('/<span class="txt_blue">(.*)<\/span><\/p><p>([\S]+)<\/p>/', $filteredContent, $workMatchs);
            preg_match('/<span class="txt_orange">(.*)<\/span><\/p><p>([\S]+)<\/p>/', $filteredContent, $wealthMatchs);

            $zodiac = substr(trim($zodiacMatchs[1]), 6, 9);
            Horoscope::updateOrCreate(
                [
                    'date' => $today,
                    'zodiac' => $zodiac,
                ],
                [
                    'date' => $today,
                    'zodiac' => $zodiac,
                    'entirety_rank' => $this->catchStar($entiretyMatchs[2]),
                    'entirety' => str_replace(["\r, \n, \r\n"], '', trim($entiretyMatchs[2])),
                    'love_rank' => $this->catchStar($loveMatchs[1]),
                    'love' => str_replace(["\r, \n, \r\n"], '', trim($loveMatchs[2])),
                    'work_rank' => $this->catchStar($workMatchs[1]),
                    'work' => str_replace(["\r, \n, \r\n"], '', trim($workMatchs[2])),
                    'wealth_rank' => $this->catchStar($wealthMatchs[1]),
                    'wealth' => str_replace(["\r, \n, \r\n"], '', trim($wealthMatchs[2])),
                ],
            );
        } catch (Exception $e) {
            Log::error(sprintf(
                "file: %s, function: %s, index: %d, message: %s",
                'SpiderService',
                'get',
                $i,
                $e->getMessage()
            ));
        }
    }

    private function catchStar($string)
    {
        $rank = ['☆☆☆☆☆', '★☆☆☆☆', '★★☆☆☆', '★★★☆☆', '★★★★☆', '★★★★★'];
        $stars = substr(trim($string), -18, 15);
        $stars = mb_convert_encoding($stars, 'UTF-8', 'auto');
        $result = array_search($stars, $rank);

        return $result !== false ? $result : 0;
    }  
}