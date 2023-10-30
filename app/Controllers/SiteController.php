<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Article;
use Twig\Environment;

class SiteController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function index()
    {
        $articles = [
            new Article('Sācies jauns posms karā Gazas joslā, pauž Izraēla', 'Pirmā article apraksts', 1),
            new Article('Cehs.lv: Kā pārdevējs Pītersons Arēnā atnaudoja konservatīvos', 'Otrā article apraksts', 2),
            new Article('Title 3', 'Trešā article apraksts', 3)
        ];

        $template = $this->twig->load('index.twig');

        return $template->render(['articles' => $articles]);
    }

    public function article($vars)
    {
        // Fetch the article by ID or handle not found cases
        $id = $vars['id'];
        $articles = [
            1 => new Article(
                'Sācies jauns posms karā Gazas joslā, pauž Izraēla',
                'Esam pārgājuši nākamajā kara posmā," paziņojumā Izraēlas sabiedrībai teica ministrs.

            "Vakar vakarā Gazā drebēja zeme. Mēs uzbrukām uz zemes un zem zemes," viņš paskaidroja, piebilstot, ka "rīkojumi spēkiem ir skaidri. Kampaņa turpināsies līdz turpmākai informācijai".

            Galants sacīja, ka ir paplašināta sauszemes operācija Gazā, nosūtot tur tankus un kājniekus, kurus atbalsta plaši gaisa triecieni no aviācijas un jūras spēkiem.

            Izraēlas armija sestdien brīdināja, ka Gazas pilsēta ir kaujas lauks un "patvertnes Gazas joslas ziemeļos un Gazas pilsētā nav drošas". No iznīcinātājiem izmestajās skrejlapās izteikts aicinājums civiliedzīvotājiem "nekavējoties evakuēties" uz Gazas joslas dienvidiem.

            Pirms trim nedēļām, kad sākās karš, Izaēla sapulcināja tūkstošiem karavīru pie Gazas joslas robežas. Līdz šim tie veica īsus nakts reidus Gazā un atgriezās atpakaļ Izraēlā.

            Izraēla uzstāj, ka veic triecienus "Hamās" kaujinieku mērķiem un infrastruktūrai, atbildot uz 7.oktobrī notikušo uzbrukumu, kad "Hamās" Izraēlā nogalināja vairāk nekā 1400 cilvēku un saņēma gūstā vairāk nekā 220 cilvēku.

            Tikmēr Gazas joslā valdošā "Hamās" varasiestādes paziņojušas, ka trīs nedēļas ilgušajos Izraēlas uzlidojumos nogalināti vairāk nekā 7700 cilvēku, bet vēl 1700 cilvēku atrodas zem gruvešiem.

            Veselības aprūpes sistēmu Gazas joslā paralizē sakaru un elektrības atslēgšana.',
                1),
            2 => new Article(
                'Cehs.lv: Kā pārdevējs Pītersons Arēnā atnaudoja konservatīvos',
                'Par Džordanu Pītersonu, protams, biju dzirdējis daudz. Pat tik daudz, lai viņu kategorizētu kā "kārtējais čalis, kas ar saviem hot-takes tracina tītaru fermu". Ja tu šo lasi, nezinot par Pītersonu, tad iztēlojies Viesturu Rudzīti ar daudz izsmalcinātāku gaumi. Nevar noliegt, ka viņš ir harizmātisks orators britiem tipiskā debašu dueļu kultūrā.

            Savulaik biju ļoti iemīļojis Kristoferu Hitčinsu, kurš ar ļoti izkoptu un literāru valodu spēja savīt savu viedokli tik asā pātagā, ka viņa pretinieki apklusa, bet tūkstošiem "adjutantu" vienojās gavilēs. Tālab nevaru noliegt, ka biju patīkami satraukts par iespēju apmeklēt Pītersona lekciju, jo tā bija iespēja beidzot formulēt savu viedokli par viņu, viņa vēstījumu un viņa faniem.',
                2),
            3 => new Article('Title 3', 'Trešā article apraksts', 3)
        ];

        if (isset($articles[$id])) {
            $article = $articles[$id];
            $template = $this->twig->load('article.twig');
            return $template->render(['article' => $article]);
        } else {
            // Handle not found
            return 'Article not found';
        }
    }
}