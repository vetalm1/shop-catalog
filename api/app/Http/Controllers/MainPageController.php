<?php

namespace App\Http\Controllers;

use App\Http\Resources\Catalog\BrandTableResource;
use App\Http\Resources\Category\CategoryCardResource;
use App\Http\Resources\Components\AdvantageResource;
use App\Http\Resources\Components\IdNameSlugImageResource;
use App\Http\Resources\Components\OfficeResource;
use App\Http\Resources\Components\PartnerCityResource;
use App\Http\Resources\Components\VideoResource;
use App\Http\Resources\MainPage\ClientFeedbackResource;
use App\Http\Resources\MainPage\SliderResource;
use App\Services\MainPage\MainPageService;
use App\Services\PageContent\PageContentService;

class MainPageController extends Controller
{
    const SLIDER_TYPE = 'main_page_first';
    const VIDEO_PAGE_NAME = 'main_page';
    const MAIN_PAGE_ADVANTAGE_MAIN = 'main_page_main';

    public function __construct(
        private readonly MainPageService $mainPageService,
        private readonly PageContentService $pageContentService,
    ) {}

    public function index()
    {
        $backgroundVideo = $this->pageContentService->getVideo(self::VIDEO_PAGE_NAME);

        $brandsScroll = $this->pageContentService->getBrands();

        $firstSlider = $this->pageContentService->getSlider(self::SLIDER_TYPE);

        $advantages = $this->pageContentService->getAdvantages(self::MAIN_PAGE_ADVANTAGE_MAIN);

        $popularCategories = $this->mainPageService->getPopularCategories();

        $offices = $this->pageContentService->getOffices();

        $partnerCities = $this->pageContentService->getPartnerCities();

        $clientFeedbacks = $this->pageContentService->getClientFeedbacks();

        return response()->json([
            'brands_scroll' => IdNameSlugImageResource::collection($brandsScroll),
            'first_slider_left' => $firstSlider ? new SliderResource($firstSlider) : null,
            'advantages' => AdvantageResource::collection($advantages),
            'popular_categories' => CategoryCardResource::collection($popularCategories),
            'brand_table' => BrandTableResource::collection($brandsScroll),
            'offices' => OfficeResource::collection($offices),
            'partner_cities' => PartnerCityResource::collection($partnerCities),
            'background_video' => $backgroundVideo ? new VideoResource($backgroundVideo) : null,
            'client_feedbacks' => ClientFeedbackResource::collection($clientFeedbacks),
        ]);
    }
}
