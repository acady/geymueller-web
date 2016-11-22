define(['directives/module'], function (directives) {
  directives.directive('antepostfacet', [ '$timeout', 'facetservice', function ($timeout, facetservice) {
     return {
          restrict: 'E',
          require: '^^search',
          templateUrl: '/antepostfacet.html',
          scope: {
            currentSearch: '=',
            searchResult: '=',
            min: '=',
            max: '=',
            selectedFacets: '='
          },
          link: function(scope, element, attrs, search){
            
            search.registerFacetField('post', 'Post');
            search.registerFacetField('ante', 'Ante');

            // Not working
            //scope.facetTitle = search.retrieveFacetTitle('post') + ' ' + search.retrieveFacetTitle('ante');
            scope.facetTitle = "Datierung";
            var init = function(){

              scope.antepostfacetconfig = {};
              
              scope.sliderOptions = {
                      floor: scope.min,
                      ceil: scope.max
                    };
              scope.antepostfacetconfig.post = scope.min;
              scope.antepostfacetconfig.ante = scope.max;
              
              var exactmatch = false;
              var post;
              var ante;
              if(scope.currentSearch.selectedFacets.post){
                var keys = Object.keys(scope.currentSearch.selectedFacets.post);
                _.each(keys, function(key){
                  post = key;
                  if(key.match(/^\d$/)){
                    exactmatch = true;
                  }
                });
              }
              if(scope.currentSearch.selectedFacets.ante){
              keys = Object.keys(scope.currentSearch.selectedFacets.ante);
                _.each(keys, function(key){
                  ante = key;
                  if(key.match(/^\d$/)){
                    exactmatch = true;
                  }
                });
              }
              scope.antepostfacetconfig.exactmatch = exactmatch;
              
              if(scope.antepostfacetconfig.exactmatch){
                scope.antepostfacetconfig.exactpost = post;
                scope.antepostfacetconfig.exactante = ante;
              }else{
                var mode = 'contain';
                if(post){
                  var splittedPost = post.split(" ");
                  scope.antepostfacetconfig.post = splittedPost[0];
                  mode = splittedPost[3];
                }
                if(ante){
                  var splittedAnte = post.split(" ");
                  scope.antepostfacetconfig.ante = splittedAnte[2];
                  mode = splittedAnte[3];
                }
                if(mode !== 'contain'){
                  if(mode === 'Enthalten'){
                    mode = 'contain';
                  }else{
                    mode = 'overlap';
                  }
                }
                scope.antepostfacetconfig.mode = mode;
              }
              
            };
            init();
            
            scope.exactmatchChanged = function(){
              scope.currentSearch.selectedFacets.post = {};
              scope.currentSearch.selectedFacets.ante = {};
              scope.antepostfacetconfig.mode = 'contain';
            };
            
            var setAntePost = function(){
              
              if(scope.antepostfacetconfig.exactmatch || (scope.antepostfacetconfig.post === scope.min && scope.antepostfacetconfig.ante === scope.max)) {
                return;
              }
              
              var post = scope.antepostfacetconfig.post;
              if(!post){
                post = scope.min;
              }
              var ante = scope.antepostfacetconfig.ante;
              if(!ante){
                ante = scope.max;
              }
              scope.currentSearch.selectedFacets.post = {};
              scope.currentSearch.selectedFacets.ante = {};
              if(scope.antepostfacetconfig.mode === 'contain') {
                facetservice.toggleFacetValue(scope.currentSearch.selectedFacets, 'post', post + ' - ' + ante + ' Enthalten');
                facetservice.toggleFacetValue(scope.currentSearch.selectedFacets, 'ante', post + ' - ' + ante + ' Enthalten');
              }else{
                facetservice.toggleFacetValue(scope.currentSearch.selectedFacets, 'post', post + ' - ' + ante + ' ÃƒÅ“berschneiden');
                facetservice.toggleFacetValue(scope.currentSearch.selectedFacets, 'ante', post + ' - ' + ante + ' ÃƒÅ“berschneiden');
              }
              
            };
            
            scope.$watch('antepostfacetconfig.post', setAntePost);
            
            scope.$watch('antepostfacetconfig.ante', setAntePost);
            
            scope.$watch('searchResult.facet_counts.facet_ranges.ante', function(ante){
                var labels = [];
                var data = [];
                if(ante && ante.counts){
                  _.each(ante.counts, function(element, index){
                    if(index % 2 === 0){
                      var from = parseInt(element);
                      var to = from + ante.gap;
                      if(to > ante.end) {
                        to = ante.end;
                      }
                      labels.push(from + ' - ' + to );
                    } else {
                      data.push(element);
                    }
                  });
                }
                scope.labels = labels;
                scope.data = [data];
                scope.colors = [{
                  fillColor: 'rgba(47, 132, 71, 0.8)',
                  strokeColor: 'rgba(47, 132, 71, 1)',
                  highlightFill: 'rgba(149, 8, 72, 0.5)',
                  highlightStroke: 'rgba(149, 8, 72, 1)'      // primary color
                }];

              scope.chartOptions = {
                legend: {
                  display: false
                },
                scales: {
                  yAxes: [{
                    display: false
                  }]
                },
                tooltips: {
                  enabled: true,
                  mode: 'single',
                  callbacks: {
                    label: function(tooltipItem, data) {
                      var label = data.labels[tooltipItem.index];
                      var datasetLabel = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                      return datasetLabel + ' Werke';
//                      return label + ' ' + datasetLabel + 'Werke';
                    }
                  }
                },
              };


              /*{
                //Boolean - Show a backdrop to the scale label
                scaleShowLabelBackdrop : true,
                //Boolean - Whether to show labels on the scale
                scaleShowLabels : true,
                // Boolean - Whether the scale should begin at zero
                scaleBeginAtZero : true,
                scaleLabel : "<%%= Number(value) + ' %'%>",
                legendTemplate: "<ul class=\"<%%=name.toLowerCase()%>-legend\"><%% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%%=datasets[i].strokeColor%>\"></span><%%if(datasets[i].label){%><%%=datasets[i].label%> <strong><%%=datasets[i].value%></strong><%%}%></li><%%}%></ul>",
                //tooltipTemplate: "<%%= value %> Label",
                multiTooltipTemplate: "<%%=datasetLabel%> <%%= value %>"

              }*/
                /*
                {
                  label: "My First dataset",
                  fillColor: "rgba(220,220,220,0.5)",
                  strokeColor: "rgba(220,220,220,0.8)",
                  highlightFill: "rgba(220,220,220,0.75)",
                  highlightStroke: "rgba(220,220,220,1)",
                  data: [20, 59, 80]
                }*/
            });
            
            scope.modeChanged = function() {
                setAntePost();
                search.updateQuery();
              };
            
            scope.$watch('antepostfacetconfig.exactpost', function(){
              scope.currentSearch.selectedFacets.post = {};
              if(scope.antepostfacetconfig.exactpost){
                facetservice.toggleFacetValue(scope.currentSearch.selectedFacets, 'post', scope.antepostfacetconfig.exactpost);
              }
            });
            
            scope.$watch('antepostfacetconfig.exactante', function(){
              scope.currentSearch.selectedFacets.ante = {};
              if(scope.antepostfacetconfig.exactante){
                facetservice.toggleFacetValue(scope.currentSearch.selectedFacets, 'ante', scope.antepostfacetconfig.exactante);
              }
            });
            
          }
      };
  }]);
});