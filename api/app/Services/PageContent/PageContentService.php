<?php

namespace App\Services\PageContent;

use App\Models\Advantage;
use App\Models\Brand;
use App\Models\ClientFeedback;
use App\Models\Faq;
use App\Models\Office;
use App\Models\PageCard;
use App\Models\PageVideo;
use App\Models\PartnerCity;
use App\Models\SectionContent;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Collection;

class PageContentService
{
    public function getPageContent($contentTechName, $pageName): Collection
    {
        return SectionContent::isActive()->whereHas('seoSection', function ($query) use ($pageName) {
            $query->wherePageName($pageName);
        })->whereTechName($contentTechName)->sort()->get();
    }

    public function getOffices(): Collection|array
    {
        return Office::isActive()->sort()->get();
    }

    public function getPartnerCities(): Collection|array
    {
        return PartnerCity::isActive()->get();
    }

    public function getClientFeedbacks(): Collection|array
    {
        return ClientFeedback::isActive()->sort()->get();
    }

    public function getSlider($type): Slider|null
    {
        return Slider::type($type)->withSlides()->first();
    }

    public function getBrands(): Collection|array
    {
        return Brand::isActive()->main()->get();
    }

    public function getVideo($pageName): PageVideo|null
    {
        return PageVideo::page($pageName)->first();
    }

    public function getAdvantages($type): Collection|array
    {
        return Advantage::type($type)->isActive()->sort()->get();
    }

    public function getPageCards($limit): Collection|array
    {
        return PageCard::isActive()->limit($limit)->sort()->get();
    }

    public function getFaq(): Collection|array
    {
        return Faq::isActive()->get();
    }
}
