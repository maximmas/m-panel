new Vue({
  el: '#app',
  data() {
    return {

      options: mp_options_data.options,

      menu_items: [
        "Активные купоны",
        "Архив купонов",
        "Импорт",
        "Рекламный блок",
        "Шаблоны"
      ],
      active: null,
      is_saving: false,
      message: '',

      coups_min: 2,
      coups_max: 20,
      ad_min: 1,
      ad_max: 5,

      is_saved: false,
      y: 'bottom',
      x: null,
      mode: '',
      timeout: 6000,
    }
  },
  methods: {
    addValue: function (e) {
      this.colors.push(e.target.value)
    },
    next() {
      const active = parseInt(this.active)
      this.active = (active < 3 ? active + 1 : 0)
    },
    onSave: function () {
      this.is_saving = true;

      jQuery.ajax({
        url: mp_options_data.siteUrl + '/wp-json/mp/v2/options',
        method: 'POST',
        data: this.options,
        beforeSend: function (request) {
          request.setRequestHeader('X-WP-Nonce', mp_options_data.nonce);
        },
        success: () => {
          this.message = 'Сохранено !';
          this.is_saved = true;
        },
        error: (data) => this.message = data.responseText,
        complete: () => this.is_saving = false,
      });
    }
  },
  created() {
    setTimeout(function () {
      jQuery('#preloader').css('display', 'none');
    }, 1000);


  }
})