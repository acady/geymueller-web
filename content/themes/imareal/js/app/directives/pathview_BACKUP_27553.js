define(['directives/module'], function (directives) {
  directives.directive('pathview',[ '$window', '$http','$q', '$uibModal', '$sce', 'Notification', 'productservice', 'dataservice', function($window, $http, $q, $uibModal, $sce, Notification, productservice, dataservice){
    return {
          restrict: 'E',
          templateUrl: '/pathview.html',
          link: function(scope, element, attrs){
            
            $http.get("http://cf000044.sbg.ac.at/api/data/work?apiKey=9rkWCL6e86&detail=true&archivnr=" + scope.hit.archivnr).success(function(graph){
                  graph = graph.description;
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
                    promises.push(dataservice.getData(entity));
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
            });
            
            scope.trustAsHtml = function(html) {
              return $sce.trustAsHtml(html);
            };
            
            scope.showSelected = function(sel) {
              scope.selectedNode = sel;
<<<<<<< HEAD
                // das müsste die View mit springen

=======
                // das mÃƒÂ¼sste die View mit springen
>>>>>>> 6a42fbc288669e3acb555a9c891bf85d5fc9ba4f
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