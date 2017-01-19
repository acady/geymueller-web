define(['filters/module'], function (filters) {
  filters.filter('highlight', [ '$sce', function($sce) {
      return function(text, phrase) {
          if(text){
            text = text.toString();
          }
          if (phrase) {
            var phrases = phrase.split(' ');
            _.each(phrases, function(entry){
                if(text) {
                  text = text.replace(new RegExp('('+entry+')', 'gi'), '<span class="highlighted">$1</span>');
                }
            });
          }
          return $sce.trustAsHtml(text);
        };
      }]);
});