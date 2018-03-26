define(['services/module'], function (services) {
  services.service('imageservice',[ function(){
    var startUrlPart = '/content/themes/singlepage-pro/images/content/';
    return {
      retrieveDziImageUrl: function(hit){
          if(hit && hit['dianr']) {
            return startUrlPart + 'Deepzoom=/' + hit['dianr'][0] + '.tif.dzi';
          }
          return '';
      },
      retrieveImageUrl: function(hit, size) {
          if(hit && hit.id && hit.Inventarnummer) {
              var id = ('0000' + hit.id).slice(-4);
              return startUrlPart + id + '.jpg';
          }
          return '';
        }
      };
    }]);
});