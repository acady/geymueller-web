define(['controllers/module', 'openseadragon', 'd3'], function (controllers, openseadragon, d3) {

  controllers.controller(
    'GraphController',
    ['$scope', '$q', '$http', '$timeout', 'hit', 'data', 'dataservice',
      function ($scope, $q, $http, $timeout, hit, data, dataservice) {

        $timeout(function () {
          var d3Graph = angular.element('.d3-graph');

          //d3.select(d3Graph[0]).append('svg');


          var svg = d3.select(d3Graph[0]).append('svg'),
            width = +svg.attr("width");
            height = +svg.attr("height");

          var width_ext = 800;
          var width_ext_legend = 800;
          var height_ext = 500;

          var color = d3.scaleOrdinal(d3.schemeCategory20);

          var nodes_radius = 8;

          var simulation = d3.forceSimulation()
            .force("link", d3.forceLink().id(function (d) {
              return d.id;
            }))
            .force("charge", d3.forceManyBody())
            .force("center", d3.forceCenter(width_ext / 2, height_ext / 2));

          graph = data.description;

          // Data Parser

          var graph_parse_relations = graph.relations.map(function (d) {
            return {
              source: d[0],
              target: d[1]
            };
          });

          var graph_parse_entities_promises = graph.entities.map(function (d, i) {
            return dataservice.getData(d, i, data);
          });

          $q.all(graph_parse_entities_promises).then(function (graph_parse_entities_list) {

            var graph_parse_entities = [];
            _.each(graph_parse_entities_list, function (element, index) {
              graph_parse_entities.push(element);
            });

            // ? //
            root = graph_parse_entities[0];
            root.x = width / 2;
            root.y = height / 2;
            root.fixed = true;


            //console.log(graph_parse_entities);

            //console.log(graph_parse_relations);
            //console.log(graph.relations);


            var myTool = d3.select("body")
              .append("div")
              .attr("class", "mytooltip")
              .style("opacity", "0")
              .style("display", "none");

            var link = svg.append("g")
              .attr("class", "links")
              .selectAll("line")
              //.data(graph.relations)
              .data(graph_parse_relations)
              .enter().append("line")
              .attr("stroke-width", function (d) {
                return Math.sqrt(d.value);
              });

            var node = svg.append("g")
              .attr("class", "nodes")
              .selectAll("circle")
              //.data(graph.entities)
              .data(graph_parse_entities)
              .enter().append("circle")
              .attr("r", nodes_radius)
              .attr("fill", function (d) {
                return color(d.group);
              })
              //.on("mouseover", mouseover)
              //.on("mouseout", mouseout)
              .call(d3.drag()
                .on("start", dragstarted)
                .on("drag", dragged)
                .on("end", dragended))


              // start mouseover here

              //.on("click", function(d){  //Mouse event
              .on("mouseover", function (d) {  //Mouse event
                var htmlString = getHtmlFromEntity(d);
                d3.select(this)
                  .transition()
                  .duration(500)
                  //.attr("x", function(d) { return x(d.cocoa) - 30; })
                  .style("cursor", "pointer")
                  .attr("width", 900);
                myTool
                  .transition()  //Opacity transition when the tooltip appears
                  .duration(500)
                  .style("opacity", "0.85")
                  .style("display", "block");  //The tooltip appears

                myTool
                  .html(htmlString)
                  .style("left", (d3.event.pageX + 20) + "px")
                  .style("top", (d3.event.pageY - 200) + "px");
              })


              .on("mouseout", function (d) {  //Mouse event
                d3.select(this)
                  .transition()
                  .duration(500)
                  //.attr("x", function(d) { return x(d.cocoa) - 20; })
                  .style("cursor", "normal")
                  .attr("width", 40);
                myTool
                  .transition()  //Opacity transition when the tooltip disappears
                  .duration(500)
                  .style("opacity", "0")
                  .style("display", "none");  //The tooltip disappears
              });


            node.append("title")
              .text(function (d) {
                return d.title;
              });

            simulation
              .nodes(graph_parse_entities)
              .on("tick", ticked);

            simulation.force("link")
              .links(graph_parse_relations);

            function ticked() {

              link
                .attr("x1", function (d) {
                  return d.source.x;
                })
                .attr("y1", function (d) {
                  return d.source.y;
                })
                .attr("x2", function (d) {
                  return d.target.x;
                })
                .attr("y2", function (d) {
                  return d.target.y;
                });

              node
                .attr("cx", function (d) {
                  return d.x;
                })
                .attr("cy", function (d) {
                  return d.y;
                });

            }

            // LEGENDE
            var legend = svg.selectAll(".legend")
              .data(color.domain())
              .enter().append("g")
              .attr("class", "legend")
              .attr("transform", function (d, i) {
                return "translate(" + (width_ext_legend + 200) + "," + ((i * 20) + (height_ext - 100)) + ")";
              });

            legend.append("circle")
              .attr("r", nodes_radius)
              .attr("x", width - 18)
              .style("fill", color)
              .style("stroke", "#fff")
              .style("stroke-width", "1.5px");

            legend.append("text")
              .attr("x", width - 24)
              .attr("y", 0)
              //.attr("color", "#CCCCCC")
              .attr("dy", ".35em")
              .style("text-anchor", "end")
              .style("color", "#787777")
              .text(function (d) {
                return d;
              });

          });

          function getHtmlFromEntity(d) {
            var html = "";
            //console.log(d.imageRect);
            html += "<div class='row'>" +
              "<div class='col-lg-6 mytooltip_text'>" +
              "<span class='attr_graph_title'><b>" + d.title + "  </b><span class='additional_info_medium_e'>(" + d.number + ") </span></span><br>" +
              "<span><i>" + d.group + " </i></span>" +
              "<hr/><span class='attr_graph_entitiy'> ";
            (d.title !== '') ? html += "<span>Name: " + d.title + " </span>" : "";
            (d.data_title !== '') ? html += "<span class='attr_graph_block_graph'>Entit&auml;t " + d.data_title + " </span>" : "";
            (d.sex !== '') ? html += "<span>Geschlecht: " + d.sex + " </span>" : "";
            (d.data_sex !== '') ? html += "<span class='attr_graph_block_graph'>Geschlecht " + d.data_sex + " </span>" : "";
            (d.stand !== '') ? html += "<span>Stand: " + d.stand + " </span>" : "";
            (d.data_stand !== '') ? html += "<span class='attr_graph_block_graph'>Stand " + d.data_stand + " </span>" : "";
            (d.gestus !== '') ? html += "<span>Gestus: " + d.gestus + " </span>" : "";
            (d.data_gestus !== '') ? html += "<span class='attr_graph_block_graph'>Gestus " + d.data_gestus + " </span>" : "";
            (d.form !== '') ? html += "<span>Form: " + d.form + " </span>" : "";
            (d.data_form !== '') ? html += "<span class='attr_graph_block_graph'>Form " + d.data_form + " </span>" : "";
            (d.farbe !== '') ? html += "<span>Farbe: " + d.farbe + " </span>" : "";
            (d.data_farbe !== '') ? html += "<span class='attr_graph_block_graph'>Farbe " + d.data_farbe + " </span>" : "";
            (d.material !== '') ? html += "<span>Material: " + d.material + " </span>" : "";
            (d.data_material !== '') ? html += "<span class='attr_graph_block_graph'>Material " + d.data_material + " </span>" : "";
            (d.text !== '') ? html += "<span>Text: " + d.text + " </span>" : "";
            (d.data_text !== '') ? html += "<span class='attr_graph_block_graph'>Text " + d.data_text + " </span>" : "";
            html += "</span><hr/><div class='attr_graph_block'>";
            html += "" +
              "</div>" + "</div>" +
              "<div class='col-lg-4'>";
            (d.imageRect !== '') ? html += "<div id='thumbnail'><img class='attr_graph-tag_image' src='" + d.imageRect + "' /></div><br/>" : "";
            html += "";
            (d.imagePoint !== '') ? html += "<div id='thumbnail'><img class='attr_graph-tag_image' src='" + d.imagePoint + "' /></div>" : "";
            html += "</div>" +
              "</div>" + "</div>";

            return html;
          }

          function display(d) { //Mouse event
            //.on("mouseover", function(d){  //Mouse event

            d3.select(this)
              .transition()
              .duration(500)
              //.attr("x", function(d) { return x(d.cocoa) - 30; })
              .style("cursor", "pointer")
              .attr("width", 900);
            myTool
              .transition()  //Opacity transition when the tooltip appears
              .duration(500)
              .style("opacity", "0.85")
              .style("display", "block");  //The tooltip appears

            myTool
              .html(
                "<div class='row'>" +
                "<div class='col-lg-6 mytooltip_text'>" +
                "<span><b>" + d.number + " - </b>" + d.title + "</span>" +
                "<span><i>" + d.group + " </i></span>" +
                "<hr/>" +
                "<span>Geschlecht: " + d.sex + " </span>" +
                "<span>Stand: " + d.stand + " </span>" +
                "<span>Gestus: " + d.gestus + " </span>" +
                "<span>Form: " + d.form + " </span>" +
                "<span>Farbe: " + d.farbe + " </span>" +
                "<span>Material: " + d.material + " </span>" +
                "<span>Text: " + d.text + " </span>" +
                "<hr/><div style='font-size: 11px; text-align: justify;' class='attr_graph_block'>" +
                "<span>EntitÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¤t " + d.data_title + " </span>" +
                  "<span>Geschlecht " + d.data_sex + " </span>" +
                "<span>Stand " + d.data_stand + " </span>" +
                "<span>Gestus " + d.data_gestus + " </span>" +
                "<span>Form " + d.data_form + " </span>" +
                "<span>Farbe " + d.data_farbe + " </span>" +
                "<span>Material " + d.data_material + " </span>" +
                "<span>Text " + d.data_text + " </span></div>" +
                "" +
                "</div>" +
                "<div class='col-lg-6'>" +
                "<div id='thumbnail' ><img class='attr_graph-tag_image' src='" + d.imageRect + "' /></div>" +
                "<br/>" +
                "<div id='thumbnail' ><img class='attr_graph-tag_image' src='" + d.imagePoint + "' /></div>" +
                "</div>" +
                "</div>")
              .style("left", (d3.event.pageX + 20) + "px")
              .style("top", (d3.event.pageY - 200) + "px");
          }

          function dragstarted(d) {
            if (!d3.event.active) simulation.alphaTarget(0.3).restart();
            d.fx = d.x;
            d.fy = d.y;
          }

          function dragged(d) {
            d.fx = d3.event.x;
            d.fy = d3.event.y;
          }

          function dragended(d) {
            if (!d3.event.active) simulation.alphaTarget(0);
            d.fx = null;
            d.fy = null;
          }

          function mouseover(d) {
            d3.select(this).append("text")
              .attr("class", "hover")
              .attr('transform', function (d) {
                return 'translate(5, -10)';
              })
              .text(d.title + ": " + d.id);
          }

          // Toggle children on click.
          function mouseout(d) {
            d3.select(this).select("text.hover").remove();
          }


        }, 500);

      }]);

});