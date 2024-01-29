<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use MeiliSearch\Client;
use function PHPUnit\Framework\throwException;

class UpdateMeilisearchIndex extends Command
{
    protected $signature = 'meilisearch:update';

    protected $description = 'Update Meilisearch index and attributes';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $client = new Client(config('scout.meilisearch.host'));

        $this->updateSortableAttributes($client);

        $this->updateFilterableAttributes($client);

        $this->setMaxTotalHits();

        echo "подождать минут 5 ...". PHP_EOL;

        return Command::SUCCESS;
    }

    protected function updateSortableAttributes(Client $client):void
    {

        $this->info('Updated sortable attributes...');
    }

    /** Добавить атрибуты для возможности фильтрации в поисковом запросе */
    protected function updateFilterableAttributes(Client $client): void
    {
        $res = $client->index('products')->updateFilterableAttributes(['is_active',]);

        $this->info(json_encode($res));
    }

    /** Изменить кол-во товаров найденных, (по умолчанию = 1000) */
    public function setMaxTotalHits()
    {
        Http::withHeaders(['Content-Type' => 'application/json'])
            ->patch('http://meilisearch:7700/indexes/product/settings/pagination', ['maxTotalHits' => 2000]);
    }
}
