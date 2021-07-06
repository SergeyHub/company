<?php

use Illuminate\Database\Seeder;

class ContentSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Entity\Content\Content::where('slug','bottom_seo_main')->delete();
        \App\Entity\Content\Content::where('slug','bottom_seo_country')->delete();
        \App\Entity\Content\Content::where('slug','bottom_seo_city')->delete();
        \App\Entity\Content\Content::create([
            'slug' => 'bottom_seo_main',
            'page' => false,
            'en' => [
                'content' => '<div class="row">
                    <div class="footer-info-block col-md-6">
                    <h2>Male Escort Ads</h2>
                    <p>A woman who appeared in an elite society accompanied by a handsome man attracts much more attention than a lonely one. A pleasant conversationalist is a reason for pride, envy or respect. If you want to effectively appear at the event, but you don’t have a couple, don\'t get upset. You can order a male escort. And MyBestGigolo.com will help you with this! You will find a large number of escort services ads from men for every taste.</p>

<p>Handsome, elegant and well-groomed men are waiting for you! They will gladly make a new acquaintance and give you an unforgettable pastime. Male escort ads are shown by both specialized agencies and independent men themselves. And this all is in order to please women, to give them invaluable attention and affection. Choose the most attractive escort companion among many candidates, and let the upcoming rendezvous bring you unforgettable experience.</p>
                    </div>

                    <div class="footer-info-block col-md-6">
                    <h3>Book luxury male escort services</h3>
                    <p>On MyBestGigolo.com you will find men who will 100% meet your requirements. Candidates for every taste: young and old, tall and short, fair-skinned and mulattos, with any hair color and various types of shapes: thin, muscular and stocky. Elite male escort services involve not only meetings in the near future, but also the opportunity to book a meeting at a date convenient for you. This is the best option for those who don\'t want to miss the chosen gentleman.</p>

<p>Elite male escort is your chance to meet a really gorgeous man. How you spend time with him depends only on your desires. It can be a romantic dinner with a continuation or accompaniment to any event. Men from the escort always look stylish and handsome. With such a companion, you can come to any place and have a great time. This is not only an excellent lover, but also an interesting conversationalist who skillfully supports small talk. Don\'t miss the opportunity to have an unforgettable time with the man of your dreams!</p>
                    </div>
                    </div>'
            ],
            'ru' => [
                'content' => '<div class="row">
                    <div class="footer-info-block col-md-6">
                    <h2>Объявления об эскорт-услугах от мужчин</h2>
                    <p>Женщина, появившаяся в элитном обществе в компании представительного мужчины, привлекает к себе гораздо больше внимания, чем одинокая. Приятный собеседник - это повод для гордости, зависти или уважения. Если вы хотите эффектно предстать на мероприятии, но у вас нет пары, не стоит расстраиваться. Вы можете воспользоваться мужским эскортом. И в этом вам поможет MyBestGigolo.com! Вас ждет большое количество объявлений об эскорт-услугах от мужчин на любой вкус.</p>

<p>Красивые, элегантные и ухоженные представители сильного пола ждут именно вас! Они с радостью заведут новое знакомство и подарят вам незабываемое времяпрепровождение. Объявления о предоставлении мужских эскорт-услуг выкладывают специализированные агентства и сами мужчины, самостоятельно пришедшие в эту сферу. И все ради того, чтобы порадовать женщин, уделить им бесценное внимание и ласку. Выберите самого привлекательного спутника для эскорта среди множества кандидатов, и пусть предстоящее рандеву принесет вам незабываемые впечатления.</p>
                    </div>

                    <div class="footer-info-block col-md-6">
                    <h3>Забронировать элитные мужские эскорт-услуги</h3>
                    <p>На сайте MyBestGigolo.com вы найдете мужчин, которые будут на 100% соответствовать вашим требованиям. Кандидаты на любой вкус: молодые и взрослые, высокие и низкие, светлокожие и мулаты, с любым цветом волос и различными типами фигуры: худые, накаченные и коренастые. Элитные мужские эскорт-услуги предполагают не только встречи в ближайшее время, но и возможность забронировать встречу на удобную вам дату. Это лучший вариант для тех, кто не хочет упустить понравившегося кавалера.</p>

<p>Элитный мужской эскорт – это ваш шанс познакомиться с шикарным представителем противоположного пола. Как вы проведете с ним время, зависит только от ваших желаний. Это может быть романтический ужин с продолжением или сопровождение на любое мероприятие. Мужчины из эскорта всегда выглядят стильно и представительно. С таким спутником можно прийти в любое заведение и классно отдохнуть. Это не только отличный любовник, но и интересный собеседник, который умело поддержит светскую беседу. Не упустите возможность незабываемо  провести время с мужчиной вашей мечты!</p>
                    </div>
                </div>'
            ]
        ]);

        \App\Entity\Content\Content::create([
            'slug' => 'bottom_seo_country',
            'page' => false,
            'en' => [
                'content' => '<div class="row">
                    <div class="footer-info-block col-md-6">
                    <h2>Escort Ads from men in %country%</h2>
                    <p>Are you a lonely girl in %country% and want to have fun with an interesting man? We have a great offer for residents and guests of this country - this is a male escort in %country%. No woman will refuse a rendezvous with an attractive and well-mannered man. And it doesn’t even matter if she is free or married. Are you bored with your partner and want to experience romantic feelings again? Male escort services are an ideal solution for women who want to be desirable.</p>

<p>On MyBestGigolo.com there are many ads of escort services from men in %country% - they will give you a unique opportunity to make a new acquaintance and diversify your leisure time. Handsome men with a stylish appearance and well-groomed bodies are ready to have a great time with you right today. They know exactly how to make a woman happy, say sincere compliments and take care of the ladies beautifully.</p>
                    </div>

                    <div class="footer-info-block col-md-6">
                    <h3>Book luxury male escort services in %country%</h3>
                    <p>On MyBestGigolo.com you can find various candidates\' profiles from %country%. Among such a variety of escort ads, you will surely find the man of your dreams. He will come at any time and give the emotions you lack. Charming, hot and passionate men from an elite escort will turn your fantasies into reality. Spend time with a sexy handsome man exactly the way you want it. Contact male escort services in %country% and give free rein to your desires, as well as reveal your sexual potential and get a lot of attention.</p>

<p>Elite male escort services will give you dizzying emotions and unforgettable impressions. You can book a man for a romantic meeting with a piquant continuation or to accompany you to any event. Men from an escort will ideally fit into the style of any event: an elite party or a social event. A handsome man next to you will make you feel more respectable and he will support any conversation. Are you bored in %country% or want to travel there? Then you can choose a man on MyBestGigolo.com and book him for your best vacation!</p>
                    </div>
                    </div>'
            ],
            'ru' => [
                'content' => '<div class="row">
                    <div class="footer-info-block col-md-6">
                    <h2>Объявления об эскорт-услугах от мужчин в %country_prepositional%</h2>
                    <p>Вы одинокая девушка в %country_prepositional% и желаете страстно развлечься с интересным мужчиной? У нас есть отличное предложение для жительниц и гостей данной страны - это мужской эскорт в %country_prepositional%. Ни одна женщина не откажется от рандеву с привлекательным воспитанным мужчиной. И даже не важно, свободна она или состоит в браке. Вам стало скучно со своим партнером и хочется снова испытать романтические чувства? Мужские эскорт услуги - это идеальное решение для женщин, которые хотят почувствовать себя желанными.</p>

<p>На сайте MyBestGigolo.com представлено множество объявлений об эскорт-услугах от мужчин в %country_prepositional% - они дадут вам уникальную возможность завести новое знакомство и разнообразить свой досуг. Презентабельные представители мужского пола с фешенебельной внешностью и ухоженным телом готовы, прямо сегодня, классно провести с вами время. Они точно знают, как сделать женщине приятно, говорят искренние комплименты и красиво ухаживают.</p>
                    </div>

                    <div class="footer-info-block col-md-6">
                    <h3>Забронировать элитные мужские эскорт-услуги в %country_prepositional%</h3>
                    <p>На сайте MyBestGigolo.com вы можете посмотреть анкеты от различных кандидатов из %country_genitive%. Среди такого разнообразия объявлений об эскорте, вы точно встретите мужчину своей мечты. Он приедет в любое время и подарит те эмоции, которых вам не хватает. Очаровательные, горячие и страстные мужчины из элитного эскорта сделают ваши фантазии реальностью. Проведите это время с сексуальным красавцем именно так, как вы захотите. Воспользуйтесь мужскими эскорт-услугами в %country_prepositional% и дайте волю своим желаниям, а также раскройте свой сексуальный потенциал и получите много внимания.</p>

<p>Мужские элитные эскорт-услуги – это головокружительные эмоции и незабываемые впечатления. Вы можете забронировать мужчину для романтической встречи с пикантным продолжением или для сопровождения на любое мероприятие. Мужчины из эскорта идеально впишутся в стилистику любого события: будь то элитная вечеринка или светское мероприятие. Красивый мужчина рядом с вами добавит вам статуса и поддержит разговор.  Заскучали в %country_prepositional% или хотите приехать туда в путешествие? Тогда вы можете выбрать мужчину на MyBestGigolo.com и забронировать его для своего самого лучшего отпуска!</p>
                    </div>
                </div>'
            ]
        ]);


        \App\Entity\Content\Content::create([
            'slug' => 'bottom_seo_city',
            'page' => false,
            'en' => [
                'content' => '<div class="row">
                    <div class="footer-info-block col-md-6">
                    <h2>Escort Ads from men in %city%</h2>
                    <p>Are you looking for a stunning man in %city% who will accompany you to a social event? Or do you want to make a new acquaintance and diversify your leisure? The best offer for single and married women, which you can’t refuse. MyBestGigolo.com offers you a male escort in %city%, with the man you will feel like the most attractive and desirable woman and experience dizzying emotions.</p>

<p>There are many ads of male escort service in %city% for your attention. The candidates’ profiles are published on behalf of some agencies or by the men themselves. You will find the most stylish, well-groomed and passionate representatives of the male escort industry. Choose a companion who will satisfy your requirements in appearance, figure and temperament, because the choice of men will really blow your mind.</p>

<p>Male escort services give this opportunity to wealthy women to meet the man of their dreams in %city% and go with him for a romantic dinner or a social party, as well as get a fantastic sexual experience. You will have a good time with a gorgeous man from escort today or book an appointment for a date convenient to you.</p>
                    </div>

                    <div class="footer-info-block col-md-6">
                    <h3>Book elite male escort services in the %city%</h3>
                    <p>If you are a %city% resident and don\'t want to miss the chance to meet a handsome man, you can find and book elite male escort services with MyBestGigolo.com at any time. To meet a breathtaking man, you need to prepare to match his luxurious image. Together you will look great at any party or dinner.</p>

<p>Also, a male escort in %city% is available for girls who want to visit this city for a vacation. In addition, if you plan to visit %city% on business and want somebody to  keep you company, then you definitely need a handsome and stunning man next to you. He is a true professional in matters of courting a lady and will not let you get bored. Men from the escort have sexy bodies, they are interesting people who you can pleasantly chat with and whom you can fully enjoy in bed. Come on MyBestGigolo.com and choose the hottest guy for an unforgettable pastime.</p>
                    </div>
                    </div>'
            ],
            'ru' => [
                'content' => '<div class="row">
                    <div class="footer-info-block col-md-6">
                    <h2>Объявления об эскорт-услугах от мужчин в %city_prepositional%</h2>
                    <p>Ищете сногсшибательного мужчину в %city_prepositional%, который составит вам компанию для посещения светского раута? Или вы желаете завести новое знакомство и разнообразить свой досуг? Лучшее предложение для одиноких и замужних женщин, от которого вы не сможете отказаться. MyBestGigolo.com предлагает вам мужской эскорт в %city_prepositional% - с ним вы почувствуете себя самой привлекательной и желанной женщиной и испытаете головокружительные эмоции.</p>

<p>Вашему вниманию представлено множество объявлений об эскорт-услугах от мужчин в %city_prepositional%. Анкеты кандидатов публикуются от имени агентств или ими самостоятельно. Вы найдете самых стильных, ухоженных и страстных представителей сферы мужского эскорта. Выберите себе спутника, который удовлетворит ваши требования по внешности, фигуре и темпераменту, ведь выбор мужчин, действительно, потрясет ваше воображение.</p>

<p>Мужские эскорт-услуги дают это возможность состоятельным женщинам познакомиться с мужчиной своей мечты в %city_prepositional% и отправиться с ним на романтический ужин или светскую тусовку, а также получить фантастический сексуальный опыт. Вы можете приятно провести время с шикарным мужчиной из эскорта уже сегодня или забронировать встречу на удобную для вас дату.</p>
                    </div>

                    <div class="footer-info-block col-md-6">
                    <h3>Забронировать элитные мужские эскорт-услуги в %city_prepositional%</h3>
                    <p>Если вы жительница %city_genitive% и не хотите упустить шанс встретиться с презентабельным мужчиной, то можете найти и забронировать элитные мужские эскорт-услуги через MyBestGigolo.com на любое время. Для встречи с потрясающим мужчиной нужно подготовиться, чтобы соответствовать его роскошному образу. Вместе вы будете прекрасно смотреться на любой вечеринке или званом ужине.</p>

<p>Также мужской эскорт в %city_prepositional% доступен для девушек, которые хотят посетить этот город для отдыха. Кроме того, если вы планируете посетить %city% с рабочим визитом и хотите скрасить свое одиночество, то вам точно нужен красивый и солидный мужчина рядом. Он настоящий профессионал в вопросах ухаживания за дамой и не даст вам заскучать. Мужчины из эскорта - это интересные личности, обладатели сексуального тела, с которыми можно приятно побеседовать и которым вы можете в полной мере насладиться в постели. Заходите на MyBestGigolo.com и выберите себе самого горячего парня для незабываемого времяпрепровождения.
</p>
                    </div>
                </div>'
            ]
        ]);

    }
}
