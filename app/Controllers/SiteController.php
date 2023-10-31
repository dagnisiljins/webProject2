<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\ExchangeRate;
use App\Models\Article;
use Twig\Environment;
use Carbon\Carbon;
use App\Response;

class SiteController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    private function createArticle($id)
    {
        $articlesData = [
            1 => [
                'title' => 'Sācies jauns posms karā Gazas joslā, pauž Izraēla',
                'description' => '"Esam pārgājuši nākamajā kara posmā," paziņojumā Izraēlas sabiedrībai teica ministrs.

            "Vakar vakarā Gazā drebēja zeme. Mēs uzbrukām uz zemes un zem zemes," viņš paskaidroja, piebilstot, ka "rīkojumi spēkiem ir skaidri. Kampaņa turpināsies līdz turpmākai informācijai".

            Galants sacīja, ka ir paplašināta sauszemes operācija Gazā, nosūtot tur tankus un kājniekus, kurus atbalsta plaši gaisa triecieni no aviācijas un jūras spēkiem.

            Izraēlas armija sestdien brīdināja, ka Gazas pilsēta ir kaujas lauks un "patvertnes Gazas joslas ziemeļos un Gazas pilsētā nav drošas". No iznīcinātājiem izmestajās skrejlapās izteikts aicinājums civiliedzīvotājiem "nekavējoties evakuēties" uz Gazas joslas dienvidiem.

            Pirms trim nedēļām, kad sākās karš, Izaēla sapulcināja tūkstošiem karavīru pie Gazas joslas robežas. Līdz šim tie veica īsus nakts reidus Gazā un atgriezās atpakaļ Izraēlā.

            Izraēla uzstāj, ka veic triecienus "Hamās" kaujinieku mērķiem un infrastruktūrai, atbildot uz 7.oktobrī notikušo uzbrukumu, kad "Hamās" Izraēlā nogalināja vairāk nekā 1400 cilvēku un saņēma gūstā vairāk nekā 220 cilvēku.

            Tikmēr Gazas joslā valdošā "Hamās" varasiestādes paziņojušas, ka trīs nedēļas ilgušajos Izraēlas uzlidojumos nogalināti vairāk nekā 7700 cilvēku, bet vēl 1700 cilvēku atrodas zem gruvešiem.

            Veselības aprūpes sistēmu Gazas joslā paralizē sakaru un elektrības atslēgšana.',
            ],
            2 => [
                'title' => 'Cehs.lv: Kā pārdevējs Pītersons Arēnā atnaudoja konservatīvos',
                'description' => 'Par Džordanu Pītersonu, protams, biju dzirdējis daudz. Pat tik daudz, lai viņu kategorizētu kā "kārtējais čalis, kas ar saviem hot-takes tracina tītaru fermu". Ja tu šo lasi, nezinot par Pītersonu, tad iztēlojies Viesturu Rudzīti ar daudz izsmalcinātāku gaumi. Nevar noliegt, ka viņš ir harizmātisks orators britiem tipiskā debašu dueļu kultūrā.
            Savulaik biju ļoti iemīļojis Kristoferu Hitčinsu, kurš ar ļoti izkoptu un literāru valodu spēja savīt savu viedokli tik asā pātagā, ka viņa pretinieki apklusa, bet tūkstošiem "adjutantu" vienojās gavilēs. Tālab nevaru noliegt, ka biju patīkami satraukts par iespēju apmeklēt Pītersona lekciju, jo tā bija iespēja beidzot formulēt savu viedokli par viņu, viņa vēstījumu un viņa faniem.',
            ],
            3 => [
                'title' => 'Noslēgusies Elemental Business Centre būvniecība',
                'description' => '"Elemental Business Centre" būvnieks "Merks" nodevis biroju ēku kompleksu attīstītājam "Kapitel", tādējādi noslēdzot būvniecības posmu, kas tika uzsākts 2021. gada septembrī. Projekta kopējās investīcijas pārsniedz 60 miljonus, un tas sastāv no divām ēkām ar 21 000 m2 kopējo iznomājamo platību.
            Pirmie nomnieki darbu "Elemental Business Centre" sāks jau oktobra beigās.',
            ],
        ];

        if (isset($articlesData[$id])) {
            $data = $articlesData[$id];
            return new Article($data['title'], $data['description'], $id);
        }

        return null;
    }
    public function index()
    {
        $articles = [
            $this->createArticle(1),
            $this->createArticle(2),
            $this->createArticle(3)
        ];

        $url = 'http://api.exchangeratesapi.io/v1/latest?access_key=4755858ee8f52d30b1b91c8d9c04a098';
        $data = json_decode(file_get_contents($url));
        $convertRequest = [
            new ExchangeRate($data->rates->USD),
            new ExchangeRate($data->rates->PLN),
            new ExchangeRate($data->rates->GBP),
            new ExchangeRate($data->rates->CAD)
        ];

        $currentTime = Carbon::now("Europe/Riga");

        return new Response($this->twig, 'index.twig', [
            'articles' => $articles,
            'currentTime' => $currentTime,
            'convertRequest' => $convertRequest,
        ]);
    }

    public function article($vars)
    {
        $id = (int)$vars['id'];
        $article = $this->createArticle($id);

        return new Response($this->twig, 'article.twig', ['article' => $article]);
    }
}
