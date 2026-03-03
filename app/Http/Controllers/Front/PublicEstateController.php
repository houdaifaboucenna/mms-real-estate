<?php

namespace App\Http\Controllers\Front;

use App\Enums\EstateTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CityTown;
use App\Models\Estate;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicEstateController extends Controller
{
    public function estate(Estate $estate)
    {
        return Inertia::render('EstateShow', [
            'estate' => $estate->load('city', 'town'),
            'others' => Estate::with('city', 'town')->where('id', '!=', $estate->id)->inRandomOrder()->limit(4)->get(),
            'translations' => [
                'estate' => __('home.estate'),
                'similar' => __('home.similar'),
                'contact_form' => __('home.contact_us'),
                'city' => __('home.city'),
                'town' => __('home.town'),
                'type' => __('home.type'),
                'price' => __('home.price'),
                'interested_in_this_property' => __('home.Interested in this property?'),
                'all_details_and_legal_consultation' => __('home.Our investment experts are ready to provide you with all details and legal consultation.'),
                'whatsapp_consultation' => __('home.WhatsApp Consultation'),
                'overview_and_details' => __('home.Overview & Details'),
                'view_details' => __('home.view_details'),
            ],
        ]);
    }

    public function estates()
    {
        return Inertia::render('Estates', [
            'estates' => Estate::with('city', 'town')->paginate(9),
            'types' => EstateTypeEnum::labels(),
            'cities' => City::with('towns')->get(),
            'maxPrice' => Estate::max('max') ?? 1000,
            'minPrice' => Estate::min('min') ?? 0,
            'translations' => [
                'estates' => __('home.estates'),
                'all_estates' => __('home.all_estates'),
                'nofound' => __('home.nofound'),
                'home' => __('home.home'),
                'min_price' => __('home.min_price'),
                'max_price' => __('home.max_price'),
                'reset_filters' => __('home.Reset all filters'),
                'adjust_filters' => __('home.Try adjusting your filters to find what you looking for.'),
                'city' => __('home.city'),
                'town' => __('home.town'),
                'type' => __('home.type'),
                'price' => __('home.price'),
                'ch_city' => __('home.ch_city'),
                'ch_town' => __('home.ch_town'),
                'ch_type' => __('home.ch_type'),
                'search' => __('home.search'),
                'view_details' => __('home.view_details'),
            ],
        ]);
    }

    public function filterEstate(Request $request)
    {
        $request->validate([
            'from' => 'nullable|numeric',
            'to' => 'nullable|numeric',
            'type' => 'nullable|string',
            'city' => 'nullable|numeric',
            'town' => 'nullable|numeric',
        ]);
        $estates = Estate::query()->with('city', 'town')
            ->when($request->filled('from'), function ($query) use ($request) {
                $query->where('min', '>=', $request->from);
            })
            ->when($request->filled('to'), function ($query) use ($request) {
                $query->where('min', '<=', $request->to);
            })
            ->when($request->filled('type'), function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->when($request->filled('city'), function ($query) use ($request) {
                $query->whereRelation('city', 'cities.id', $request->city);
            })
            ->when($request->filled('town'), function ($query) use ($request) {
                $query->where('town_id', $request->town);
            })
            ->paginate(9);

        return Inertia::render('Estates', [
            'estates' => $estates,
            'title' => __('home.search_res') . '(' . $estates->count() . ')',
            'types' => EstateTypeEnum::labels(),
            'cities' => City::with('towns')->get(),
            'maxPrice' => Estate::max('max') ?? 1000,
            'minPrice' => Estate::min('min') ?? 0,
            'translations' => [
                'estates' => __('home.estates'),
                'all_estates' => __('home.all_estates'),
                'nofound' => __('home.nofound'),
                'city' => __('home.city'),
                'town' => __('home.town'),
                'type' => __('home.type'),
                'price' => __('home.price'),
                'ch_city' => __('home.ch_city'),
                'ch_town' => __('home.ch_town'),
                'ch_type' => __('home.ch_type'),
                'search' => __('home.search'),
                'view_details' => __('home.view_details'),
                'max_price' => __('home.max_price'),
                'min_price' => __('home.min_price'),
                'reset_filters' => __('home.Reset all filters'),
                'adjust_filters' => __('home.Try adjusting your filters to find what you looking for.'),
            ],
        ]);
    }

    public function fetchTownsByCityId(Request $request)
    {
        $response = CityTown::where('city_id', $request['city'])->get();

        return response()->json($response);
    }
}
