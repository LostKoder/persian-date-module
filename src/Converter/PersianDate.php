<?php

/*
 * This file is part of the Persian Date (Object Oriented API) package.
 *
 * (c) Amin Alizade <motammem@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Drupal\persian_date\Converter;

/**
 * This class hold time and represents it in Persian Date format.
 *
 * @package Drupal\persian_date\Convertor
 */
class PersianDate extends \DateTime
{
    /**
     * Builds original PHP DateTime class.
     *
     * @return \DateTime
     */
    public function getOriginalDateTime()
    {
        $object = new parent();
        $object->setTimestamp($this->getTimestamp());
        $object->setTimezone($this->getTimezone());
        return $object;
    }

    /**
     * @inheritDoc
     */
    public function format($format)
    {
        $T_sec = 0;/* <= ??? ???? ???? ???? ? ?? ????? '+' ? '-' ?? ??? ????? */

        if ($this->getTimezone()->getName() != 'local') date_default_timezone_set(($this->getTimezone()->getName() == '') ? 'Asia/Tehran' : $this->getTimezone()->getName());
        $ts = $T_sec + (($this->getTimestamp() == '' or $this->getTimestamp() == 'now') ? time() : $this->getTimestamp());
        $date = explode('_', date('H_i_j_n_O_P_s_w_Y', $ts));
        list($j_y, $j_m, $j_d) = PersianDateConverter::gregorian_to_jalali($date[8], $date[3], $date[2]);
        $doy = ($j_m < 7) ? (($j_m - 1) * 31) + $j_d - 1 : (($j_m - 7) * 30) + $j_d + 185;
        $kab = ($j_y % 33 % 4 - 1 == (int)($j_y % 33 * .05)) ? 1 : 0;
        $sl = strlen($format);
        $out = '';
        for ($i = 0; $i < $sl; $i++) {
            $sub = substr($format, $i, 1);
            if ($sub == '\\') {
                $out .= substr($format, ++$i, 1);
                continue;
            }
            switch ($sub) {
                case'E':case'R':case'x':case'X':
                $out.='http://jdf.scr.ir';
                break;

                case'B':case'e':case'g':
                case'G':case'h':case'I':
                case'T':case'u':case'Z':
                $out.=date($sub,$ts);
                break;

                case'a':
                    $out.=($date[0]<12)?'ق.ظ':'ب.ظ';
                    break;

                case'A':
                    $out.=($date[0]<12)?'قبل از ظهر':'بعد از ظهر';
                    break;

                case'b':
                    $out.=(int)($j_m/3.1)+1;
                    break;

                case'c':
                    $out.=$j_y.'/'.$j_m.'/'.$j_d.' ،'.$date[0].':'.$date[1].':'.$date[6].' '.$date[5];
                    break;

                case'C':
                    $out.=(int)(($j_y+99)/100);
                    break;

                case'd':
                    $out.=($j_d<10)?'0'.$j_d:$j_d;
                    break;

                case'D':
                    $out.=$this->persianWords(array('rh'=>$date[7]),' ');
                    break;

                case'f':
                    $out.=$this->persianWords(array('ff'=>$j_m),' ');
                    break;

                case'F':
                    $out.=$this->persianWords(array('mm'=>$j_m),' ');
                    break;

                case'H':
                    $out.=$date[0];
                    break;

                case'i':
                    $out.=$date[1];
                    break;

                case'j':
                    $out.=$j_d;
                    break;

                case'J':
                    $out.=$this->persianWords(array('rr'=>$j_d),' ');
                    break;

                case'k';
                    $out.=(100-(int)($doy/($kab+365)*1000)/10);
                    break;

                case'K':
                    $out.=((int)($doy/($kab+365)*1000)/10);
                    break;

                case'l':
                    $out.=$this->persianWords(array('rh'=>$date[7]),' ');
                    break;

                case'L':
                    $out.=$kab;
                    break;

                case'm':
                    $out.=($j_m>9)?$j_m:'0'.$j_m;
                    break;

                case'M':
                    $out.=$this->persianWords(array('km'=>$j_m),' ');
                    break;

                case'n':
                    $out.=$j_m;
                    break;

                case'N':
                    $out.=$date[7]+1;
                    break;

                case'o':
                    $jdw=($date[7]==6)?0:$date[7]+1;
                    $dny=364+$kab-$doy;
                    $out.=($jdw>($doy+3) and $doy<3)?$j_y-1:(((3-$dny)>$jdw and $dny<3)?$j_y+1:$j_y);
                    break;

                case'O':
                    $out.=$date[4];
                    break;

                case'p':
                    $out.=$this->persianWords(array('mb'=>$j_m),' ');
                    break;

                case'P':
                    $out.=$date[5];
                    break;

                case'q':
                    $out.=$this->persianWords(array('sh'=>$j_y),' ');
                    break;

                case'Q':
                    $out.=$kab+364-$doy;
                    break;

                case'r':
                    $key=$this->persianWords(array('rh'=>$date[7],'mm'=>$j_m));
                    $out.=$date[0].':'.$date[1].':'.$date[6].' '.$date[4]
                        .' '.$key['rh'].'، '.$j_d.' '.$key['mm'].' '.$j_y;
                    break;

                case's':
                    $out.=$date[6];
                    break;

                case'S':
                    $out.='ام';
                    break;

                case't':
                    $out.=($j_m!=12)?(31-(int)($j_m/6.5)):($kab+29);
                    break;

                case'U':
                    $out.=$ts;
                    break;

                case'v':
                    $out.=$this->persianWords(array('ss'=>substr($j_y,2,2)),' ');
                    break;

                case'V':
                    $out.=$this->persianWords(array('ss'=>$j_y),' ');
                    break;

                case'w':
                    $out.=($date[7]==6)?0:$date[7]+1;
                    break;

                case'W':
                    $avs=(($date[7]==6)?0:$date[7]+1)-($doy%7);
                    if($avs<0)$avs+=7;
                    $num=(int)(($doy+$avs)/7);
                    if($avs<4){
                        $num++;
                    }elseif($num<1){
                        $num=($avs==4 or $avs==(($j_y%33%4-2==(int)($j_y%33*.05))?5:4))?53:52;
                    }
                    $aks=$avs+$kab;
                    if($aks==7)$aks=0;
                    $out.=(($kab+363-$doy)<$aks and $aks<3)?'01':(($num<10)?'0'.$num:$num);
                    break;

                case'y':
                    $out.=substr($j_y,2,2);
                    break;

                case'Y':
                    $out.=$j_y;
                    break;

                case'z':
                    $out.=$doy;
                    break;
                default:
                    $out .= $sub;
            }
        }
        return $out;
    }

    /**
     * @inheritDoc
     */
    public function setDate($year, $month, $day)
    {
        list($gy, $gm, $gd) = PersianDateConverter::jalali_to_gregorian($year, $month, $day);
        parent::setDate($gy, $gm, $gd);
    }

    private function persianWords($array, $mod = '')
    {
        foreach ($array as $type => $num) {
            $num = (int)($num);
            switch ($type) {

                case'ss':
                    $sl=strlen($num);
                    $xy3=substr($num,2-$sl,1);
                    $h3=$h34=$h4='';
                    if($xy3==1){
                        $p34='';
                        $k34=array('ده','یازده','دوازده','سیزده','چهارده','پانزده','شانزده','هفده','هجده','نوزده');
                        $h34=$k34[substr($num,2-$sl,2)-10];
                    }else{
                        $xy4=substr($num,3-$sl,1);
                        $p34=($xy3==0 or $xy4==0)?'':' و ';
                        $k3=array('','','بیست','سی','چهل','پنجاه','شصت','هفتاد','هشتاد','نود');
                        $h3=$k3[$xy3];
                        $k4=array('','یک','دو','سه','چهار','پنج','شش','هفت','هشت','نه');
                        $h4=$k4[$xy4];
                    }
                    $array[$type]=(($num>99)?str_ireplace(array('12','13','14','19','20')
                                ,array('هزار و دویست','هزار و سیصد','هزار و چهارصد','هزار و نهصد','دوهزار')
                                ,substr($num,0,2)).((substr($num,2,2)=='00')?'':' و '):'').$h3.$p34.$h34.$h4;
                    break;

                case'mm':
                    $key=array
                    ('فروردین','اردیبهشت','خرداد','تیر','مرداد','شهریور','مهر','آبان','آذر','دی','بهمن','اسفند');
                    $array[$type]=$key[$num-1];
                    break;

                case'rr':
                    $key=array('یک','دو','سه','چهار','پنج','شش','هفت','هشت','نه','ده','یازده','دوازده','سیزده'
                    ,'چهارده','پانزده','شانزده','هفده','هجده','نوزده','بیست','بیست و یک','بیست و دو','بیست و سه'
                    ,'بیست و چهار','بیست و پنج','بیست و شش','بیست و هفت','بیست و هشت','بیست و نه','سی','سی و یک');
                    $array[$type]=$key[$num-1];
                    break;

                case'rh':
                    $key=array('یکشنبه','دوشنبه','سه شنبه','چهارشنبه','پنجشنبه','جمعه','شنبه');
                    $array[$type]=$key[$num];
                    break;

                case'sh':
                    $key=array('مار','اسب','گوسفند','میمون','مرغ','سگ','خوک','موش','گاو','پلنگ','خرگوش','نهنگ');
                    $array[$type]=$key[$num%12];
                    break;

                case'mb':
                    $key=array('حمل','ثور','جوزا','سرطان','اسد','سنبله','میزان','عقرب','قوس','جدی','دلو','حوت');
                    $array[$type]=$key[$num-1];
                    break;

                case'ff':
                    $key=array('بهار','تابستان','پاییز','زمستان');
                    $array[$type]=$key[(int)($num/3.1)];
                    break;

                case'km':
                    $key=array('فر','ار','خر','تی‍','مر','شه‍','مه‍','آب‍','آذ','دی','به‍','اس‍');
                    $array[$type]=$key[$num-1];
                    break;

                case'kh':
                    $key=array('ی','د','س','چ','پ','ج','ش');
                    $array[$type]=$key[$num];
                    break;

                default:$array[$type]=$num;
            }
        }
        return ($mod == '') ? $array : implode($mod, $array);
    }

    public function ago()
    {
        $now = time();
        $time = $this->getTimestamp();
        // catch error
        if (!$time) {
            return false;
        }
        // build period and length arrays
        $periods = array('ثانیه', 'دقیقه', 'ساعت', 'روز', 'هفته', 'ماه', 'سال', 'قرن');
        $lengths = array(60, 60, 24, 7, 4.35, 12, 10);
        // get difference
        $difference = $now - $time;
        // set descriptor
        if ($difference < 0) {
            $difference = abs($difference); // absolute value
            $negative = true;
        }
        // do math
        for ($j = 0; $difference >= $lengths[$j] and $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }
        // round difference
        $difference = intval(round($difference));
        // return
        return number_format($difference) . ' ' . $periods[$j] . ' ' . (isset($negative) ? '' : 'پیش');
    }
}