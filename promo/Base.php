<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends CI_Controller
{
    public $service_detailed = array(

        'staining' => array(
            'action_button' => 'Выбор окрашивания',
            'action_title' => 'Выбери свой стиль',

            'styles' => array(
                'ombre' => array(
                    'name' => 'Омбре',
                    'name_full' => 'Окрашивание омбре',
                    'description' => 'Омбре стало популярно благодаря тому, что оно созадет естественный природный оттенок на волосах. А, как известно, в моде сейчас естественность.',
                    'time' => '60',
                    'price' => '2900',
                    'preview_type' => '',
                    'preview_text_post' => 'right-bottom',
                ),
                'shatush' => array(
                    'name' => 'Шатуш',
                    'name_full' => 'Окрашивание шатуш',
                    'description' => 'Заключается в плавном переходе более темного оттенка волос к более светлому. Волосы выглядят как будто слегка выгоревшими на солнце, но при этом блестящими и ухоженными',
                    'time' => '60',
                    'price' => '2900',
                    'preview_type' => '',
                    'preview_text_post' => 'left-bottom',
                ),
                'brondirovanie' => array(
                    'name' => 'Брондирование',
                    'name_full' => 'Брондирование',
                    'description' => 'Такая техника получилась в результате слияния легкого мелирования и естественного колорирования, в результате которого получаются интересные цветовые решения с гармоничной игрой красок.',
                    'time' => '60',
                    'price' => '1900',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-top',
                ),
                'odno' => array(
                    'name' => 'Однотонное',
                    'name_full' => 'Однотонное окрашивание',
                    'description' => 'Женщины часто используют именно эту технику, так как она является наиболее простой и к тому же всегда остается в тренде',
                    'time' => '60',
                    'price' => '1900',
                    'preview_type' => '',
                    'preview_text_post' => 'right-bottom',
                ),
                'melirovanie' => array(
                    'name' => 'Мелирование',
                    'name_full' => 'Мелирование',
                    'description' => 'Помогает «оживить» волосы без резкого изменения цвета, плавно вернуться к натуральному цвету после окрашивания, визуально увеличивает объём и усиливает блеск.',
                    'time' => '60',
                    'price' => '2600',
                    'preview_type' => '',
                    'preview_text_post' => 'right-bottom',
                ),
            ),
        ),

        'hair_care' => array(

            'styles_no_question' => '1',

            'styles' => array(
                'restore' => array(
                    'name' => 'Восстановление волос',
                    'name_full' => '',
                    'description' => 'Улучшение состояния волос: придать им блеск и пышность, вернуть густоту, устранить сухость и сечение на кончиках, жирность у корней.',
                    'time' => '60',
                    'price' => '450',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'three_twelve'
                ),
                'care' => array(
                    'name' => 'Уход за кожей головы',
                    'name_full' => '',
                    'description' => 'Здесь находится зона роста волос, центр их питания и кровоснабжения. Невозможно стать обладателем здоровых, сильных волос, имея проблемную кожу головы.',
                    'time' => '60',
                    'price' => '600',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'three_twelve'
                ),
                'laminate' => array(
                    'name' => 'Ламинирование',
                    'name_full' => '',
                    'description' => 'Если вы устали от тусклых, жестких и безжизненных волос, то самое время сделать ламинирование. Волосы будут выглядеть ухоженными, приобретут здоровый вид, объем, блеск, шелковистость и гладкость.',
                    'time' => '60',
                    'price' => '2400',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'three_twelve'
                ),
                'zavivka' => array(
                    'name' => 'Завивка',
                    'name_full' => '',
                    'description' => 'Как же красиво смотрятся кудрявые волосы! Они делают из женщины настоящую кокетку. Вьющиеся локоны аккуратно обрамляют её лицо и создают довольно яркий образ.',
                    'time' => '60',
                    'price' => '5600',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'three_twelve'
                ),
            ),
        ),

        'body_care' => array(

            'styles_no_question' => '1',

            'styles' => array(
                'face' => array(
                    'name' => 'Уход за лицом',
                    'name_full' => '',
                    'description' => 'Кожа лица является наиболее открытой частью тела, которая постоянно подвергается внешнему воздействию. Поэтому очень важно следить и регулярно ухаживать за ней.',
                    'time' => '60',
                    'price' => '1000',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'three_twelve',
                ),
                'body' => array(
                    'name' => 'Уход за телом',
                    'name_full' => '',
                    'description' => 'Чтобы тело всегда находилось в отличной форме, радовало состояние кожи и стройность его форм, нужно правильно ухаживать за ним и проявлять должную заботу.',
                    'time' => '60',
                    'price' => '2000',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'three_twelve',
                ),
                'complex' => array(
                    'name' => 'Комплекс',
                    'name_full' => '',
                    'description' => 'Подспорьем здоровому образу жизни, несомненно, служат косметические процедуры: очищающие, тонизирующие, увлажняющие, питающие и омолаживающие.',
                    'time' => '60',
                    'price' => '4800',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'three_twelve',
                ),
                'clean' => array(
                    'name' => 'Очищение',
                    'name_full' => '',
                    'description' => 'Кожа является самым большим человеческим органом. Она является одновременно и выделительным и впитывающим органом. Очищение кожи глобально влияет на здоровье человека.',
                    'time' => '60',
                    'price' => '2500',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'three_twelve',
                ),
            ),
        ),

        'epilation' => array(

            'styles_no_question' => '1',

            'style_margin_v' => true,

            'styles' => array(
                'bikini' => array(
                    'name' => 'Бикини',
                    'name_full' => 'Бикини',
                    'description' => 'Сегодня разработана масса различных способов эпиляции бикини, при помощи которых можно избавиться от нежелательных волосков.',
                    'time' => '60',
                    'price' => '1000',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'four_twelve',
                ),
                'lips' => array(
                    'name' => 'Губы',
                    'name_full' => 'Губы',
                    'description' => 'Женщины постоянно ищут способы борьбы с нежелательной растительностью на лице и теле. И уже найдено большое количество разных вариаций удаления волосков с кожи.',
                    'time' => '60',
                    'price' => '300',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'four_twelve',
                ),
                'podmishki' => array(
                    'name' => 'Подмышки',
                    'name_full' => 'Подмышки',
                    'description' => 'Подмышечные впадины с густыми темными волосами выглядят не эстетично и вызывают отвращение у окружающих. Эпиляция подмышек решает эту проблему и позволяют добиться эффекта гладкой кожи.',
                    'time' => '60',
                    'price' => '600',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'four_twelve',
                ),
                'legs' => array(
                    'name' => 'Ноги',
                    'name_full' => 'Ноги',
                    'description' => 'Избавиться от лишних волос на ногах непросто, современные девушки прилагают для этого массу усилий. Множество разнообразных методик обеспечивает получение желаемых результатов.',
                    'time' => '60',
                    'price' => '1000',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'five_twelve',
                ),
                'arms' => array(
                    'name' => 'Руки',
                    'name_full' => 'Руки',
                    'description' => 'Удаление волос на руках проводится для того, чтобы выглядеть более красиво. Женщины стремятся получить гладкую кожу, чтобы без комплексов носить открытую одежду и не стесняться своего вида на пляже.',
                    'time' => '60',
                    'price' => '700',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'four_twelve',
                ),
                'grud' => array(
                    'name' => 'Грудь/спина',
                    'name_full' => 'Грудь/спина',
                    'description' => 'Эпиляция груди и спины хороша для тех, кто любит поиграть мускулами, соблюдает профессиональные требования или склонен к повышенному потоотделению, особенно в летнее время.',
                    'time' => '60',
                    'price' => '2000',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'three_twelve',
                ),
            ),
        ),

        'nails' => array(

            'styles_no_question' => '1',

            'styles' => array(
                'manic' => array(
                    'name' => 'Маникюр',
                    'name_full' => '',
                    'description' => 'В наше время мастерами создана целая система для маникюра, куда входит, в обязательном порядке и уход за ногтями.',
                    'time' => '60',
                    'price' => '300',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'four_twelve',
                ),
                'pedic' => array(
                    'name' => 'Педикюр',
                    'name_full' => '',
                    'description' => 'Педикюр не должен оставаться без внимания. Комплексность и регулярность процедур дают хороший результат. Особенно широкого спектра процедур требует стопа.',
                    'time' => '60',
                    'price' => '300',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'four_twelve',
                ),
                'care' => array(
                    'name' => 'Уход за ногтями',
                    'name_full' => '',
                    'description' => 'Довольно трудно в наше время представить человека, соответствующую понятию «современный» с ногтями, не ухоженными и красивыми, а обломанными и нездоровыми.',
                    'time' => '60',
                    'price' => '1000',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'four_twelve',
                ),
            ),

            /* 'other_styles' => array(
                'complex_hand' => array(
                    'name' => 'Комплекс руки',

                    'img_preview' => '/media/services/nails/styles/комплекс-руки.png',
                    'img_popup' => '',
                    'img' => '',

                    'description' => 'текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст
                    текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст ',
                    'time' => '60',
                    'price' => '1400',
                ),
                'complex_leg' => array(
                    'name' => 'Комплекс ноги',

                    'img_preview' => '/media/services/nails/styles/комплекс-ноги.png',
                    'img_popup' => '',
                    'img' => '',

                    'description' => 'текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст
                    текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст ',
                    'time' => '60',
                    'price' => '1400',
                ),
                'cover' => array(
                    'name' => 'Покрытие ногтей',

                    'img_preview' => '/media/services/nails/styles/покрытие.png',
                    'img_popup' => '',
                    'img' => '',

                    'description' => 'текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст
                    текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст ',
                    'time' => '60',
                    'price' => '1400',
                ),
                'laminirovanie' => array(
                    'name' => 'Ламинирование',

                    'img_preview' => '/media/services/nails/styles/ламинирование.png',
                    'img_popup' => '',
                    'img' => '',

                    'description' => 'текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст
                    текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст ',
                    'time' => '60',
                    'price' => '1400',
                ),
                'narachevanie' => array(
                    'name' => 'Наращивание и укрепление',

                    'img_preview' => '/media/services/nails/styles/наращивание.png',
                    'img_popup' => '',
                    'img' => '',

                    'description' => 'текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст
                    текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст ',
                    'time' => '60',
                    'price' => '1400',
                ),
                'restore' => array(
                    'name' => 'Восстанавливающее покрытие',

                    'img_preview' => '/media/services/nails/styles/восстановление.png',
                    'img_popup' => '',
                    'img' => '',

                    'description' => 'текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст
                    текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст ',
                    'time' => '60',
                    'price' => '1400',
                ),
                'repair' => array(
                    'name' => 'Ремонт',

                    'img_preview' => '/media/services/nails/styles/ремонт.png',
                    'img_popup' => '',
                    'img' => '',

                    'description' => 'текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст
                    текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст ',
                    'time' => '60',
                    'price' => '1400',
                ),
                'design' => array(
                    'name' => 'Полировка и дизайн',

                    'img_preview' => '/media/services/nails/styles/полировка.png',
                    'img_popup' => '',
                    'img' => '',

                    'description' => 'текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст
                    текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст ',
                    'time' => '60',
                    'price' => '1400',
                ),
            ), */
        ),

        'men_care' => array(

            'styles_no_question' => '1',

            'styles' => array(
                'ysi' => array(
                    'name' => 'Усы',
                    'name_full' => 'Услуги для усов',
                    'description' => 'Усы, как их ни крути, интригуют и задерживают на себе внимание окружающих. Усы — такая штука, которую так просто не заиметь.',
                    'time' => '60',
                    'price' => '300',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'three_twelve',
                ),
                'boroda' => array(
                    'name' => 'Борода',
                    'name_full' => 'Услуги для бороды',
                    'description' => 'Проблема правильного ухода за бородой остро встает перед многими мужчинами, отпустившими ее, чтобы перестать ежедневно бриться, а также обращать внимание на состояние кожи лица.',
                    'time' => '60',
                    'price' => '300',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'three_twelve',
                ),
                'sedina' => array(
                    'name' => 'Тонирование седины',
                    'name_full' => 'Тонирование седины',
                    'description' => 'Каждый мужчина, который столкнулся с такой проблемой, как седина, может воспользоваться любым из множества средств, предназначенных для её устранения.',
                    'time' => '60',
                    'price' => '1500',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'three_twelve',
                ),
                'epilaciya' => array(
                    'name' => 'Эпиляция',
                    'name_full' => 'Эпиляция',
                    'description' => 'Технически удаление нежелательных волос с кожи тела у мужчин и у женщин ничем не отличается. А вот техники, которые помогают мужчинам избавиться от растительности на теле чаще всего совсем другие.',
                    'time' => '60',
                    'price' => '3000',
                    'preview_type' => 'full',
                    'preview_text_post' => 'left-bottom',
                    'preview_column' => 'three_twelve',
                ),
            ),
        ),
    );

    private $salons, $services;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->library('session');
        $this->load->library('pluralform');
        $this->load->model('SeoModel');
        $this->load->model('ServicesModel');
        $this->load->model('SalonsModel');
        $this->load->model('BlocksModel');
        $this->salons = $this->SalonsModel->getSalons('opened');
        $this->services = $this->ServicesModel->getServices();
    }

    public function index()
    {
        $salon = $this->SalonsModel->getSalon('default');
        $this->load->view('_head', array('seo' => $this->SeoModel->getSeo('home'), 'assets' => 'main', 'salon' => $salon));
        $this->load->view('_header', array('salons' => $this->salons));
        // Loading home data
        $home_block = $this->BlocksModel->getBlockData('home');
        $home_block['count'] = count($this->salons) . ' ' . $this->pluralform->getPluralForm(count($this->salons), 'салон', 'салона', 'салонов');
        $this->load->view('home', $home_block);
        // Loading salons big grid
        $this->load->view('_salons-big', array('salons' => $this->salons));
        // Loading services small grid
        $this->load->view('_services-small', array('services' => $this->services));
        // Loading about salon block
        $about_block = $this->BlocksModel->getBlockData('_about');
        if ($about_block && is_array($about_block)) {
            $this->load->view('_about', $about_block);
        }
        // Loading Yandex Map and salons
        $this->load->view('_map', array('salons' => $this->salons));
        $privacy_block = $this->BlocksModel->getBlockData('privacy-policy');
        $this->load->view('_footer', array('privacy_block' => $privacy_block));
        $this->load->view('_foot');
    }

    public function view($key, $key2 = null)
    {
        //TODO if both key null 404
        if ($key2 == null) { // If key2 is null then we must load salon or service
            // Trying to get salon by slug
            $salon = $this->SalonsModel->getSalon($key, 'opened', false);
            if ($salon) { // If such salon exist - load salon views
                $this->load->view('_head', array('seo' => $this->SeoModel->getSalonSeo($salon), 'assets' => 'salon', 'salon' => $salon));
                $this->load->view('_header', array('salons' => $this->salons));
                $salon_block = $this->BlocksModel->getBlockData('salon');
                $this->load->view('salon', array('salon' => $salon, 'salon_block' => $salon_block));
                // Loading services big grid
                $this->load->view('_services-big', array('services' => $this->services, 'salon_slug' => $salon['slug']));
                // Loading about salon block
                $about_block = $this->BlocksModel->getBlockData('_about');
                $about_block['salon_slug'] = $salon['slug'];
                if ($about_block && is_array($about_block)) {
                    $this->load->view('_about', $about_block);
                }
                $masters = $this->BlocksModel->getBlockData('_masters');
                $this->load->view('_masters', array('salon' => $salon, 'block' => $masters));
                // Loading Yandex Map and salons
                $this->load->view('_map', array('salons' => $this->salons));
                $privacy = $this->BlocksModel->getBlockData('privacy-policy');
                $this->load->view('_footer', array('privacy_block' => $privacy));
                $this->load->view('_foot');
            } else {
                // Trying to get service by slug
                $service = $this->ServicesModel->getService($key);
                //TODO Create $_GET variation
                if ($service) { // If such service exist - load service views
                    //Get default salon data to fill
                    $salon = $this->SalonsModel->getSalon('default');
                    $this->loadService($service, $salon, $_GET);
                } else {
                    // TODO 404 error
                    echo 'whooops no such data';
                }
            }
        } else {
            // if both keys exist check them for existense and load service page with salon integration
            $salon = $this->SalonsModel->getSalon($key, 'opened', true);
            $service = $this->ServicesModel->getService($key2);
            if ($salon && $service) {
                $this->loadService($service, $salon, $_GET);
            } else {
                // TODO 404 error
                echo 'whooops no such data';
            }
        }
    }

    private function loadService($service, $salon, $get)
    {
        $service_block = $this->BlocksModel->getBlockData('service');
        // Load service styles
        $styles = $this->ServicesModel->getStyles($service['slug']);

        $this->load->view('_head', array('seo' => $this->SeoModel->getServiceSeo($service), 'assets' => 'service', 'assets_service' => $service['slug'], 'salon' => $salon));
        $this->load->view('_header', array('salons' => $this->salons));
        if (isset($styles) && isset($get) && array_key_exists('sub', $get)) {
            $key = array_search($_GET['sub'], array_column($styles, 'slug'));
            if (isset($key)) {
                $service['name'] = $styles[$key]['name'];
            }
        }
        $this->load->view('service', array('service' => $service, 'salon' => $salon, 'block' => $service_block));
        if (isset($styles) && isset($get) && array_key_exists('sub', $get)) {
            $key = array_search($_GET['sub'], array_column($styles, 'slug'));
            if (isset($key)) {
                $this->load->view('_styles-small', array('styles' => $styles, 'service' => $service, 'style' => $styles[$key]));
            }
        } else {
            $need_help_block = $this->BlocksModel->getBlockData('need-help');
            $this->load->view('_styles', array('styles' => $styles, 'service' => $service, 'need_help_block' => $need_help_block));
        }

        // Load 2 principles of PERSONA
        $service_principles = $this->BlocksModel->getBlockData('_principles');
        $this->load->view('_principles', array('slug' => $service['slug'], 'block' => $service_principles));
        // First offer
        $offer = $this->BlocksModel->getBlockData('_offer');
        $this->load->view('_offer', array('block' => $offer));
        // Loading about salon block
        $about_block = $this->BlocksModel->getBlockData('_about');
        $about_block['salon_slug'] = $salon['slug'];
        if ($about_block && is_array($about_block)) {
            $this->load->view('_about', $about_block);
        }
        if ($salon['slug'] != 'default') {
            $masters = $this->BlocksModel->getBlockData('_masters');
            $this->load->view('_masters', array('salon' => $salon, 'block' => $masters));
        }
        // Second offer
        $offer_q = $this->BlocksModel->getBlockData('_offer-q');
        $this->load->view('_offer-q', array('block' => $offer_q));
        // Load small services grid
        $this->load->view('_services-small', array('services' => $this->services));
        // Load Yandex Map and salons
        $this->load->view('_map', array('salons' => $this->salons));
        $privacy = $this->BlocksModel->getBlockData('privacy-policy');
        $this->load->view('_footer', array('privacy_block' => $privacy));
        $this->load->view('_foot');
    }

    private function formatToTelegram($message)
    {
        return '*Заявка с Промо*' . $message;
    }

    private function telegramMessage($message)
    {
        $token = '';
        //$chat_id = '';
        $chat_id = '';
        $proxy = '';
        $auth = '';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot' . $token . '/sendMessage');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'chat_id=' . $chat_id . '&text=' . urlencode($message) . '&parse_mode=Markdown');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $auth);
        curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_exec($ch);
        curl_close($ch);
    }

    public function addLead()
    {
        if (isset($_POST)) {
            $this->load->model('LeadsModel');
            if ($this->LeadsModel->addLead($_POST)) {
                echo json_encode(array('status' => 'ok'));
            }
            $this->load->library('email');
            $message = '';
            foreach ($_POST as $key => $value) {
                $message .= PHP_EOL . '*' . $this->getEmailField($key) . ':* ' . $value;
            }

            $config['protocol'] = 'smtp';
            $config['smtp_host'] = '';
            $config['smtp_user'] = '';
            $config['smtp_pass'] = '';
            $config['smtp_port'] = 465;
            $config['smtp_crypto'] = 'ssl';
            $config['mailtype'] = 'html';
            $this->email->initialize($config);
            $this->email->from('', 'Admin');
            $this->email->to('');
            $this->email->subject('★★★ Персона: Заявка ★★★');
            $this->email->message($message);
            $this->email->send();

            $this->telegramMessage($this->formatToTelegram($message));
            exit();
        } else {
            echo json_encode(array('status' => 'fail'));
            exit();
        }
    }

    private function getEmailField($name)
    {
        switch ($name) {
            case 'about':
                return 'О проекте';
            case 'name':
                return 'Имя';
            case 'tel':
                return 'Телефон';
            case 'url':
                return 'URL';
            case 'file':
                return 'Файл во вложении';
            case 'salon':
                return 'Салон';
            case 'service':
                return 'Услуга';
            case 'style':
                return 'Подуслуга';
            default:
                return 'undefined';
        }
    }
}
