<?php

namespace App\Support\Enums;

enum FormType: string
{
    case Order = 'order';
    case OrderSearchPage = 'order_search_page';
    case ConsultationBackCall = 'consultation_back_call';
    case ConsultationMainPage = 'consultation_main_page';
    case ConsultationCatalogPage = 'consultation_catalog_page';
    case ConsultationAboutUsPage = 'consultation_about_us_page';
    case ConsultationDeliveryPage = 'consultation_delivery_page';
    case QuestionFAQPage = 'question_faq_page';
    case QuestionContactsPage = 'question_contacts_page';
}
