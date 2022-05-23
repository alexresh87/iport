<?php

namespace App\Jobs;

use App\Library\XmlParser\ClientXMLParser;
use App\Models\Category;
use App\Models\Offer;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ParseXML implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $response = Http::withOptions(['verify' => false])->get(config('app.url_xml'));

        Storage::disk('local')->put('data.xml', $response);

        if (file_exists(Storage::path('data.xml'))) {
            $offer = new Offer;
            $parser = new ClientXMLParser(Storage::path('data.xml'));
            $parser
                ->on('parseYml_catalog', function ($data) use ($parser) {
                    if (Storage::disk('local')->exists('parse_date.txt')) {
                        $file_date = Storage::disk('local')->get('parse_date.txt');
                        if ($file_date) {
                            $date_current_parse = \DateTime::createFromFormat('Y-m-d H:i', $data);
                            $date_last_parse = \DateTime::createFromFormat('Y-m-d H:i', $file_date);
                            if ($date_current_parse && $date_last_parse) {
                                if ($date_current_parse->getTimestamp() <= $date_last_parse->getTimestamp()) {
                                    print "The date in the import file " . config('app.url_xml') . " is outdated. Import stopped." . PHP_EOL;
                                    $parser->breakParse();
                                }
                            }
                        }
                    }

                    Storage::disk('local')->put('parse_date.txt', $data);
                })
                ->on('parseCategory', function ($data) {
                    $category = new Category;
                    $category->insert($data);
                })
                ->on('parseOffer', function ($data) {
                    $offer = new Offer;
                    $offer->insert($data);
                })
                ->parse();
        }
    }
}
