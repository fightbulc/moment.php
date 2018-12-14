<?php
/**
 * Turkish (tr-TR) language support
 * @author Engin Dumlu <engindumlu@gmail.com>
 * @github https://github.com/roadrunner
 */

return array(
    "months"           => explode('_', 'Ocak_Şubat_Mart_Nisan_Mayıs_Haziran_Temmuz_Ağustos_Eylül_Ekim_Kasım_Aralık'),
    "monthsNominative" => explode('_', 'Ocak_Şubat_Mart_Nisan_Mayıs_Haziran_Temmuz_Ağustos_Eylül_Ekim_Kasım_Aralık'),
    "monthsShort"      => explode('_', 'Oca_Şub_Mar_Nis_May_Haz_Tem_Ağu_Eyl_Eki_Kas_Ara'),
    "weekdays"         => explode('_', 'Pazartesi_Salı_Çarşamba_Perşembe_Cuma_Cumartesi_Pazar'),
    "weekdaysShort"    => explode('_', 'Pts_Sal_Çar_Per_Cum_Cts_Paz'),
    "calendar"         => array(
        "sameDay"  => '[Bugün]',
        "nextDay"  => '[Yarın]',
        "lastDay"  => '[Dün]',
        "lastWeek" => '[Geçen hafta] l',
        "sameElse" => 'l',
        "withTime" => 'H:i',
        "default"  => 'd/m/Y',
    ),
    "relativeTime"  => array(
        "future" => '%s sonra',
        "past"   => '%s önce',
        "s"      => 'birkaç saniye',
        "ss"     => '%d saniye',
        "m"      => 'bir dakika',
        "mm"     => '%d dakika',
        "h"      => 'bir saat',
        "hh"     => '%d saat',
        "d"      => 'bir gün',
        "dd"     => '%d gün',
        "M"      => 'bir ay',
        "MM"     => '%d ay',
        "y"      => 'bir yıl',
        "yy"     => '%d yıl',
    ),
    "ordinal" => function ($number) {
        $n    = $number % 100;
        $ends = array('inci', 'inci', 'üncü', 'üncü', 'inci', 'ıncı', 'inci', 'inci', 'uncu', 'uncu');

        if ($number > 0 && $n == 0) {
            return $number . 'uncu';
        }

        return $number . '[' . $ends[$number % 10] . ']';
    },
    "week"          => array(
        "dow" => 1, // `Pazartesi` is the first day of the week.
        "doy" => 4  // The week that contains Jan 4th is the first week of the year.
    ),
    "customFormats" => array(
        "LT"   => "G:i", // 20:30
        "L"    => "d/m/Y", // 04/09/1986
        "l"    => "j/n/Y", // 4/9/1986
        "LL"   => "jS F Y", // 4 Septembre 1986
        "ll"   => "j M Y", // 4 Sep 1986
        "LLL"  => "jS F Y G:i", // 4 Septembre 1986 20:30
        "lll"  => "j M Y G:i", // 4 Sep 1986 20:30
        "LLLL" => "l, jS F Y G:i", // Jeudi, 4 Septembre 1986 20:30
        "llll" => "D, j M Y G:i", // Jeu, 4 Sep 1986 20:30
    ),
);
