<?php

namespace App\Support\Enums;

enum SectionContentTechNameType: string
{
    case MainPageFirstBlock = 'main_page_first_block';
    case MainPageForm = 'main_page_form';
    case MainPagePartnersMap = 'main_page_partners_map';
    case MainPageBottomBlock = 'main_page_bottom_block';
    case AboutPageFirstBlockWithImage = 'about_page_first_block_with_image';
    case AboutPageSecondBlock = 'about_page_second_block';
    case AboutPageAdvantages = 'about_page_advantages';
    case AboutPageCompanyMission = 'about_page_company_mission';
    case AboutPageCompanyMissionDetails = 'about_page_company_mission_details';
    case AboutPageOfficialDealers = 'about_page_official_dealers';
    case AboutPageOfficesBlock = 'about_page_offices_block';
    case AboutPageConsultationForm = 'about_page_consultation_form';
    case ContactsPageTitle = 'contacts_page_title';
    case DeliveryAndPaymentPageFirstBlockWithImage = 'delivery_and_payment_page_first_block_with_image';
    case DeliveryAndPaymentPageConsultationForm = 'delivery_and_payment_page_consultation_form';
    case CatalogPageBottomGetBackCall = 'catalog_page_bottom_get_back_call';
    case SearchPageProductOrderForm = 'search_page_product_order_form';
    case FaqPageProductOrderForm = 'faq_page_product_order_form';
    case ContactsPageForm = 'contacts_page_form';
}
