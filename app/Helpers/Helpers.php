<?php
namespace App\Helpers;
use App\Models\Profile;
use App\Models\Renewals;
use App\Models\Settings;
use App\Models\Websites;
use App\Models\SmsBalanceStatus;
use Illuminate\Support\Facades\Auth;

class Helpers
{
    public $userAdmin;
    public $userMember;


    public static function fullTextWildcards($term)
	{
        // removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);

        $words = explode(' ', $term);

        foreach ($words as $key => $word) {
            /*
            * applying + operator (required word) only big words
            * because smaller ones are not indexed by mysql
            */
            if (strlen($word) >= 3) {
                $words[$key] = '*' . $word . '*';
            }
        }

        $searchTerm = implode(' ', $words);

        return $searchTerm;
    }
    public static function fromMoney($string)
    {
        return floatval(str_replace(',', '.', $string));
    }
    public static function mb_ucfirst($string)
    {
        return mb_strtoupper(mb_substr($string, 0, 1)).mb_substr($string, 1);
    }
    public static function GetMember()
    {

        $site_id = Auth::id();

        return $site_id;
    }
    public static function GetAdmin()
    {
        $profile = Profile::where('user_id', '=', Auth::id())->first();
        if ($profile) {
            if ($profile->privilege == 2) {
                $site_id = $profile->member;
            } elseif ($profile->privilege == 1) {
                $site_id = Auth::id();
            }

            return $site_id ?? null;
        }
        return null; 
    }
    public static function GetUserIdSub($account)
    {
        $user = Websites::select('user_id')->where('subdomain', '=', $account)->first();

        if(!$user)
            abort(404);

        return $user->user_id;
    }
    public static function GetSiteId($url)
    {
        $site = Websites::select('users.id')
            ->leftJoin('users', 'users.id', '=', 'websites.user_id')
            ->where('websites.domain', '=', $url)
            ->first();

        // Se nenhum resultado for encontrado, retorna um erro 404
        if (!$site) {
            abort(404, 'Site not found');
        }

        // Retorna o user_id encontrado
        return $site->id;
    }
    public static function GetAdminEmail($url)
    {
        $user = Profile::select('email')->where('id', '=', 1)->first();
        if(!$user)
            abort(404);

        return $user->email;
    }
    public static function GetSiteTemplate($url)
    {
        $user = Profile::select('template')->where('id', '=', 1)->first();
        if(!$user)
            abort(404);

        return $user->template;
    }
    public static function RemoveNotified($user)
    {
        Renewals::where('user', '=', $user)->delete();
    }
    public static function RemoveSmsBalanceStatus($user)
    {
        SmsBalanceStatus::where('user', '=', $user)->delete();
    }
    public static function Colors($color)
    {
        $colors = array(
            1 => array('#F7939D', '#F7809D'),
            2 => array('#000000', '#000000'),
            3 => array('#81E979', '#81BE79'),
            4 => array('#463de1', '#8731E8'),
            5 => array('#4895EF', '#4871EF'),
            6 => array('#56CFE1', '#56B4E1'),
            7 => array('#FFDD00', '#FFB700'),
            8 => array('#A47148', '#A45448'),
            9 => array('#FF9F1C', '#FF7C1C'),
            10 => array('#EF233C', '#EF003C')
        );

        return $colors[$color];
    }
    public static function FormatPrice($type, $price)
    {
        switch($type)
        {
            case 1: $formatted_price = number_format($price, 2, ',', '.'); break;
            case 2: $formatted_price = number_format($price, 2, '.', ','); break;
            default: $formatted_price = number_format($price, 2, ',', '.');
        }

        return $formatted_price;
    }

    public static function system_hosts()
    {
      $system_hosts = [];
      $system_hosts = array_merge($system_hosts, explode(',', env('APPLICATION_HOST')));
      $newArrayMerge = array_merge($system_hosts, explode(',', env('DEVELOPMENT_HOST')));

      return $newArrayMerge;

    }

    public static function verifiyDomainSystem($host){
        if (in_array($host, static::system_hosts())) {
            return true;
          }

          if (!in_array($host, static::system_hosts())) {
            return false;
          }
    }
}
