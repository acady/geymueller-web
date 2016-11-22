define(['directives/module'], function (directives) {
  directives.directive('pathview',[ '$window', '$http','$q', '$uibModal', '$sce', 'Notification', 'productservice', 'dataservice', 'config', function($window, $http, $q, $uibModal, $sce, Notification, productservice, dataservice, config){
    return {
          restrict: 'E',
          templateUrl: '/pathview.html',
          scope: {
            hit: '=',
            data: '='
          },
          link: function(scope, element, attrs){
            
            scope.titleCollapsed = false;
            
            scope.toggleTitleCollapsed = function(){
              scope.titleCollapsed = !scope.titleCollapsed;
            };
            scope.toggleSexCollapsed = function(){
                scope.sexCollapsed = !scope.sexCollapsed;
            };
              scope.toggleStandCollapsed = function(){
                  scope.standCollapsed = !scope.standCollapsed;
              };
              scope.toggleGestusCollapsed = function(){
                  scope.gestusCollapsed = !scope.gestusCollapsed;
              };
              scope.toggleFormCollapsed = function(){
                  scope.formCollapsed = !scope.formCollapsed;
              };
              scope.toggleFarbeCollapsed = function(){
                  scope.farbeCollapsed = !scope.farbeCollapsed;
              };
              scope.toggleMaterialCollapsed = function(){
                  scope.materialCollapsed = !scope.materialCollapsed;
              };
              scope.toggleTextCollapsed = function(){
                  scope.textCollapsed = !scope.textCollapsed;
              };

              var graph = scope.data.description;
              var deferred = $q.defer();
              var graphRoot = [];
              var graphRoots = [graphRoot];
              var promises = [];
              var levels = [];
              var expandedNodes = [];
              var lastLevel = 0;
              _.each(graph.tree, function(treeEntry, tmpIndex){
                var index = treeEntry[0];
                var level = treeEntry[1];
                
                levels[tmpIndex] = level;
                
                var entity = graph.entities[index];
                
                var newEntry = [];
                promises.push(dataservice.getData(entity, undefined, scope.data));
              });
              
              $q.all(promises).then(function(results){
                  
                  _.each(results, function(result, index){
                      
                      var level = levels[index];
                      
                      var newEntry = result;
                      
                      if(level > lastLevel) {
                          var parentLevel = graphRoots[level-1];
                          var parentElement = parentLevel[parentLevel.length - 1];
                          if(!parentElement.children){
                              parentElement.children = [];
                          }
                          parentElement.children.push(newEntry);
                          graphRoots[level] = parentElement.children;
                          expandedNodes.push(parentElement);
                      } else {
                          graphRoots[level].push(newEntry);
                      }
                      lastLevel = level;
                  });
                  
              });

              
              scope.treedata = graphRoot;

              scope.expandedNodes = expandedNodes;

            scope.trustAsHtml = function(html) {
              return $sce.trustAsHtml(html);
            };
            
            scope.showSelected = function(sel) {
              scope.selectedNode = sel;
                // das mÃƒÆ’Ã‚Â¼sste die View mit springen
                /*
                */

                console.log("spring!");

                // baum wo ist ganz oben und ganz unte --> max min

            };


            // https://api.jquery.com/scroll/
            // https://api.jquery.com/scrollTop/
          $( window ).scroll(function() {
              // https://api.jquery.com/scrollTop/
              //$( "span" ).css( "display", "inline" ).fadeOut( "slow" );

              //console.log('now');

              // scropp top wert suchen und einsetzen
          });
            
          }
      };
      
    }]);
});