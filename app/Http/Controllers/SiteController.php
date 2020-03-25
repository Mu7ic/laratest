<?php
/**
 * Created by PhpStorm.
 * User: Muzich
 * Date: 25.03.2020
 * Time: 9:30
 */

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteController extends \Illuminate\Routing\Controller
{

    public function index()
    {

        $data = DB::table('urls')->orderBy('created_at', 'desc')->get();

        return view('welcome', ['data' => $data]);
    }


    // Обработчик зопроса

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function post(Request $request)
    {
        if ($request->post()) {
            // генерируем токен
            $token = $this->quickRandom(6);
            // данные с формы
            $url = $request->get('url');
            // сохраняем
            if (!empty(trim($url)))
                $this->saveUrl($token, $url);

            return redirect()->to('/');
        }

    }

    // Рандомный токен

    /**
     * @param $length
     * @return bool|string
     */
    public function quickRandom($length)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    /**
     * @param string $token
     * @param string $urlen
     */
    private function saveUrl(string $token, string $urlen)
    {
        $url = new Url();
        $url->token = $token;
        $url->url = $urlen;
        $url->created_at = date('Y-m-d H:i:s');
        $url->updated_at = date('Y-m-d H:i:s');
        $url->save();
    }

    /**
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function goto($token)
    {
        // находим токен с базы
        $urlFind = DB::table('urls')->where('token', $token)->first();

        //если есть перенапляем
        if (!empty($urlFind))
            return redirect()->to($urlFind->url);

        return redirect()->to('/');
    }
}
