import intlTelInput from 'intl-tel-input';

(async () => {
  // Alpine js
  import('alpinejs');

  const input = document.querySelector('.phone');
  window.iti = intlTelInput(input, {
    // any initialisation options go here
    utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.min.js',
    initialCountry: 'GB',
    geoIpLookup: function (callback) {
      fetch('https://ipinfo.io/json?token=ddd53ae6648a61').then(
        (response) => response.json()
      ).then(
        (jsonResponse) => {
          callback(jsonResponse.country);
          input.dataset.ip = jsonResponse.ip;
        }
      )
    }
  });
})();