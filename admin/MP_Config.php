<?php
/**
 * Default data
 * 
 */
trait MP_Config{

    private $options_name;
    private $menu_name;
    private $default_options;
    // private $page_template;

      
    public function config_init(){
      
      
      /**
       * Options name
       */
      $this->options_name = "mt-demo-options";

      /**
        * Menu name
        */
      $this->menu_name    = "MP Demo Settings";
      
      /**
       * Default options values
       */
      $this->default_options = [

        'active_title'            => 'Действующие купоны %%this_month%% - %%next_month%% / %%year%%',
        'active_modal_shortcode'  => '[cp_popup][/cp_popup]',
        'active_to_show'          => 4,

        'archive_title'           => 'Завершившиеся акции, скидки, промокоды',
        'archive_to_show'         => 5,
        'archive_to_load'         => 10,

        'import_xml_admitad'      => 'http://export.admitad.com/',
        'import_xml_actionpay'    => 'https://actionpay.com/xml/',

        'text_default_admitad'    => 'Идейные соображения высшего порядка, а также дальнейшее развитие различных форм деятельности способствует подготовке и реализации системы массового участия.',
        'text_default_actionpay'    => 'Предварительные выводы неутешительны: понимание сути ресурсосберегающих технологий обеспечивает актуальность распределения внутренних резервов и ресурсов.',

        'advert_to_show'          => true,
        'advert_after'            => 2,
        'advert_shortcode'        => '[cp_popup][/cp_popup]',
        
      ];

    }
}