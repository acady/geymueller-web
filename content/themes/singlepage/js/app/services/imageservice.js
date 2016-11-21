define(['services/module'], function (services) {
  services.service('imageservice',[ function(){
    var startUrlPart = 'http://cf000036.sbg.ac.at/iipsrv/iipsrv.fcgi?';
    return {
      retrieveDziImageUrl: function(hit){
          if(hit && hit['dianr']) {
            return startUrlPart + 'Deepzoom=/' + hit['dianr'][0] + '.tif.dzi';
          }
          return '';
      },
      retrieveImageUrl: function(hit, size) {
          if(hit && hit['dianr']) {
              return startUrlPart + 'FIF=/' + hit['dianr'][0] + '.tif&WID=' + size + '&HEI=' + size + '&CVT=JPG';
          }
          return '';
        }
      }
    }]);
});