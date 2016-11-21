define(['directives/module'], function (directives) {
  directives.directive('taggedview', [ '$window', '$http','$q', '$uibModal', '$sce', '$timeout', 'Notification', 'productservice', 'dataservice', 'imageservice',  function($window, $http, $q, $uibModal, $sce, $timeout, Notification, productservice, dataservice, imageservice){
    return {

        restrict: 'E',
        templateUrl: '/taggedview.html',
        scope: {
          hit: '=',
          data: '='
        },
        link: function(scope, element, attrs){
            scope.retrieveImageUrl = function(hit){
                $timeout(function() {
                    scope.imagewidth = element.find('img').width()
                    scope.imageheight = element.find('img').height()
                });
                return imageservice.retrieveImageUrl(hit, 1000);
            };
            
            var graph = scope.data.description;
            var deferred = $q.defer();

            //var graphRoot = [];
            var graphRoots = [];
            var expandedNodes = [];
            var lastLevel = 0;
            _.each(graph.tree, function(treeEntry){
                var index = treeEntry[0];
                var level = treeEntry[1];
                var entity = graph.entities[index];
                // diese new entries werden angezeigt
                //console.log (entity);
                var newEntry = [];
                dataservice.getData(entity, undefined, scope.data).then(function(result){
                    newEntry = result;
                    //console.log(newEntry);
                    graphRoots.push(newEntry);
                });
            });
              
            // graphRoot verwenden
            scope.taggedtreedata = graphRoots;
            // console.log(graphRoots);
            scope.expandedNodes = _.uniq(expandedNodes);
            
            scope.trustAsHtml = function(html) {
                return $sce.trustAsHtml(html);
            };
            
            scope.showSelected = function(sel) {
                scope.selectedNode = sel;
                // das mÃƒÆ’Ã‚Â¼sste die View mit springen
                console.log("spring!");
                // baum wo ist ganz oben und ganz unte --> max min
            };

            // https://api.jquery.com/scroll/
            // https://api.jquery.com/scrollTop/
            $( window ).scroll(function() {
                // https://api.jquery.com/scrollTop/
                //$( "span" ).css( "display", "inline" ).fadeOut( "slow" );
                console.log('now');

                // scropp top wert suchen und einsetzen
            });

              scope.hoverIn = function(node){
                  node.hoverEdit = true;
              };

              scope.hoverOut = function(node){
                node.hoverEdit = false;
              };
              
              scope.retrieveTop = function(node) {
                if(node.hoverEdit){
                    if(node.tagRect.y1) {
                        //return (Math.abs(node.tagRect.y2 - node.tagRect.y1) * scope.imageheight) / 2;
                        return (Math.abs(node.tagRect.y1) * scope.imageheight);

                    } else{
                        return node.tagPoint.y * scope.imageheight - 15;
                    }
                }else{
                  return node.tagPoint.y * scope.imageheight - 15;
                }
              };
              
              scope.retrieveLeft = function(node) {
                if(node.hoverEdit){
                    if(node.tagRect.x1) {
//                        return (Math.abs(node.tagRect.x2 - node.tagRect.x1) * scope.imagewidth) / 2;
                        return (Math.abs(node.tagRect.x1) * scope.imagewidth);

                    } else{
                        return node.tagPoint.x * scope.imagewidth;
                    }
                }else{
                    return node.tagPoint.x * scope.imagewidth;
                }
              };


            scope.retrieveTopInfo = function(node) {
                if(node.hoverEdit){
                    if(node.tagRect.y1) {
                        //return (Math.abs((node.tagRect.y2 - node.tagRect.y1) * scope.imageheight) - (node.tagRect.y2 * scope.imageheight));
                        return -3;
                    } else{
                        //return (node.tagPoint.y * scope.imageheight - 15);
                        return -3;
                    }
                }else{
                    //return (node.tagPoint.y * scope.imageheight - 15);
                    return -3;
                }
            };

            scope.retrieveRightInfo = function(node) {
                if(node.hoverEdit){
                    if(node.tagRect.x1) {
                        return (Math.abs(node.tagRect.x2) * scope.imagewidth + 4);
                    } else{
                        return 34;
                    }
                }else{
                    //return node.tagPoint.x * scope.imagewidth;
                    return 34;
                }
            };

              scope.retrieveWidth = function(node) {
                if(node.hoverEdit) {
                    if(node.tagRect.x1){
                        //return Math.abs(node.tagRect.x2 - node.tagRect.x1) * scope.imagewidth;
                        // Achtung Y2 ist die height X2 ist die width
                        return Math.abs(node.tagRect.x2) * scope.imagewidth;
                    } else {
                        return 30;
                    }
                }else{
                  return 30;
                }
              };
              
              scope.retrieveHeight = function(node) {
                if(node.hoverEdit) {
                    if(node.tagRect.y1){
//                        return Math.abs(node.tagRect.y2 - node.tagRect.y1) * scope.imageheight;
                        return Math.abs(node.tagRect.y2) * scope.imageheight;

                    } else {
                        return 30;
                    }
                }else{
                  return 30;
                }
              };
              
              scope.retrieveBorderWidth = function(node) {
                if(node.hoverEdit) {
                  return 2;
                }else{
                  return 2;
                }
              };
            scope.retrieveBorderRadius = function(node) {
                if(node.hoverEdit) {
                    return 3;
                }else{
                    return 15;
                }
            };
              
          }
        };
    }]);
});