<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    protected $fillable = ['title','content','title_ar','content_ar','short','short_ar','keywords','keywords_ar','slug','image','type','min','max','city','town'];

    public function types()
    {
      $types = [
        1=>__('admin.appartement'),
        2=>__('admin.residence'),
        3=>__('admin.commercial'),
        4=>__('admin.villa'),
        5=>__('admin.offices'),
        6=>__('admin.hotel'),
      ];
      return $types;
    }

    public function getType()
    {
      $types = [
        1=>__('admin.appartement'),
        2=>__('admin.residence'),
        3=>__('admin.commercial'),
        4=>__('admin.villa'),
        5=>__('admin.offices'),
        6=>__('admin.hotel'),
      ];
      return $types[$this->type];
    }

    public function cities()
    {
      $cities = [
        1 => __('admin.turkey'),
        2 => __('admin.antalya'),
        3 => __('admin.bursa'),
        4 => __('admin.istanbul'),
        5 => __('admin.kocaeli'),
        6 => __('admin.sakarya'),
        7 => __('admin.trabzon'),
        8 => __('admin.yalova'),
        9 => __('admin.ankara'),
        10 => __('admin.mugla'),
        11 => __('admin.ordu'),
      ];
      return $cities;
    }

    public function getCity()
    {
      $cities = [
        1 => __('admin.turkey'),
        2 => __('admin.antalya'),
        3 => __('admin.bursa'),
        4 => __('admin.istanbul'),
        5 => __('admin.kocaeli'),
        6 => __('admin.sakarya'),
        7 => __('admin.trabzon'),
        8 => __('admin.yalova'),
        9 => __('admin.ankara'),
        10 => __('admin.mugla'),
        11 => __('admin.ordu'),
      ];
      return $cities[$this->city];
    }

    public function towns($city)
    {
      $towns = [
        __('admin.turkey') => [__('admin.turkey')],
        __('admin.antalya') => [
          __('admin.aksu'),
          __('admin.alanya'),
          __('admin.dosemealti'),
          __('admin.kepez'),
          __('admin.konyaalti'),
          __('admin.muratpasa'),
          __('admin.serik'),
        ],
        __('admin.bursa') => [
          __('admin.inegol'),
          __('admin.mudanya'),
          __('admin.nilufer'),
          __('admin.osmangazi'),
        ],
        __('admin.istanbul') => [
          __('admin.europeanside'),
          __('admin.asianside'),
          __('admin.adalar'),
          __('admin.arnavutkoy'),
          __('admin.atasehir'),
          __('admin.avcilar'),
          __('admin.bagcilar'),
          __('admin.bahcelievler'),
          __('admin.bakirkoy'),
          __('admin.basaksehir'),
          __('admin.beykoz'),
          __('admin.beylikduzu'),
          __('admin.beyoglu'),
          __('admin.buyukcekmece'),
          __('admin.cekmekoy'),
          __('admin.esenyurt'),
          __('admin.eyup'),
          __('admin.fatih'),
          __('admin.gaziosmanpasa'),
          __('admin.gungoren'),
          __('admin.kadikoy'),
          __('admin.kagithane'),
          __('admin.kartal'),
          __('admin.kucukcekmece'),
          __('admin.maltepe'),
          __('admin.pendik'),
          __('admin.sancaktepe'),
          __('admin.sariyer'),
          __('admin.silivri'),
          __('admin.sultangazi'),
          __('admin.sile'),
          __('admin.sisle'),
          __('admin.umraniye'),
          __('admin.uskudar'),
          __('admin.zeytinburnu'),
        ],
        __('admin.kocaeli') => [
          __('admin.basiskele'),
          __('admin.cayirova'),
          __('admin.izmit'),
          __('admin.kandira'),
          __('admin.karamursel'),
          __('admin.kartepe'),
        ],
        __('admin.sakarya') => [
          __('admin.adapazari'),
          __('admin.akyazi'),
          __('admin.karasu'),
          __('admin.sapanca'),
          __('admin.serdivan'),
        ],
        __('admin.trabzon') => [
          __('admin.akcaabat'),
          __('admin.arakli'),
          __('admin.arsin'),
          __('admin.macka'),
          __('admin.ortahisar'),
          __('admin.yomra'),
        ],
        __('admin.yalova') => [
          __('admin.altinova'),
          __('admin.armutlu'),
          __('admin.cinarcik'),
          __('admin.termal'),
        ],
        __('admin.ankara') => [
          __('admin.cankaya'),
          __('admin.yenimahalle'),
        ],
        __('admin.mugla') => [
          __('admin.bodrum'),
        ],
        __('admin.ordu') => [
          __('admin.gulyali'),
        ],
      ];
      return $towns[$city];
    }

    public function getTown()
    {
      $towns = [
        __('admin.turkey') => [__('admin.turkey')],
        __('admin.antalya') => [
          __('admin.aksu'),
          __('admin.alanya'),
          __('admin.dosemealti'),
          __('admin.kepez'),
          __('admin.konyaalti'),
          __('admin.muratpasa'),
          __('admin.serik'),
        ],
        __('admin.bursa') => [
          __('admin.inegol'),
          __('admin.mudanya'),
          __('admin.nilufer'),
          __('admin.osmangazi'),
        ],
        __('admin.istanbul') => [
          __('admin.europeanside'),
          __('admin.asianside'),
          __('admin.adalar'),
          __('admin.arnavutkoy'),
          __('admin.atasehir'),
          __('admin.avcilar'),
          __('admin.bagcilar'),
          __('admin.bahcelievler'),
          __('admin.bakirkoy'),
          __('admin.basaksehir'),
          __('admin.beykoz'),
          __('admin.beylikduzu'),
          __('admin.beyoglu'),
          __('admin.buyukcekmece'),
          __('admin.cekmekoy'),
          __('admin.esenyurt'),
          __('admin.eyup'),
          __('admin.fatih'),
          __('admin.gaziosmanpasa'),
          __('admin.gungoren'),
          __('admin.kadikoy'),
          __('admin.kagithane'),
          __('admin.kartal'),
          __('admin.kucukcekmece'),
          __('admin.maltepe'),
          __('admin.pendik'),
          __('admin.sancaktepe'),
          __('admin.sariyer'),
          __('admin.silivri'),
          __('admin.sultangazi'),
          __('admin.sile'),
          __('admin.sisle'),
          __('admin.umraniye'),
          __('admin.uskudar'),
          __('admin.zeytinburnu'),
        ],
        __('admin.kocaeli') => [
          __('admin.basiskele'),
          __('admin.cayirova'),
          __('admin.izmit'),
          __('admin.kandira'),
          __('admin.karamursel'),
          __('admin.kartepe'),
        ],
        __('admin.sakarya') => [
          __('admin.adapazari'),
          __('admin.akyazi'),
          __('admin.karasu'),
          __('admin.sapanca'),
          __('admin.serdivan'),
        ],
        __('admin.trabzon') => [
          __('admin.akcaabat'),
          __('admin.arakli'),
          __('admin.arsin'),
          __('admin.macka'),
          __('admin.ortahisar'),
          __('admin.yomra'),
        ],
        __('admin.yalova') => [
          __('admin.altinova'),
          __('admin.armutlu'),
          __('admin.cinarcik'),
          __('admin.termal'),
        ],
        __('admin.ankara') => [
          __('admin.cankaya'),
          __('admin.yenimahalle'),
        ],
        __('admin.mugla') => [
          __('admin.bodrum'),
        ],
        __('admin.ordu') => [
          __('admin.gulyali'),
        ],
      ];
      return $towns[$this->getCity()][$this->town-1];
    }

}
