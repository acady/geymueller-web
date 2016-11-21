define(['filters/module'], function (filters) {
  filters.filter('ampersandhtml', function() {

      return function (input) {
          //console.log("AMP Filter: " + input.replace(/&amp;/g, '&'));
          return input ? input.replace(/&amp;/g, '&') : '';
      }
  });
});

