<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category\CategoryCardResource;
use App\Http\Resources\Components\SocialNetworkResource;
use App\Http\Resources\MainPage\ContactResource;
use App\Models\SocialNetwork;
use App\Services\Catalog\CatalogService;
use App\Services\Contact\ContactService;
use App\Support\Enums\ContactPlaceType;
use App\Support\Enums\ContactsType;

class HeaderController extends Controller
{
    public function __construct(
        private readonly CatalogService $catalogService,
        private readonly ContactService $contactService
    ) {}

    public function getHeaderFooterData()
    {
        $menuCategoryTree = $this->catalogService->getCategoryTree();

        $phone = $this->contactService->getContact(ContactPlaceType::Header->value, ContactsType::PHONE->value);

        $footerPhones = $this->contactService->getContact(ContactPlaceType::Footer->value, ContactsType::PHONE->value);

        $footerEmail = $this->contactService->getContact(ContactPlaceType::Footer->value, ContactsType::EMAIL->value);

        $footerAddress = $this->contactService->getContact(ContactPlaceType::Footer->value, ContactsType::ADDRESS->value);

        $socialNetworks = SocialNetwork::isActive()->get();

        $mapLink = $this->contactService->getContact(ContactPlaceType::Footer->value, ContactsType::LINK->value);

        return response()->json([
            'header' => [
                'menu' => CategoryCardResource::collection($menuCategoryTree),
                'phone' => new ContactResource($phone),
            ],
            'footer' => [
                'phones' => ContactResource::collection($footerPhones),
                'email' =>new ContactResource($footerEmail),
                'address' => new ContactResource($footerAddress),
                'social_networks' => SocialNetworkResource::collection($socialNetworks),
                'map_link' => $mapLink->value,
            ]
        ]);
    }

}
