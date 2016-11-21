define(['directives/module'], function (directives) {
  directives.directive('pathview',[ '$window', '$http','$q', '$uibModal', '$sce', 'Notification', 'productservice', 'dataservice', function($window, $http, $q, $uibModal, $sce, Notification, productservice, dataservice){
    return {
          restrict: 'E',
          templateUrl: '/pathview.html',
          link: function(scope, element, attrs){
            
            //$http.get("/content/themes/imareal/js/app/controllers/d3/realien.json").success(function(graph){
            $http.get("http://cf000044.sbg.ac.at/api/data/work?apiKey=9rkWCL6e86&detail=true&archivnr=" + scope.hit.archivnr).success(function(graph){
                  graph = graph.description;
                    var deferred = $q.defer();

                    var graphRoot = [];
                  var graphRoots = [graphRoot];
                  var expandedNodes = [];
                  var lastLevel = 0;
                  _.each(graph.tree, function(treeEntry){
                    var index = treeEntry[0];
                    var level = treeEntry[1];
                    var entity = graph.entities[index];
                    // diese new entries werden angezeigt
                      //console.log ('Pathview');
                      //console.log (entity);
                    var newEntry = [];
                    dataservice.getData(entity).then(function(result){
                        //console.log(result);
                        /*deferred.resolve({
                             label: entity.id, type: entity.type, number: result.number ,
                             title: result.title, sex: result.sex , stand: result.stand ,
                             gestus: result.gestus, form: result.form , farbe: result.farbe , material: result.material ,
                             text: result.text, data_title: result.data_title ,
                             data_sex: result.data_sex ,data_stand: result.data_stand ,
                             data_gestus: result.data_gestus , data_farbe: result.data_farbe ,
                             data_form: result.data_form , data_material: result.data_material ,
                             data_text: result.data_text , group: result.group
                        });
                        */
                        newEntry = result;
                        //console.log(newEntry);
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
                  
                  // graphRoot verwenden
                  scope.treedata = graphRoot;

                  scope.expandedNodes = _.uniq(expandedNodes);
            });
            
            scope.trustAsHtml = function(html) {
              return $sce.trustAsHtml(html);
            };
            
            scope.showSelected = function(sel) {
              scope.selectedNode = sel;
                // das müsste die View mit springen

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