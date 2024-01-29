<?php

namespace App\Http\Controllers;

use App\Http\Resources\Components\IdNameSlugImageResource;
use App\Http\Resources\Components\OfficeResource;
use App\Http\Resources\MainPage\ClientFeedbackResource;
use App\Http\Resources\MainPage\PageContentResource;
use App\Http\Resources\OtherPage\FaqResource;
use App\Http\Resources\OtherPage\PageCardResource;
use App\Http\Resources\OtherPage\TemplatePageResource;
use App\Models\ClientFeedback;
use App\Models\SeoSection;
use App\Models\TemplatePage;
use App\Services\Contact\ContactService;
use App\Services\PageContent\PageContentService;
use App\Support\Enums\ContactPlaceType;
use App\Support\Enums\ContactsType;
use App\Support\Enums\SectionContentTechNameType as TechNameType;


class PagesController extends Controller
{
    public function __construct(
        private readonly PageContentService $pageContent,
        private readonly ContactService $contactService
    ) {}

    const ABOUT_US_PAGE_NAME = 'about_us';
    const FAQ_PAGE_NAME = 'faq';
    const CONTACT_PAGE_NAME = 'contacts';
    const PAGE_CARD_LIMIT = 3;

    public function getAboutPage()
    {
        $firstTextBlock = $this->pageContent
            ->getPageContent(TechNameType::AboutPageFirstBlockWithImage->value, self::ABOUT_US_PAGE_NAME);

        $secondTextBlock = $this->pageContent
            ->getPageContent(TechNameType::AboutPageSecondBlock->value, self::ABOUT_US_PAGE_NAME);

        $advantagesTextBlock = $this->pageContent
            ->getPageContent(TechNameType::AboutPageAdvantages->value, self::ABOUT_US_PAGE_NAME);

        $blockBrands = $this->pageContent->getBrands();

        $clientFeedbacks = ClientFeedback::isActive()->sort()->get();

        $officesTextBlock = $this->pageContent
            ->getPageContent(TechNameType::AboutPageOfficesBlock, self::ABOUT_US_PAGE_NAME);

        $offices = $this->pageContent->getOffices();

        $cards = $this->pageContent->getPageCards(self::PAGE_CARD_LIMIT);

        $formBlockTextData = $this->pageContent
            ->getPageContent(TechNameType::AboutPageConsultationForm->value, self::ABOUT_US_PAGE_NAME);

        return response()->json([
            'first_text_block' => PageContentResource::collection($firstTextBlock),
            'second_text_block' => PageContentResource::collection($secondTextBlock),
            'advantages_text_block' => PageContentResource::collection($advantagesTextBlock),
            'brand_table' => IdNameSlugImageResource::collection($blockBrands),
            'client_feedbacks' => ClientFeedbackResource::collection($clientFeedbacks),
            'offices' => [
                'text_block' => $officesTextBlock,
                'offices' => OfficeResource::collection($offices),
            ],
            'cards' => PageCardResource::collection($cards),
            'form_text_data' => PageContentResource::collection($formBlockTextData),
        ]);
    }

    public function getFaqPage()
    {
        $section = SeoSection::getSeoSection(self::FAQ_PAGE_NAME);

        $faq = $this->pageContent->getFaq();

        $cards = $this->pageContent->getPageCards(self::PAGE_CARD_LIMIT);

        $formBlockTextData = $this->pageContent
            ->getPageContent(TechNameType::FaqPageProductOrderForm->value, self::FAQ_PAGE_NAME);

        return response()->json([
            'faq' => FaqResource::collection($faq),
            'cards' => PageCardResource::collection($cards),
            'form_block_text_data' => PageContentResource::collection($formBlockTextData),

            'seo_title' => $section?->seo_title,
            'seo_description' => $section?->seo_description
        ]);
    }

    public function getContactPage()
    {
        $section =  SeoSection::getSeoSection(self::CONTACT_PAGE_NAME);

        $contactsPhone = $this->contactService
            ->getContact(ContactPlaceType::ContactsPage->value, ContactsType::PHONE->value);

        $contactsEmail = $this->contactService
            ->getContact(ContactPlaceType::ContactsPage->value, ContactsType::EMAIL->value);

        $offices = $this->pageContent->getOffices();
        $cards = $this->pageContent->getPageCards(self::PAGE_CARD_LIMIT);

        $firstTextBlock = $this->pageContent
            ->getPageContent(TechNameType::ContactsPageTitle->value, self::CONTACT_PAGE_NAME);

        $formBlockTextData = $this->pageContent
            ->getPageContent(TechNameType::ContactsPageForm->value, self::CONTACT_PAGE_NAME);

        return response()->json([
            'first_text_block' => PageContentResource::collection($firstTextBlock),
            'contacts' => [
                'phone' => $contactsPhone,
                'email' => $contactsEmail
            ],
            'offices' => OfficeResource::collection($offices),
            'cards' => PageCardResource::collection($cards),
            'form_block_text_data' => PageContentResource::collection($formBlockTextData),

            'seo_title' => $section?->seo_title,
            'seo_description' => $section?->seo_description
        ]);
    }

    public function getTemplatePage($slug)
    {
        $page = TemplatePage::isActive()->whereSlug($slug)->first();

        return response()->json([
            'page' => $page ? new TemplatePageResource($page) : null,
        ]);
    }
}
