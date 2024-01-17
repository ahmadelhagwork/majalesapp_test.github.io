<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestLiveStreamController extends Controller
{
    public function TestLiveStreamPage()
    {
        $file = asset('public/agora/voice/audio.mp3');

        $data = ['sound' => $file];

        return view('testlivestream', $data);
    }
    public function TestLiveStreamPage2()
    {
        $file = asset('public/agora/voice/audio.mp3');

        $data = ['sound' => $file];

        return view('testlivestream2', $data);
    }
}
