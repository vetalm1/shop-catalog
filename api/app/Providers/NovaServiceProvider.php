<?php

namespace App\Providers;

use App\Nova\Advantage;
use App\Nova\Brand;
use App\Nova\ClientFeedback;
use App\Nova\Consultation;
use App\Nova\Contact;
use App\Nova\DeliveryPageBlock;
use App\Nova\FailedJob;
use App\Nova\Faq;
use App\Nova\FormOrder;
use App\Nova\MainPagePopularCategory;
use App\Nova\MissionDetailsBlock;
use App\Nova\Office;
use App\Nova\OfficialDealerBrand;
use App\Nova\PageCard;
use App\Nova\PageVideo;
use App\Nova\PartnerCity;
use App\Nova\PopularCategory;
use App\Nova\Category;
use App\Nova\Product;
use App\Nova\ProductAddition;
use App\Nova\Property;
use App\Nova\PropertyGroup;
use App\Nova\Question;
use App\Nova\ResponsibleEmployee;
use App\Nova\Resources\Image;
use App\Nova\Resources\Video;
use App\Nova\Resume;
use App\Nova\SeoSection;
use App\Nova\Slider;
use App\Nova\SocialNetwork;
use App\Nova\SyncData;
use App\Nova\TemplatePage;
use App\Nova\User;

use App\Nova\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Dashboards\Main;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuGroup;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        /* Nova::script('hideTrixAttacheButton.js', '/'); /* скрыть кнопку добавления файла в trix */


        Nova::userMenu(function (Request $request, Menu $menu) {

            $menu->append(MenuItem::make('Какой то пункт')->path('/resource/ru'));

            return $menu;
        });

        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::dashboard(Main::class)->icon('chart-bar'),

                MenuSection::make('Заявки/вопросы', [
                    MenuItem::resource(ResponsibleEmployee::class),
                    MenuItem::resource(FormOrder::class),
                    MenuItem::resource(Consultation::class),
                    MenuItem::resource(Question::class),
                    MenuItem::resource(Resume::class),

                ])->icon('table')->collapsable(),

                MenuSection::make('Главная страница', [
                    MenuItem::resource(Slider::class)->name('Слайдеры (банеры)'),
                    MenuItem::resource(Advantage::class)->name('Преимущества'),
                    MenuItem::resource(MainPagePopularCategory::class)->name('Популярные категории'),
                    MenuItem::resource(Office::class)->name('Офисы'),
                    MenuItem::resource(PartnerCity::class)->name('Города партнеров'),
                    MenuItem::resource(ClientFeedback::class)->name('Отзывы клиентов'),
                    MenuItem::resource(PageVideo::class)->name('Видео для страниц'),
                ])->icon('home')->collapsable(),

                MenuSection::make('Каталог', [
                    MenuGroup::make('Категории', [
                        MenuItem::resource(Category::class)->name('- Категории'),
                        MenuItem::resource(PopularCategory::class)->name('- Популярные категории'),
                    ])->collapsable(),
                    MenuGroup::make('Бренды}', [
                        MenuItem::resource(Brand::class)->name('Бренды'),
                        MenuItem::resource(OfficialDealerBrand::class)->name('Бренды (официальный дилер)'),
                    ])->collapsable(),
                    MenuGroup::make('Характеристики}', [
                        MenuItem::resource(Property::class)->name('- Характеристики'),
                        MenuItem::resource(PropertyGroup::class)->name('- Группы'),
                    ])->collapsable(),

                    MenuItem::resource(Product::class)->name('Товары'),
                    MenuItem::resource(ProductAddition::class)->name('Табы для стр. Товары'),
                ])->icon('collection')->collapsable(),

                MenuSection::make('Настройки', [
                    MenuItem::resource(SeoSection::class),
                    MenuItem::resource(SocialNetwork::class),
                ])->icon('cog')->collapsable(),

                MenuSection::make('Страницы', [
                    MenuGroup::make('О компании', [
                        MenuItem::resource(SeoSection::class)->name('- Основные блоки')
                            ->path('/resources/seo-sections/5'),
                        MenuItem::resource(MissionDetailsBlock::class)->name('- Блоки для "миссии компании"'),
                    ])->collapsable(),
                    MenuItem::resource(Faq::class)->name('Вопрос-ответ'),
                    MenuItem::resource(Vacancy::class)->name('Вакансии'),
                    MenuItem::resource(Contact::class)->name('Контактные данные'),
                    MenuItem::resource(DeliveryPageBlock::class)->name('Доставка'),
                    MenuItem::resource(PageCard::class)->name('Карточки для страниц'),
                    MenuItem::resource(TemplatePage::class)->name('Шаблонные страницы'),
                    MenuItem::resource(Image::class), /* for new ckeditor 5 */
                    //MenuItem::resource(Video::class), /* for new ckeditor 5 */
                ])->icon('template')->collapsable(),

                MenuSection::make('Тех.данные', [
                    MenuItem::resource(User::class),
                    MenuItem::resource(SyncData::class),
                    MenuItem::resource(FailedJob::class),
                ])->icon('adjustments')->collapsable(),
            ];
        });


    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                'admin@housevl.ru'
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
