define(['directives/module'], function (directives) {
  directives.directive('searchhit', function () {
     return {
         restrict: 'E',
         scope: true,
         template: '<span class="property">' +
             '<strong ng-if="label">{{ label }}: </strong>' +
             '<span ng-bind-html="content | highlight:searchResults[searchResultsIndex].responseHeader.params.searchtext"></span></span>',
         link: function(scope, element, attrs) {
             var abbrToTitle = function (title) {
                 var abbr2title = {
                     'kuenstler': 'Künstler',
                     'archivnr': 'Archivnummer',
                     'material_technik': 'Material/Technik',
                 };
                 if (title in abbr2title)
                     return abbr2title[title];
                 if (title.startsWith('beschreibung')) {
                     title = title.slice(13);
                 }

                 return title.replace('_', ' ').replace(/\b(\w)/g, function(s) { return s.toUpperCase(); }).replace(' ', '/');

             };

             var attr2string = function (attribute) {
                 if (attribute.constructor === Array) {
                     return attribute.join(' , ');
                 }
                 return attribute;
             };

             if (attrs['content'] == 'standort') {
                 scope.content = [
                     scope.hit['standort'],
                     scope.hit['herkunft'],
                     scope.hit['bundesland'],
                     scope.hit['staat'],
                 ];
                 scope.content = scope.content
                     .filter(Boolean)
                     .map(attr2string)
                     .join(", ");
                 if (('label' in attrs) && !(scope.content === undefined)) {
                     scope.label = 'Standort'
                 }
             } else if (attrs['content'] == 'beschreibung') {
                 scope.content = '';
                 for (var key in scope.hit) {
                     if (key.startsWith('beschreibung')) {
                         scope.content += '<span class="property"><strong>' + abbrToTitle(key) + ': </strong>' +
                             scope.hit[key].join(', ') + '</span>';
                     }
                 }
             } else if (attrs['content'] == 'body') {
                 scope.content = [
                     scope.hit['kuenstler'],
                     scope.hit['objekt'],
                     scope.hit['objektgruppe'],
                     scope.hit['material_technik'],
                     scope.hit['institution'],
                 ];
                 scope.content = scope.content
                     .filter(Boolean)
                     .map(attr2string)
                     .join(" | ");
             } else {
                 if (!(scope.hit[attrs['content']] === undefined)) {
                     scope.content = attr2string(scope.hit[attrs['content']]);
                     if (('label' in attrs) && !(scope.content === undefined)) {
                         scope.label = abbrToTitle(attrs['content']);
                     }
                 }
             }
         }
     };
  });
});