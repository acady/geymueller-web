define(['services/module'], function (services) {
  services.service('dataservice',[ '$http', '$q','config', function($http, $q, config){


    function getLexiconData(d) {

      // in case we have more than one Entry

      // for now we have only on entry
      return d


    }

    function mapSex(sex) {
      //console.log(sex);
      var sexEntities = sex.split(" ");
      var map = '';
      //console.log(sexEntities);
      for (var i in sexEntities) {

        switch (sexEntities[i]) {
          case 'w':
            map += 'Frau (' + sexEntities[i] + ') ';
            break;
          case 'm':
            map += 'Mann (' + sexEntities[i] + ') ';
            break;
          case 't':
            map += 'Teufel (' + sexEntities[i] + ') ';
            break;
          case 'g':
            map += 'Gruppe (' + sexEntities[i] + ') ';
            break;
          case 'k':
            map += 'Kind (' + sexEntities[i] + ') ';
            break;
          case 'f':
            map += 'Fabelwesen (' + sexEntities[i] + ') ';
            break;
          case 'e':
            map += 'Engel (' + sexEntities[i] + ') ';
            break;
          default:
            map += 'Person (' + sexEntities[i] + ') ';
        }

      }
      return map;
    }


    function getLexiconPathData(d) {
      var pathTree = '';
      for (var i in d) {
        // if you want you clout get teh result here one more ....
        pathTree += d[i] +'<br>';
      }
      return pathTree ;
    }

    function getStaticData(d) {
      var ret_data = ''; //new String();
      //console.log("d");
      //console.log(d);
      if(d.flags) {
        ret_data = "  Flag: ";
        // foreach
        for (var prop in d.flags) {
          if( d.flags.hasOwnProperty( prop ) ) {
            //console.log("o." + prop + " = " + d.flags[prop]);
            if (d.flags[prop]) {
              (prop == 'remarkable') ? ret_data += "bemerkenswert ! " : "";
              (prop == 'questionable') ? ret_data += "fragwÃƒÂ¼rdig ? " : "";
              (prop == 'unconfirmed') ? ret_data += "unbestÃƒÂ¤tigt ~ " : "";
            }
            //ret_data += prop + " = " + d.flags[prop];
            /*
             ret_data += "!" + e.remarkable + "  ";
             ret_data += "?:" + e.questionable + "  ";
             ret_data += "*:" + e.unconfirmed + "  ";
             */
          }
        }
      }
      if(d.comments) {
        ret_data = "  Kommentar: ";
        // foreach
        d.comments.forEach(function(e) {
          //console.log('comments-element:', e);
          ret_data += e + "<br>";
        });
        return ret_data;

      }
      if(d.literatur) {
        ret_data = "  Lit.: ";
        // foreach
        d.literatur.forEach(function(e) {
          //console.log('lit-element:', e);
          ret_data += e.value + "<br>";
        });
      }
      if(d.lod_entries) {
        ret_data = "  LOD: ";
        // foreach
        d.lod_entries.forEach(function(e) {
          //console.log('lod-element:', e);
          ret_data += e.source + " " + e.id + "<br>";
        });

      }
      if(d.thesaurus_id) {
        //console.log('thesaurus-element:', d.thesaurus_id);
        ret_data += "  Thes.: ";
        ret_data += d.thesaurus_id;

        //return ret_data;
      }
      return ret_data;
    }


    function getAddData(data, d) {

      var deferred = $q.defer();

      var ret_data = ''; //new String();
      //console.log("d");
      //console.log(d);

      if(d.thesaurus_lexicon) {
        //console.log('thesaurus-lexicon-element:', d.thesaurus_id);
        // ret_data += "  Lex.: ";
        // ret_data += d.thesaurus_lexicon;
        ret_data += getStaticData(d);

        var dataset = data.thesaurus[d.thesaurus_id];
        var lexName = '';
        var lexEntry = '';
        var lexEntryPath = '';
        var lexEntry_data = '';
        var lexEntryPath_data = '';

        if (dataset.longname) { lexName += dataset.longname; };
        if (dataset.shortname) { lexName += ' (' + dataset.shortname + ')'; };
        if (dataset.values) { lexEntry += dataset.values.lexikon ; lexEntry_data += getLexiconData(dataset.values); };
        if (dataset.path) { lexEntryPath += dataset.path[0] ; lexEntryPath_data += getLexiconPathData(dataset.path) };
        //console.log('MIT LEXIKON:' +ret_data+" Dataset: " + d.thesaurus_id);
        //console.log(dataset);

        ret_data += '<br>' + lexName + '<br>' + lexEntry + '<br>' + lexEntryPath_data;
        deferred.resolve(ret_data);

      } else {
        ret_data += getStaticData(d);
        //console.log('OHNE LEXIKON:' +ret_data);
        deferred.resolve(ret_data);
      }

      return deferred.promise;
    }

    function getTagsValues(d) {
      var tags = d.tags;
      var rectCoordX1 = 0;
      var rectCoordY1 = 0;
      var rectCoordX2 = 0;
      var rectCoordY2 = 0;
      var pointTag = [];
      var rectTag = [];

      tags.forEach( function(tag) {

        if(tag.type == 'point'){
          rectCoordX1 = tag.coordinates[0];
          rectCoordY1 = tag.coordinates[1];
          pointTag =  {
            x: rectCoordX1,
            y: rectCoordY1
          }
        } else if (tag.type == 'rect') {
          rectCoordX1 = tag.coordinates[0];
          rectCoordY1 = tag.coordinates[1];
          rectCoordX2 = tag.coordinates[2];
          rectCoordY2 = tag.coordinates[3];
          rectTag = {
            x1: rectCoordX1,
            y1: rectCoordY1,
            x2: rectCoordX2,
            y2: rectCoordY2
          }
        } else {
          // do nothing for the while
        }
      });

      var valueTag = {
        point: pointTag,
        rect: rectTag
      };
      //console.log(valueTag);
      return valueTag;

    }

    function getTagsImagesUrl(d) {
      var tags = d.tags;
      var dia = '';
      var width = 1800;
      var height = 1800;
      var widthPoint = 1200;
      var heightPoint = 1200;
      // mit 0,1 ist er im Backend gerechnet wir nehme ndas doppelte
      var rectForPoint = 0.20;
      var baseUrl =  config.imageBaseUrl;
      // +'7019493.tif&amp;WID=2459.311641155794&amp;HEI=2958.9041095890407&amp;RGN=0.6509158292352646,0.43055555555555547,0.16372080868552974,0.47500000000000003&amp;CVT=JPG'

      var rectCoordX1 = 0;
      var rectCoordY1 = 0;
      var rectCoordX2 = 0;
      var rectCoordY2 = 0;
      var pointTag = '';
      var rectTag = '';

      tags.forEach( function(tag) {
        dia = tag.dianr;
        if(tag.type == 'point'){
          rectCoordX1 = tag.coordinates[0] - (rectForPoint/2);
          rectCoordY1 = tag.coordinates[1] - (rectForPoint/2);
          rectCoordX2 = rectForPoint;
          rectCoordY2 = rectForPoint;
          pointTag = baseUrl + dia + ".tif&amp;WID=" + widthPoint + "&amp;HEI=" + heightPoint + "&amp;RGN=" + rectCoordX1 + "," + rectCoordY1 + "," + rectCoordX2 + "," + rectCoordY2 + "&amp;CVT=JPG";
        } else if (tag.type == 'rect') {
          rectCoordX1 = tag.coordinates[0];
          rectCoordY1 = tag.coordinates[1];
          rectCoordX2 = tag.coordinates[2];
          rectCoordY2 = tag.coordinates[3];
          rectTag = baseUrl + dia + ".tif&amp;WID=" + width + "&amp;HEI=" + height + "&amp;RGN=" + rectCoordX1 + "," + rectCoordY1 + "," + rectCoordX2 + "," + rectCoordY2 + "&amp;CVT=JPG";

        } else {
          // do nothing for the while
        }
      });

      var imageTag = {
        point: pointTag,
        rect: rectTag
      };
      return imageTag;
    }

    function getData(d, i, data) {
      var imageRect = '';
      var imagePoint = '';
      var tagRect = '';
      var tagPoint = '';
      var tagValues = [];
      var tagImages = [];
      if (d.tags) {
        //console.log(getTagsImagesUrl(d));
        tagImages = getTagsImagesUrl(d);
        imageRect = tagImages.rect;
        imagePoint = tagImages.point;
        tagValues = getTagsValues(d);
        tagRect = tagValues.rect;
        tagPoint = tagValues.point;
      }

      var deferred = $q.defer();

      // Structure Mapper toto LOOP throug [0]
      switch(d.type) {
        case 'Szene':
          var title = 'Szene';
          var data_title = '';
          if (d.name) {
            title = d.name[0].value;
            getAddData(data, d.name[0]).then(function(result){
              //console.log(result);
              data_title += result;
              deferred.resolve({
                id: i,
                number: d.id,
                title: d.id,
                sex: '' ,
                stand: '' ,
                gestus: '' ,
                farbe: '' ,
                form: '' ,
                material: '' ,
                text: '',
                data_title: data_title ,
                data_sex: '' ,
                data_stand: '' ,
                data_gestus: '' ,
                data_farbe: '' ,
                data_form: '' ,
                data_material: '' ,
                data_text: '' ,
                group: d.type,
                imageRect: imageRect,
                imagePoint: imagePoint,
                tagRect: tagRect,
                tagPoint: tagPoint
              })
            });
          } else {
            deferred.resolve({
              id: i,
              number: d.id,
              title: d.id,
              sex: '' ,
              stand: '' ,
              gestus: '' ,
              farbe: '' ,
              form: '' ,
              material: '' ,
              text: '',
              data_title: data_title ,
              data_sex: '' ,
              data_stand: '' ,
              data_gestus: '' ,
              data_farbe: '' ,
              data_form: '' ,
              data_material: '' ,
              data_text: '' ,
              group: d.type,
              imageRect: imageRect,
              imagePoint: imagePoint,
              tagRect: tagRect,
              tagPoint: tagPoint

            })
          };

          break;
        case 'Handlung':
          var title = 'Handlung';
          var data_title = '';
          if (d.name) {
            title = d.name[0].value;
            getAddData(data, d.name[0]).then(function(result){
              //console.log(result);
              data_title += result;
              deferred.resolve({
                id: i,
                number: d.id,
                title: title,
                sex: '' ,
                stand: '' ,
                gestus: '' ,
                farbe: '' ,
                form: '' ,
                material: '' ,
                text: '',
                data_title: data_title ,
                data_sex: '' ,
                data_stand: '' ,
                data_gestus: '' ,
                data_farbe: '' ,
                data_form: '' ,
                data_material: '' ,
                data_text: '' ,
                group: d.type,
                imageRect: imageRect,
                imagePoint: imagePoint,
                tagRect: tagRect,
                tagPoint: tagPoint


              })
            });
          } else {
            deferred.resolve({
              id: i,
              number: d.id,
              title: d.id,
              sex: '' ,
              stand: '' ,
              gestus: '' ,
              farbe: '' ,
              form: '' ,
              material: '' ,
              text: '',
              data_title: data_title ,
              data_sex: '' ,
              data_stand: '' ,
              data_gestus: '' ,
              data_farbe: '' ,
              data_form: '' ,
              data_material: '' ,
              data_text: '' ,
              group: d.type,
              image: config.imageBaseUrl +'7019493.tif&amp;WID=2459.311641155794&amp;HEI=2958.9041095890407&amp;RGN=0.6509158292352646,0.43055555555555547,0.16372080868552974,0.47500000000000003&amp;CVT=JPG'


            })
          };

          break;
        case 'Person':
          //console.log(d);
          var title = 'Person';
          var data_title = '';
          var sex = '';
          var data_sex = '';
          var stand = '';
          var data_stand = '';
          var gestus = '';
          var data_gestus = '';

          var counter = 0;

          if (d.sname) {
            counter += 1;
            title = d.sname[0].value;
          }
          if (d.name) {
            //counter += 1;
            title = d.name[0].value;
            console.log("NAME bei Person");
          }
          if (d.sex) {
            counter += 10;
            sex = d.sex[0].value;
          }

          if (d.stand) {
            counter += 100;
            stand = d.stand[0].value
          };

          if (d.gestus) {
            counter += 1000;
            gestus = d.gestus[0].value;
          };

          switch (counter) {
            case 0:
              deferred.resolve({
                id: i,
                number: d.id,
                title: title,
                farbe: '',
                form: '',
                material: '',
                sex: mapSex(sex),
                stand: stand,
                gestus: gestus,
                text: '',
                data_title: data_title,
                data_form: '',
                data_farbe: '',
                data_material: '',
                data_stand: data_stand,
                data_sex: data_sex,
                data_gestus: data_gestus,
                data_text: '',
                group: d.type,
                imageRect: imageRect,
                imagePoint: imagePoint,
                tagRect: tagRect,
                tagPoint: tagPoint


              });
              break;
            case 1:
              getAddData(data, d.sname[0]).then(function (result) {
                data_title += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: '',
                  form: '',
                  material: '',
                  sex: mapSex(sex),
                  stand: stand,
                  gestus: gestus,
                  text: '',
                  data_title: data_title,
                  data_form: '',
                  data_farbe: '',
                  data_material: '',
                  data_stand: data_stand,
                  data_sex: data_sex,
                  data_gestus: data_gestus,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 10:
              getAddData(data, d.sex[0]).then(function (result) {
                data_sex += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: '',
                  form: '',
                  material: '',
                  sex: mapSex(sex),
                  stand: stand,
                  gestus: gestus,
                  text: '',
                  data_title: data_title,
                  data_form: '',
                  data_farbe: '',
                  data_material: '',
                  data_stand: data_stand,
                  data_sex: data_sex,
                  data_gestus: data_gestus,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 100:
              getAddData(data, d.stand[0]).then(function (result) {
                data_stand += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: '',
                  form: '',
                  material: '',
                  sex: mapSex(sex),
                  stand: stand,
                  gestus: gestus,
                  text: '',
                  data_title: data_title,
                  data_form: '',
                  data_farbe: '',
                  data_material: '',
                  data_stand: data_stand,
                  data_sex: data_sex,
                  data_gestus: data_gestus,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 1000:
              getAddData(data,  d.gestus[0]).then(function (result) {
                data_gestus += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: '',
                  form: '',
                  material: '',
                  sex: mapSex(sex),
                  stand: stand,
                  gestus: gestus,
                  text: '',
                  data_title: data_title,
                  data_form: '',
                  data_farbe: '',
                  data_material: '',
                  data_stand: data_stand,
                  data_sex: data_sex,
                  data_gestus: data_gestus,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 1001: // name, material
              getAddData(data, d.sname[0]).then(function (result) {
                data_title += result;
                getAddData(data,  d.gestus[0]).then(function (result) {
                  data_gestus += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: '',
                    form: '',
                    material: '',
                    sex: mapSex(sex),
                    stand: stand,
                    gestus: gestus,
                    text: '',
                    data_title: data_title,
                    data_form: '',
                    data_farbe: '',
                    data_material: '',
                    data_stand: data_stand,
                    data_sex: data_sex,
                    data_gestus: data_gestus,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 11: // name form
              getAddData(data, d.sname[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.sex[0]).then(function (result) {
                  data_sex += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: '',
                    form: '',
                    material: '',
                    sex: mapSex(sex),
                    stand: stand,
                    gestus: gestus,
                    text: '',
                    data_title: data_title,
                    data_form: '',
                    data_farbe: '',
                    data_material: '',
                    data_stand: data_stand,
                    data_sex: data_sex,
                    data_gestus: data_gestus,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 101: // name farbe
              getAddData(data, d.sname[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.stand[0]).then(function (result) {
                  data_stand += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: '',
                    form: '',
                    material: '',
                    sex: mapSex(sex),
                    stand: stand,
                    gestus: gestus,
                    text: '',
                    data_title: data_title,
                    data_form: '',
                    data_farbe: '',
                    data_material: '',
                    data_stand: data_stand,
                    data_sex: data_sex,
                    data_gestus: data_gestus,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 110: // form farbe
              getAddData(data, d.sex[0]).then(function (result) {
                data_sex += result;
                getAddData(data, d.stand[0]).then(function (result) {
                  data_stand += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: '',
                    form: '',
                    material: '',
                    sex: mapSex(sex),
                    stand: stand,
                    gestus: gestus,
                    text: '',
                    data_title: data_title,
                    data_form: '',
                    data_farbe: '',
                    data_material: '',
                    data_stand: data_stand,
                    data_sex: data_sex,
                    data_gestus: data_gestus,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 1100: // farbe material
              getAddData(data, d.stand[0]).then(function (result) {
                data_stand += result;
                getAddData(data,  d.gestus[0]).then(function (result) {
                  data_gestus += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: '',
                    form: '',
                    material: '',
                    sex: mapSex(sex),
                    stand: stand,
                    gestus: gestus,
                    text: '',
                    data_title: data_title,
                    data_form: '',
                    data_farbe: '',
                    data_material: '',
                    data_stand: data_stand,
                    data_sex: data_sex,
                    data_gestus: data_gestus,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 111: // name form farbe
              getAddData(data, d.sname[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.sex[0]).then(function (result) {
                  data_sex += result;
                  getAddData(data, d.stand[0]).then(function (result) {
                    data_stand += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: '',
                      form: '',
                      material: '',
                      sex: mapSex(sex),
                      stand: stand,
                      gestus: gestus,
                      text: '',
                      data_title: data_title,
                      data_form: '',
                      data_farbe: '',
                      data_material: '',
                      data_stand: data_stand,
                      data_sex: data_sex,
                      data_gestus: data_gestus,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1110: // form farbe material
              getAddData(data, d.sex[0]).then(function (result) {
                data_sex += result;
                getAddData(data, d.stand[0]).then(function (result) {
                  data_stand += result;
                  getAddData(data,  d.gestus[0]).then(function (result) {
                    data_gestus += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: '',
                      form: '',
                      material: '',
                      sex: mapSex(sex),
                      stand: stand,
                      gestus: gestus,
                      text: '',
                      data_title: data_title,
                      data_form: '',
                      data_farbe: '',
                      data_material: '',
                      data_stand: data_stand,
                      data_sex: data_sex,
                      data_gestus: data_gestus,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1101:  // name farbe material
              getAddData(data, d.sname[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.stand[0]).then(function (result) {
                  data_stand += result;
                  getAddData(data,  d.gestus[0]).then(function (result) {
                    data_gestus += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: '',
                      form: '',
                      material: '',
                      sex: mapSex(sex),
                      stand: stand,
                      gestus: gestus,
                      text: '',
                      data_title: data_title,
                      data_form: '',
                      data_farbe: '',
                      data_material: '',
                      data_stand: data_stand,
                      data_sex: data_sex,
                      data_gestus: data_gestus,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1011: // name form material
              getAddData(data, d.sname[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.sex[0]).then(function (result) {
                  data_sex += result;
                  getAddData(data,  d.gestus[0]).then(function (result) {
                    data_gestus += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: '',
                      form: '',
                      material: '',
                      sex: mapSex(sex),
                      stand: stand,
                      gestus: gestus,
                      text: '',
                      data_title: data_title,
                      data_form: '',
                      data_farbe: '',
                      data_material: '',
                      data_stand: data_stand,
                      data_sex: data_sex,
                      data_gestus: data_gestus,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1111: // name form farbe material
              getAddData(data, d.sname[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.sex[0]).then(function (result) {
                  data_sex += result;
                  getAddData(data, d.stand[0]).then(function (result) {
                    data_stand += result;
                    getAddData(data,  d.gestus[0]).then(function (result) {
                      data_gestus += result;
                      deferred.resolve({
                        id: i,
                        number: d.id,
                        title: title,
                        farbe: '',
                        form: '',
                        material: '',
                        sex: mapSex(sex),
                        stand: stand,
                        gestus: gestus,
                        text: '',
                        data_title: data_title,
                        data_form: '',
                        data_farbe: '',
                        data_material: '',
                        data_stand: data_stand,
                        data_sex: data_sex,
                        data_gestus: data_gestus,
                        data_text: '',
                        group: d.type,
                        imageRect: imageRect,
                        imagePoint: imagePoint,
                        tagRect: tagRect,
                        tagPoint: tagPoint


                      });
                    });
                  });
                });
              });
              break;
            default:
              deferred.resolve({
                id: i,
                number: d.id,
                title: title,
                farbe: '',
                form: '',
                material: '',
                sex: mapSex(sex),
                stand: stand,
                gestus: gestus,
                text: '',
                data_title: data_title,
                data_form: '',
                data_farbe: '',
                data_material: '',
                data_stand: data_stand,
                data_sex: data_sex,
                data_gestus: data_gestus,
                data_text: '',
                group: d.type,
                imageRect: imageRect,
                imagePoint: imagePoint,
                tagRect: tagRect,
                tagPoint: tagPoint


              });
          };
          break;
        case 'Objekt':
          var title = 'Objekt';
          var data_title = '';
          var farbe = '';
          var data_farbe = '';
          var form = '';
          var data_form = '';
          var material = '';
          var data_material= '';

          var counter = 0;

          if (d.name) {
            title = d.name[0].value;
            counter += 1;
          }
          if (d.form) {
            form = d.form[0].value;
            counter += 10;
          }
          if (d.farbe) {
            farbe = d.farbe[0].value;
            counter += 100;
          }
          if (d.material) {
            material = d.material[0].value;
            counter += 1000;
          }
          //console.log(counter + " " +d.id)
          switch (counter) {
            case 0:
              deferred.resolve({
                id: i,
                number: d.id,
                title: title,
                farbe: farbe,
                form: form,
                material: material,
                sex: '',
                stand: '',
                gestus: '',
                text: '',
                data_title: data_title,
                data_sex: '',
                data_stand: '',
                data_gestus: '',
                data_farbe: data_farbe,
                data_form: data_form,
                data_material: data_material,
                data_text: '',
                group: d.type,
                imageRect: imageRect,
                imagePoint: imagePoint,
                tagRect: tagRect,
                tagPoint: tagPoint


              });
              break;
            case 1:
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: farbe,
                  form: form,
                  material: material,
                  sex: '',
                  stand: '',
                  gestus: '',
                  text: '',
                  data_title: data_title,
                  data_sex: '',
                  data_stand: '',
                  data_gestus: '',
                  data_farbe: data_farbe,
                  data_form: data_form,
                  data_material: data_material,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 10:
              getAddData(data, d.form[0]).then(function (result) {
                data_form += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: farbe,
                  form: form,
                  material: material,
                  sex: '',
                  stand: '',
                  gestus: '',
                  text: '',
                  data_title: data_title,
                  data_sex: '',
                  data_stand: '',
                  data_gestus: '',
                  data_farbe: data_farbe,
                  data_form: data_form,
                  data_material: data_material,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 100:
              getAddData(data, d.farbe[0]).then(function (result) {
                data_farbe += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: farbe,
                  form: form,
                  material: material,
                  sex: '',
                  stand: '',
                  gestus: '',
                  text: '',
                  data_title: data_title,
                  data_sex: '',
                  data_stand: '',
                  data_gestus: '',
                  data_farbe: data_farbe,
                  data_form: data_form,
                  data_material: data_material,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 1000:
              getAddData(data, d.material[0]).then(function (result) {
                data_material += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: farbe,
                  form: form,
                  material: material,
                  sex: '',
                  stand: '',
                  gestus: '',
                  text: '',
                  data_title: data_title,
                  data_sex: '',
                  data_stand: '',
                  data_gestus: '',
                  data_farbe: data_farbe,
                  data_form: data_form,
                  data_material: data_material,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 1001: // name, material
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.material[0]).then(function (result) {
                  data_material += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 11: // name form
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.form[0]).then(function (result) {
                  data_form += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 101: // name farbe
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.farbe[0]).then(function (result) {
                  data_farbe += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 110: // form farbe
              getAddData(data, d.form[0]).then(function (result) {
                data_form += result;
                getAddData(data, d.farbe[0]).then(function (result) {
                  data_farbe += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 1100: // farbe material
              getAddData(data, d.farbe[0]).then(function (result) {
                data_farbe += result;
                getAddData(data, d.material[0]).then(function (result) {
                  data_material += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 111: // name form farbe
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.form[0]).then(function (result) {
                  data_form += result;
                  getAddData(data, d.farbe[0]).then(function (result) {
                    data_farbe += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: farbe,
                      form: form,
                      material: material,
                      sex: '',
                      stand: '',
                      gestus: '',
                      text: '',
                      data_title: data_title,
                      data_sex: '',
                      data_stand: '',
                      data_gestus: '',
                      data_farbe: data_farbe,
                      data_form: data_form,
                      data_material: data_material,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1110: // form farbe material
              getAddData(data, d.form[0]).then(function (result) {
                data_form += result;
                getAddData(data, d.farbe[0]).then(function (result) {
                  data_farbe += result;
                  getAddData(data, d.material[0]).then(function (result) {
                    data_material += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: farbe,
                      form: form,
                      material: material,
                      sex: '',
                      stand: '',
                      gestus: '',
                      text: '',
                      data_title: data_title,
                      data_sex: '',
                      data_stand: '',
                      data_gestus: '',
                      data_farbe: data_farbe,
                      data_form: data_form,
                      data_material: data_material,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1101:  // name farbe material
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.farbe[0]).then(function (result) {
                  data_farbe += result;
                  getAddData(data, d.material[0]).then(function (result) {
                    data_material += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: farbe,
                      form: form,
                      material: material,
                      sex: '',
                      stand: '',
                      gestus: '',
                      text: '',
                      data_title: data_title,
                      data_sex: '',
                      data_stand: '',
                      data_gestus: '',
                      data_farbe: data_farbe,
                      data_form: data_form,
                      data_material: data_material,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1011: // name form material
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.form[0]).then(function (result) {
                  data_form += result;
                  getAddData(data, d.material[0]).then(function (result) {
                    data_material += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: farbe,
                      form: form,
                      material: material,
                      sex: '',
                      stand: '',
                      gestus: '',
                      text: '',
                      data_title: data_title,
                      data_sex: '',
                      data_stand: '',
                      data_gestus: '',
                      data_farbe: data_farbe,
                      data_form: data_form,
                      data_material: data_material,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1111: // name form farbe material
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.form[0]).then(function (result) {
                  data_form += result;
                  getAddData(data, d.farbe[0]).then(function (result) {
                    data_farbe += result;
                    getAddData(data, d.material[0]).then(function (result) {
                      data_material += result;
                      deferred.resolve({
                        id: i,
                        number: d.id,
                        title: title,
                        farbe: farbe,
                        form: form,
                        material: material,
                        sex: '',
                        stand: '',
                        gestus: '',
                        text: '',
                        data_title: data_title,
                        data_sex: '',
                        data_stand: '',
                        data_gestus: '',
                        data_farbe: data_farbe,
                        data_form: data_form,
                        data_material: data_material,
                        data_text: '',
                        group: d.type,
                        imageRect: imageRect,
                        imagePoint: imagePoint,
                        tagRect: tagRect,
                        tagPoint: tagPoint


                      });
                    });
                  });
                });
              });
              break;
            default:
              deferred.resolve({
                id: i,
                number: d.id,
                title: title,
                farbe: farbe,
                form: form,
                material: material,
                sex: '',
                stand: '',
                gestus: '',
                text: '',
                data_title: data_title,
                data_sex: '',
                data_stand: '',
                data_gestus: '',
                data_farbe: data_farbe,
                data_form: data_form,
                data_material: data_material,
                data_text: '',
                group: d.type,
                imageRect: imageRect,
                imagePoint: imagePoint,
                tagRect: tagRect,
                tagPoint: tagPoint


              });
          };
          break;

        case 'Originalzitat':
          var title = 'Originalzitat';
          var data_title = '';
          var text = '';
          var data_text = '';

          var counter = 0;

          if (d.name) {
            title = d.name[0].value;
            count += 1;
          }
          if (d.text) {
            text = d.text[0].value;
            counter += 10;
          }
          switch (counter) {
            case 0:
              deferred.resolve({
                id: i,
                number: d.id,
                title: title,
                text: text,
                sex: '' ,
                stand: '' ,
                gestus: '' ,
                farbe: '' ,
                form: '' ,
                material: '' ,
                data_title: data_title ,
                data_sex: '' ,
                data_stand: '' ,
                data_gestus: '' ,
                data_farbe: '' ,
                data_form: '' ,
                data_material: '' ,
                data_text: data_text ,
                group: d.type,
                imageRect: imageRect,
                imagePoint: imagePoint,
                tagRect: tagRect,
                tagPoint: tagPoint


              });
              break;
            case 1: // name
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  text: text,
                  sex: '' ,
                  stand: '' ,
                  gestus: '' ,
                  farbe: '' ,
                  form: '' ,
                  material: '' ,
                  data_title: data_title ,
                  data_sex: '' ,
                  data_stand: '' ,
                  data_gestus: '' ,
                  data_farbe: '' ,
                  data_form: '' ,
                  data_material: '' ,
                  data_text: data_text ,
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 10:  // text
              getAddData(data, d.text[0]).then(function (result) {
                data_text += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  text: text,
                  sex: '',
                  stand: '',
                  gestus: '',
                  farbe: '',
                  form: '',
                  material: '',
                  data_title: data_title,
                  data_sex: '',
                  data_stand: '',
                  data_gestus: '',
                  data_farbe: '',
                  data_form: '',
                  data_material: '',
                  data_text: data_text,
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 11:  // text name
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.text[0]).then(function (result) {
                  data_text += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    text: text,
                    sex: '',
                    stand: '',
                    gestus: '',
                    farbe: '',
                    form: '',
                    material: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: '',
                    data_form: '',
                    data_material: '',
                    data_text: data_text,
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            default:
              deferred.resolve({
                id: i,
                number: d.id,
                title: title,
                text: text,
                sex: '',
                stand: '',
                gestus: '',
                farbe: '',
                form: '',
                material: '',
                data_title: data_title,
                data_sex: '',
                data_stand: '',
                data_gestus: '',
                data_farbe: '',
                data_form: '',
                data_material: '',
                data_text: data_text,
                group: d.type,
                imageRect: imageRect,
                imagePoint: imagePoint,
                tagRect: tagRect,
                tagPoint: tagPoint


              });
              break;
          }
          break;

        case 'Attribut':
          var title = 'Attribut';
          var data_title = '';
          var farbe = '';
          var data_farbe = '';
          var form = '';
          var data_form = '';
          var material = '';
          var data_material= '';

          var counter = 0;

          if (d.name) {
            title = d.name[0].value;
            counter += 1;
          }
          if (d.form) {
            form = d.form[0].value;
            counter += 10;
          }
          if (d.farbe) {
            farbe = d.farbe[0].value;
            counter += 100;
          }
          if (d.material) {
            material = d.material[0].value;
            counter += 1000;
          }
          //console.log(counter + " " +d.id)
          switch (counter) {
            case 0:
              deferred.resolve({
                id: i,
                number: d.id,
                title: title,
                farbe: farbe,
                form: form,
                material: material,
                sex: '',
                stand: '',
                gestus: '',
                text: '',
                data_title: data_title,
                data_sex: '',
                data_stand: '',
                data_gestus: '',
                data_farbe: data_farbe,
                data_form: data_form,
                data_material: data_material,
                data_text: '',
                group: d.type,
                imageRect: imageRect,
                imagePoint: imagePoint,
                tagRect: tagRect,
                tagPoint: tagPoint


              });
              break;
            case 1:
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: farbe,
                  form: form,
                  material: material,
                  sex: '',
                  stand: '',
                  gestus: '',
                  text: '',
                  data_title: data_title,
                  data_sex: '',
                  data_stand: '',
                  data_gestus: '',
                  data_farbe: data_farbe,
                  data_form: data_form,
                  data_material: data_material,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 10:
              getAddData(data, d.form[0]).then(function (result) {
                data_form += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: farbe,
                  form: form,
                  material: material,
                  sex: '',
                  stand: '',
                  gestus: '',
                  text: '',
                  data_title: data_title,
                  data_sex: '',
                  data_stand: '',
                  data_gestus: '',
                  data_farbe: data_farbe,
                  data_form: data_form,
                  data_material: data_material,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 100:
              getAddData(data, d.farbe[0]).then(function (result) {
                data_farbe += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: farbe,
                  form: form,
                  material: material,
                  sex: '',
                  stand: '',
                  gestus: '',
                  text: '',
                  data_title: data_title,
                  data_sex: '',
                  data_stand: '',
                  data_gestus: '',
                  data_farbe: data_farbe,
                  data_form: data_form,
                  data_material: data_material,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 1000:
              getAddData(data, d.material[0]).then(function (result) {
                data_material += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: farbe,
                  form: form,
                  material: material,
                  sex: '',
                  stand: '',
                  gestus: '',
                  text: '',
                  data_title: data_title,
                  data_sex: '',
                  data_stand: '',
                  data_gestus: '',
                  data_farbe: data_farbe,
                  data_form: data_form,
                  data_material: data_material,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 1001: // name, material
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.material[0]).then(function (result) {
                  data_material += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 11: // name form
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.form[0]).then(function (result) {
                  data_form += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 101: // name farbe
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.farbe[0]).then(function (result) {
                  data_farbe += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 110: // form farbe
              getAddData(data, d.form[0]).then(function (result) {
                data_form += result;
                getAddData(data, d.farbe[0]).then(function (result) {
                  data_farbe += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 1100: // farbe material
              getAddData(data, d.farbe[0]).then(function (result) {
                data_farbe += result;
                getAddData(data, d.material[0]).then(function (result) {
                  data_material += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 111: // name form farbe
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.form[0]).then(function (result) {
                  data_form += result;
                  getAddData(data, d.farbe[0]).then(function (result) {
                    data_farbe += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: farbe,
                      form: form,
                      material: material,
                      sex: '',
                      stand: '',
                      gestus: '',
                      text: '',
                      data_title: data_title,
                      data_sex: '',
                      data_stand: '',
                      data_gestus: '',
                      data_farbe: data_farbe,
                      data_form: data_form,
                      data_material: data_material,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1110: // form farbe material
              getAddData(data, d.form[0]).then(function (result) {
                data_form += result;
                getAddData(data, d.farbe[0]).then(function (result) {
                  data_farbe += result;
                  getAddData(data, d.material[0]).then(function (result) {
                    data_material += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: farbe,
                      form: form,
                      material: material,
                      sex: '',
                      stand: '',
                      gestus: '',
                      text: '',
                      data_title: data_title,
                      data_sex: '',
                      data_stand: '',
                      data_gestus: '',
                      data_farbe: data_farbe,
                      data_form: data_form,
                      data_material: data_material,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1101:  // name farbe material
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.farbe[0]).then(function (result) {
                  data_farbe += result;
                  getAddData(data, d.material[0]).then(function (result) {
                    data_material += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: farbe,
                      form: form,
                      material: material,
                      sex: '',
                      stand: '',
                      gestus: '',
                      text: '',
                      data_title: data_title,
                      data_sex: '',
                      data_stand: '',
                      data_gestus: '',
                      data_farbe: data_farbe,
                      data_form: data_form,
                      data_material: data_material,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1011: // name form material
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.form[0]).then(function (result) {
                  data_form += result;
                  getAddData(data, d.material[0]).then(function (result) {
                    data_material += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: farbe,
                      form: form,
                      material: material,
                      sex: '',
                      stand: '',
                      gestus: '',
                      text: '',
                      data_title: data_title,
                      data_sex: '',
                      data_stand: '',
                      data_gestus: '',
                      data_farbe: data_farbe,
                      data_form: data_form,
                      data_material: data_material,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1111: // name form farbe material
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.form[0]).then(function (result) {
                  data_form += result;
                  getAddData(data, d.farbe[0]).then(function (result) {
                    data_farbe += result;
                    getAddData(data, d.material[0]).then(function (result) {
                      data_material += result;
                      deferred.resolve({
                        id: i,
                        number: d.id,
                        title: title,
                        farbe: farbe,
                        form: form,
                        material: material,
                        sex: '',
                        stand: '',
                        gestus: '',
                        text: '',
                        data_title: data_title,
                        data_sex: '',
                        data_stand: '',
                        data_gestus: '',
                        data_farbe: data_farbe,
                        data_form: data_form,
                        data_material: data_material,
                        data_text: '',
                        group: d.type,
                        imageRect: imageRect,
                        imagePoint: imagePoint,
                        tagRect: tagRect,
                        tagPoint: tagPoint


                      });
                    });
                  });
                });
              });
              break;
            default:
              deferred.resolve({
                id: i,
                number: d.id,
                title: title,
                farbe: farbe,
                form: form,
                material: material,
                sex: '',
                stand: '',
                gestus: '',
                text: '',
                data_title: data_title,
                data_sex: '',
                data_stand: '',
                data_gestus: '',
                data_farbe: data_farbe,
                data_form: data_form,
                data_material: data_material,
                data_text: '',
                group: d.type,
                imageRect: imageRect,
                imagePoint: imagePoint,
                tagRect: tagRect,
                tagPoint: tagPoint


              });
          };
          break;
        case 'Koerperteil':
          var title = 'Koerperteil';
          var data_title = '';
          var farbe = '';
          var data_farbe = '';
          var form = '';
          var data_form = '';
          var material = '';
          var data_material= '';

          var counter = 0;

          if (d.name) {
            title = d.name[0].value;
            counter += 1;
          }
          if (d.form) {
            form = d.form[0].value;
            counter += 10;
          }
          if (d.farbe) {
            farbe = d.farbe[0].value;
            counter += 100;
          }
          if (d.material) {
            material = d.material[0].value;
            counter += 1000;
          }
          //console.log(counter + " " +d.id)
          switch (counter) {
            case 0:
              deferred.resolve({
                id: i,
                number: d.id,
                title: title,
                farbe: farbe,
                form: form,
                material: material,
                sex: '',
                stand: '',
                gestus: '',
                text: '',
                data_title: data_title,
                data_sex: '',
                data_stand: '',
                data_gestus: '',
                data_farbe: data_farbe,
                data_form: data_form,
                data_material: data_material,
                data_text: '',
                group: d.type,
                imageRect: imageRect,
                imagePoint: imagePoint,
                tagRect: tagRect,
                tagPoint: tagPoint


              });
              break;
            case 1:
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: farbe,
                  form: form,
                  material: material,
                  sex: '',
                  stand: '',
                  gestus: '',
                  text: '',
                  data_title: data_title,
                  data_sex: '',
                  data_stand: '',
                  data_gestus: '',
                  data_farbe: data_farbe,
                  data_form: data_form,
                  data_material: data_material,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 10:
              getAddData(data, d.form[0]).then(function (result) {
                data_form += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: farbe,
                  form: form,
                  material: material,
                  sex: '',
                  stand: '',
                  gestus: '',
                  text: '',
                  data_title: data_title,
                  data_sex: '',
                  data_stand: '',
                  data_gestus: '',
                  data_farbe: data_farbe,
                  data_form: data_form,
                  data_material: data_material,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 100:
              getAddData(data, d.farbe[0]).then(function (result) {
                data_farbe += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: farbe,
                  form: form,
                  material: material,
                  sex: '',
                  stand: '',
                  gestus: '',
                  text: '',
                  data_title: data_title,
                  data_sex: '',
                  data_stand: '',
                  data_gestus: '',
                  data_farbe: data_farbe,
                  data_form: data_form,
                  data_material: data_material,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 1000:
              getAddData(data, d.material[0]).then(function (result) {
                data_material += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: farbe,
                  form: form,
                  material: material,
                  sex: '',
                  stand: '',
                  gestus: '',
                  text: '',
                  data_title: data_title,
                  data_sex: '',
                  data_stand: '',
                  data_gestus: '',
                  data_farbe: data_farbe,
                  data_form: data_form,
                  data_material: data_material,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 1001: // name, material
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.material[0]).then(function (result) {
                  data_material += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 11: // name form
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.form[0]).then(function (result) {
                  data_form += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 101: // name farbe
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.farbe[0]).then(function (result) {
                  data_farbe += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 110: // form farbe
              getAddData(data, d.form[0]).then(function (result) {
                data_form += result;
                getAddData(data, d.farbe[0]).then(function (result) {
                  data_farbe += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 1100: // farbe material
              getAddData(data, d.farbe[0]).then(function (result) {
                data_farbe += result;
                getAddData(data, d.material[0]).then(function (result) {
                  data_material += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 111: // name form farbe
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.form[0]).then(function (result) {
                  data_form += result;
                  getAddData(data, d.farbe[0]).then(function (result) {
                    data_farbe += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: farbe,
                      form: form,
                      material: material,
                      sex: '',
                      stand: '',
                      gestus: '',
                      text: '',
                      data_title: data_title,
                      data_sex: '',
                      data_stand: '',
                      data_gestus: '',
                      data_farbe: data_farbe,
                      data_form: data_form,
                      data_material: data_material,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1110: // form farbe material
              getAddData(data, d.form[0]).then(function (result) {
                data_form += result;
                getAddData(data, d.farbe[0]).then(function (result) {
                  data_farbe += result;
                  getAddData(data, d.material[0]).then(function (result) {
                    data_material += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: farbe,
                      form: form,
                      material: material,
                      sex: '',
                      stand: '',
                      gestus: '',
                      text: '',
                      data_title: data_title,
                      data_sex: '',
                      data_stand: '',
                      data_gestus: '',
                      data_farbe: data_farbe,
                      data_form: data_form,
                      data_material: data_material,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1101:  // name farbe material
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.farbe[0]).then(function (result) {
                  data_farbe += result;
                  getAddData(data, d.material[0]).then(function (result) {
                    data_material += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: farbe,
                      form: form,
                      material: material,
                      sex: '',
                      stand: '',
                      gestus: '',
                      text: '',
                      data_title: data_title,
                      data_sex: '',
                      data_stand: '',
                      data_gestus: '',
                      data_farbe: data_farbe,
                      data_form: data_form,
                      data_material: data_material,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1011: // name form material
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.form[0]).then(function (result) {
                  data_form += result;
                  getAddData(data, d.material[0]).then(function (result) {
                    data_material += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: farbe,
                      form: form,
                      material: material,
                      sex: '',
                      stand: '',
                      gestus: '',
                      text: '',
                      data_title: data_title,
                      data_sex: '',
                      data_stand: '',
                      data_gestus: '',
                      data_farbe: data_farbe,
                      data_form: data_form,
                      data_material: data_material,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1111: // name form farbe material
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.form[0]).then(function (result) {
                  data_form += result;
                  getAddData(data, d.farbe[0]).then(function (result) {
                    data_farbe += result;
                    getAddData(data, d.material[0]).then(function (result) {
                      data_material += result;
                      deferred.resolve({
                        id: i,
                        number: d.id,
                        title: title,
                        farbe: farbe,
                        form: form,
                        material: material,
                        sex: '',
                        stand: '',
                        gestus: '',
                        text: '',
                        data_title: data_title,
                        data_sex: '',
                        data_stand: '',
                        data_gestus: '',
                        data_farbe: data_farbe,
                        data_form: data_form,
                        data_material: data_material,
                        data_text: '',
                        group: d.type,
                        imageRect: imageRect,
                        imagePoint: imagePoint,
                        tagRect: tagRect,
                        tagPoint: tagPoint


                      });
                    });
                  });
                });
              });
              break;
            default:
              deferred.resolve({
                id: i,
                number: d.id,
                title: title,
                farbe: farbe,
                form: form,
                material: material,
                sex: '',
                stand: '',
                gestus: '',
                text: '',
                data_title: data_title,
                data_sex: '',
                data_stand: '',
                data_gestus: '',
                data_farbe: data_farbe,
                data_form: data_form,
                data_material: data_material,
                data_text: '',
                group: d.type,
                imageRect: imageRect,
                imagePoint: imagePoint,
                tagRect: tagRect,
                tagPoint: tagPoint


              });
          };
          break;

        case 'Kleidung':
          var title = 'Kleidung';
          var data_title = '';
          var farbe = '';
          var data_farbe = '';
          var form = '';
          var data_form = '';
          var material = '';
          var data_material= '';

          var counter = 0;

          if (d.name) {
            title = d.name[0].value;
            counter += 1;
          }
          if (d.form) {
            form = d.form[0].value;
            counter += 10;
          }
          if (d.farbe) {
            farbe = d.farbe[0].value;
            counter += 100;
          }
          if (d.material) {
            material = d.material[0].value;
            counter += 1000;
          }
          //console.log(counter + " " +d.id)
          switch (counter) {
            case 0:
              deferred.resolve({
                id: i,
                number: d.id,
                title: title,
                farbe: farbe,
                form: form,
                material: material,
                sex: '',
                stand: '',
                gestus: '',
                text: '',
                data_title: data_title,
                data_sex: '',
                data_stand: '',
                data_gestus: '',
                data_farbe: data_farbe,
                data_form: data_form,
                data_material: data_material,
                data_text: '',
                group: d.type,
                imageRect: imageRect,
                imagePoint: imagePoint,
                tagRect: tagRect,
                tagPoint: tagPoint


              });
              break;
            case 1:
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: farbe,
                  form: form,
                  material: material,
                  sex: '',
                  stand: '',
                  gestus: '',
                  text: '',
                  data_title: data_title,
                  data_sex: '',
                  data_stand: '',
                  data_gestus: '',
                  data_farbe: data_farbe,
                  data_form: data_form,
                  data_material: data_material,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 10:
              getAddData(data, d.form[0]).then(function (result) {
                data_form += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: farbe,
                  form: form,
                  material: material,
                  sex: '',
                  stand: '',
                  gestus: '',
                  text: '',
                  data_title: data_title,
                  data_sex: '',
                  data_stand: '',
                  data_gestus: '',
                  data_farbe: data_farbe,
                  data_form: data_form,
                  data_material: data_material,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 100:
              getAddData(data, d.farbe[0]).then(function (result) {
                data_farbe += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: farbe,
                  form: form,
                  material: material,
                  sex: '',
                  stand: '',
                  gestus: '',
                  text: '',
                  data_title: data_title,
                  data_sex: '',
                  data_stand: '',
                  data_gestus: '',
                  data_farbe: data_farbe,
                  data_form: data_form,
                  data_material: data_material,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 1000:
              getAddData(data, d.material[0]).then(function (result) {
                data_material += result;
                deferred.resolve({
                  id: i,
                  number: d.id,
                  title: title,
                  farbe: farbe,
                  form: form,
                  material: material,
                  sex: '',
                  stand: '',
                  gestus: '',
                  text: '',
                  data_title: data_title,
                  data_sex: '',
                  data_stand: '',
                  data_gestus: '',
                  data_farbe: data_farbe,
                  data_form: data_form,
                  data_material: data_material,
                  data_text: '',
                  group: d.type,
                  imageRect: imageRect,
                  imagePoint: imagePoint,
                  tagRect: tagRect,
                  tagPoint: tagPoint


                });
              });
              break;
            case 1001: // name, material
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.material[0]).then(function (result) {
                  data_material += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 11: // name form
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.form[0]).then(function (result) {
                  data_form += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 101: // name farbe
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.farbe[0]).then(function (result) {
                  data_farbe += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 110: // form farbe
              getAddData(data, d.form[0]).then(function (result) {
                data_form += result;
                getAddData(data, d.farbe[0]).then(function (result) {
                  data_farbe += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 1100: // farbe material
              getAddData(data, d.farbe[0]).then(function (result) {
                data_farbe += result;
                getAddData(data, d.material[0]).then(function (result) {
                  data_material += result;
                  deferred.resolve({
                    id: i,
                    number: d.id,
                    title: title,
                    farbe: farbe,
                    form: form,
                    material: material,
                    sex: '',
                    stand: '',
                    gestus: '',
                    text: '',
                    data_title: data_title,
                    data_sex: '',
                    data_stand: '',
                    data_gestus: '',
                    data_farbe: data_farbe,
                    data_form: data_form,
                    data_material: data_material,
                    data_text: '',
                    group: d.type,
                    imageRect: imageRect,
                    imagePoint: imagePoint,
                    tagRect: tagRect,
                    tagPoint: tagPoint


                  });
                });
              });
              break;
            case 111: // name form farbe
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.form[0]).then(function (result) {
                  data_form += result;
                  getAddData(data, d.farbe[0]).then(function (result) {
                    data_farbe += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: farbe,
                      form: form,
                      material: material,
                      sex: '',
                      stand: '',
                      gestus: '',
                      text: '',
                      data_title: data_title,
                      data_sex: '',
                      data_stand: '',
                      data_gestus: '',
                      data_farbe: data_farbe,
                      data_form: data_form,
                      data_material: data_material,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1110: // form farbe material
              getAddData(data, d.form[0]).then(function (result) {
                data_form += result;
                getAddData(data, d.farbe[0]).then(function (result) {
                  data_farbe += result;
                  getAddData(data, d.material[0]).then(function (result) {
                    data_material += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: farbe,
                      form: form,
                      material: material,
                      sex: '',
                      stand: '',
                      gestus: '',
                      text: '',
                      data_title: data_title,
                      data_sex: '',
                      data_stand: '',
                      data_gestus: '',
                      data_farbe: data_farbe,
                      data_form: data_form,
                      data_material: data_material,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1101:  // name farbe material
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.farbe[0]).then(function (result) {
                  data_farbe += result;
                  getAddData(data, d.material[0]).then(function (result) {
                    data_material += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: farbe,
                      form: form,
                      material: material,
                      sex: '',
                      stand: '',
                      gestus: '',
                      text: '',
                      data_title: data_title,
                      data_sex: '',
                      data_stand: '',
                      data_gestus: '',
                      data_farbe: data_farbe,
                      data_form: data_form,
                      data_material: data_material,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1011: // name form material
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.form[0]).then(function (result) {
                  data_form += result;
                  getAddData(data, d.material[0]).then(function (result) {
                    data_material += result;
                    deferred.resolve({
                      id: i,
                      number: d.id,
                      title: title,
                      farbe: farbe,
                      form: form,
                      material: material,
                      sex: '',
                      stand: '',
                      gestus: '',
                      text: '',
                      data_title: data_title,
                      data_sex: '',
                      data_stand: '',
                      data_gestus: '',
                      data_farbe: data_farbe,
                      data_form: data_form,
                      data_material: data_material,
                      data_text: '',
                      group: d.type,
                      imageRect: imageRect,
                      imagePoint: imagePoint,
                      tagRect: tagRect,
                      tagPoint: tagPoint


                    });
                  });
                });
              });
              break;
            case 1111: // name form farbe material
              getAddData(data, d.name[0]).then(function (result) {
                data_title += result;
                getAddData(data, d.form[0]).then(function (result) {
                  data_form += result;
                  getAddData(data, d.farbe[0]).then(function (result) {
                    data_farbe += result;
                    getAddData(data, d.material[0]).then(function (result) {
                      data_material += result;
                      deferred.resolve({
                        id: i,
                        number: d.id,
                        title: title,
                        farbe: farbe,
                        form: form,
                        material: material,
                        sex: '',
                        stand: '',
                        gestus: '',
                        text: '',
                        data_title: data_title,
                        data_sex: '',
                        data_stand: '',
                        data_gestus: '',
                        data_farbe: data_farbe,
                        data_form: data_form,
                        data_material: data_material,
                        data_text: '',
                        group: d.type,
                        imageRect: imageRect,
                        imagePoint: imagePoint,
                        tagRect: tagRect,
                        tagPoint: tagPoint


                      });
                    });
                  });
                });
              });
              break;
            default:
              deferred.resolve({
                id: i,
                number: d.id,
                title: title,
                farbe: farbe,
                form: form,
                material: material,
                sex: '',
                stand: '',
                gestus: '',
                text: '',
                data_title: data_title,
                data_sex: '',
                data_stand: '',
                data_gestus: '',
                data_farbe: data_farbe,
                data_form: data_form,
                data_material: data_material,
                data_text: '',
                group: d.type,
                imageRect: imageRect,
                imagePoint: imagePoint,
                tagRect: tagRect,
                tagPoint: tagPoint


              });
          };
          break;

        default:
          deferred.resolve({
            id: d.id
          });
      }
      //console.log(deferred.promise);
      return deferred.promise;
      /*
       return {
       id: d.id,
       title: d.id,
       group: d.type,
       image: config.imageBaseUrl +'7019493.tif&amp;WID=2459.311641155794&amp;HEI=2958.9041095890407&amp;RGN=0.6509158292352646,0.43055555555555547,0.16372080868552974,0.47500000000000003&amp;CVT=JPG'


       };*/
    };

    return {
      getData: getData,
      getLexiconPathData: getLexiconPathData,
      getLexiconData: getLexiconData,
      mapSex: mapSex,
    };
  }]);
});