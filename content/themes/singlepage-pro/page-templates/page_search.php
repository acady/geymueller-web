<?php /* Template Name: Suchseite */
  add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');
  get_header();
?>

  <script type="text/ng-template" id="/pathview.html">
    <div class="row">
      <div class="col-sm-6 treeView">
        <treecontrol class="tree-light" tree-model="treedata" expanded-nodes="expandedNodes"
                     on-selection="showSelected(node)" selected-node="selectedTreeData">
          <i>{{node.group}}: </i><span class="data_title">{{node.title}}</span> <span
              class="data_e_value">({{node.number}})</span>
        </treecontrol>
      </div>
      <div class="col-sm-6">
        <div class="pathview-container" id="path_attributes">
          <span ng-bind-html="selectedTreeData.title" class="data_title_value"></span>
          <span class="data_e_value" ng-bind-html="trustAsHtml(selectedTreeData.number)"></span>
          <br>
          <div class="text-left">
            <i class="data_attr_group" ng-bind-html="trustAsHtml(selectedTreeData.group)"></i>
          </div>
          <hr>
          <span ng-if="selectedTreeData.title">Name:
            <span class="data_attr" ng-bind-html="trustAsHtml(selectedTreeData.title)"></span>
            <br/>
          </span>
          <span ng-if="selectedTreeData.data_title">
            <button ng-if="selectedTreeData.data_title" type="button"
                  class="btn btn-default btn-add-data-text" ng-click="toggleTitleCollapsed()">
            <div class="btn-add-data-text-title">{{selectedTreeData.data_title}}</div>3
            </button>
            <br/>
            <div uib-collapse="!titleCollapsed">
              <div class="data_attr_more"
                   ng-bind-html="trustAsHtml(selectedTreeData.data_title)"></div>
            </div>
          </span>

          <span ng-if="selectedTreeData.sex">Geschlecht:
            <span class="data_attr" ng-bind-html="trustAsHtml(selectedTreeData.sex)"></span>
            <br/>
            <button ng-if="selectedTreeData.data_sex" type="button"
                    class="btn btn-default btn-add-data-text" ng-click="toggleSexCollapsed()">
              <div class="btn-add-data-text-title">{{selectedTreeData.data_sex}}</div>
            </button>
            <br/>
            <div uib-collapse="!sexCollapsed">
              <div class="data_attr_more" ng-bind-html="trustAsHtml(selectedTreeData.data_sex)"></div>
            </div>
          </span>

          <span ng-if="selectedTreeData.stand">dStand:
            <span class="data_attr" ng-bind-html="trustAsHtml(selectedTreeData.stand)"></span>
            <br/>
            <button ng-if="selectedTreeData.data_stand" type="button"
                    class="btn btn-default btn-add-data-text" ng-click="toggleStandCollapsed()">
              <div class="btn-add-data-text-title">{{selectedTreeData.data_stand}}</div>
            </button>
            <br/>
            <div uib-collapse="!standCollapsed">
              <div class="data_attr_more" ng-bind-html="trustAsHtml(selectedTreeData.data_stand)"></div>
            </div>
          </span>

          <span ng-if="selectedTreeData.gestus">Gestus:
            <span class="data_attr" ng-bind-html="trustAsHtml(selectedTreeData.gestus)"></span>
            <br/>
            <button ng-if="selectedTreeData.data_gestus" type="button"
                    class="btn btn-default btn-add-data-text" ng-click="toggleGestusCollapsed()">
              <div class="btn-add-data-text-title">{{selectedTreeData.data_gestus}}</div>
            </button>
            <br/>
            <div uib-collapse="!gestusCollapsed">
              <div class="data_attr_more" ng-bind-html="trustAsHtml(selectedTreeData.data_gestus)"></div>
            </div>
          </span>

          <span ng-if="selectedTreeData.farbe">Farbe:
            <span class="data_attr" ng-bind-html="trustAsHtml(selectedTreeData.farbe)"></span>
            <br/>
            <button ng-if="selectedTreeData.data_farbe" type="button"
                    class="btn btn-default btn-add-data-text" ng-click="toggleFarbeCollapsed()"">
              <div class="btn-add-data-text-title">{{selectedTreeData.data_farbe}}</div>
            </button>
            <br/>
            <div uib-collapse="!farbeCollapsed">
              <div class="data_attr_more" ng-bind-html="trustAsHtml(selectedTreeData.data_farbe)"></div>
            </div>
          </span>

          <span ng-if="selectedTreeData.form">Form:
            <span class="data_attr" ng-bind-html="trustAsHtml(selectedTreeData.form)"></span>
            <br/>
            <button ng-if="selectedTreeData.data_form" type="button"
                    class="btn btn-default btn-add-data-text" ng-click="toggleFormCollapsed()">
              <div class="btn-add-data-text-title">{{selectedTreeData.data_form}}</div>
            </button>
            <br/>

            <div uib-collapse="!formCollapsed">
              <div class="data_attr_more" ng-bind-html="trustAsHtml(selectedTreeData.data_form)"></div>
            </div>
          </span>

          <span ng-if="selectedTreeData.material">Material:
            <span class="data_attr" ng-bind-html="trustAsHtml(selectedTreeData.material)"></span>
            <br/>
            <button ng-if="selectedTreeData.data_material" type="button"
                    class="btn btn-default btn-add-data-text" ng-click="toggleMaterialCollapsed()">
              <div class="btn-add-data-text-title">{{selectedTreeData.data_material}}</div>
            </button>
            <br/>
            <div uib-collapse="!materialCollapsed">
              <div class="data_attr_more" ng-bind-html="trustAsHtml(selectedTreeData.data_material)"></div>
            </div>
          </span>

          <span ng-if="selectedTreeData.text">Text:
            <span class="data_attr" ng-bind-html="trustAsHtml(selectedTreeData.text)"></span>
            <br/>
            <button ng-if="selectedTreeData.data_text" type="button"
                    class="btn btn-default btn-add-data-text" ng-click="toggleTextCollapsed()">
              <div class="btn-add-data-text-title">{{selectedTreeData.data_text}}</div>
            </button>
            <br/>
            <div uib-collapse="!textCollapsed">
              <div class="data_attr_more" ng-bind-html="trustAsHtml(selectedTreeData.data_text)"></div>
            </div>
          </span>

          <hr>

          <img ng-if="selectedTreeData.imageRect" class="attr_tree_image"
               ng-src="{{selectedTreeData.imageRect | ampersandhtml}}" alt="Rechteck Tag">
          <br/>
          <img ng-if="selectedTreeData.imagePoint" class="attr_tree_image"
               ng-src="{{selectedTreeData.imagePoint | ampersandhtml}}" alt="Point Tag"/>
        </div>
      </div>
    </div>
  </script>

  <script type="text/ng-template" id="/geobrowser.html">
    <div id="map" class="map">
    </div>
  </script>

  <script type="text/ng-template" id="/expertsearch.html">

    <a href="http://realonline.imareal.sbg.ac.at/browser/" class="button" target="_blank">Cypher
      Abfrage</a>
    <!--<button href="http://localhost:8474/browser/" formtarget="_blank">Cypher Abfrage</button>-->

    <textarea class="expertsearch"
              placeholder="Geben Sie hier Ihre Archivnummern ein..."></textarea>
    </div>
  </script>

  <script type="text/ng-template" id="/quellemodal.html">
    <div class="modal-header">
      <button type="button" class="close" ng-click="$close()">&times;</button>
      <h3>{{quelle}}</h3>
    </div>
    <div class="modal-body">
      <div ng-repeat="verse in quellecontent.verses"><span class="additional_info_small ng-scope">{{verse.id}}:</span>
        {{verse.value}}
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" ng-click="$close()">
        Schlie&szlig;en
      </button>
    </div>
  </script>

  <script type="text/ng-template" id="/savemodal.html">
    <div class="modal-header">
      <button type="button" class="close" ng-click="$close()">&times;</button>
      <h3>Speichern</h3>
    </div>
    <div class="modal-body">
      <form>
        <div class="form-group">
          <label for="saveName">Name</label>
          <input type="text" class="form-control" id="saveName" ng-model="saveForm.saveName">
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-default" ng-click="save($close);">
        Speichern
      </button>
      <button type="button" class="btn btn-default" ng-click="$close()">
        Schlie&szlig;en
      </button>
    </div>
  </script>

  <script type="text/ng-template" id="/loadmodal.html">
    <div class="modal-header">
      <button type="button" class="close" ng-click="$close()">&times;</button>
      <h3>Laden</h3>
    </div>
    <div class="modal-body">
      <div ng-repeat="(savingName, saving) in savings">
        <a href="" ng-click="load(saving); $close()">{{savingName}}</a>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" ng-click="$close()">
        Schlie&szlig;en
      </button>
    </div>
  </script>

  <script type="text/ng-template" id="/modal.html">
    <div class="modal-header">

      <button type="button" class="close" ng-click="$close()" ng-if="!hideClose">&times;</button>
      <div class="row hit-image-modal-header-content">
        <div class="hit-image-modal-header-name" ng-repeat="thema in hit.bildthema track by $index">
          {{ hit.archivnr }} {{ thema }}
        </div>
        <div class="hit-image-modal-header-year">
          {{ hit.post }} - {{ hit.ante }}
        </div>
        <div class="hit-image-modal-header-actions">
          <add-to-cart-button product="hit"></add-to-cart-button>
          <add-to-wishlist-button product="hit"></add-to-wishlist-button>
        </div>
      </div>
    </div>
    <div class="modal-body">
      <uib-tabset ng-if="ensembles.length || alternativImages.length || detailImages.length"
                  class="tab-container">
        <uib-tab ng-if="ensembles.length">
          <uib-tab-heading>
            <span class="menu-icon-ensemble" data-icon="&#xe9bc;"></span>Ensemblebilder: {{
            hit.ensemble }}
          </uib-tab-heading>
          <div class="row">
            <div class="imagepreview-column" ng-repeat="ensemble in ensembles">
              <img ng-src="{{ retrieveImageUrl(ensemble) }}"
                   ng-click="$close();openModal(ensemble);"
                   class="img-responsive">
            </div>
          </div>
        </uib-tab>
        <uib-tab ng-if="alternativImages.length">
          <uib-tab-heading>
            <span class="menu-icon-ensemble" data-icon="&#xe010;"></span>Alternativbilder
          </uib-tab-heading>
          <div class="row">
            <div class="imagepreview-column" ng-repeat="ensemble in alternativImages">
              <img ng-src="{{ retrieveImageUrl(ensemble) }}" class="img-responsive">
            </div>
          </div>
        </uib-tab>
        <uib-tab ng-if="detailImages.length">
          <uib-tab-heading>
            <span class="menu-icon-ensemble" data-icon="&#xe010;"></span>Detailbilder
          </uib-tab-heading>
          <div class="row">
            <!-- kaputt! -->
            <div class="imagepreview-column" ng-repeat="ensemble in detailImages">
              <img ng-src="{{ retrieveImageUrl(ensemble) }}" class="img-responsive">
            </div>
          </div>
        </uib-tab>
      </uib-tabset>
      <uib-tabset>
        <uib-tab>
          <uib-tab-heading>
            <span class="menu-icon-ensemble" data-icon="&#xe049;"></span>Tagged View
          </uib-tab-heading>
          <taggedview hit="hit" data="data"></taggedview>
          <br/>
        </uib-tab>
        <!-- ZOOM VIEW -->

        <uib-tab>
          <uib-tab-heading>
            <span class="menu-icon-ensemble" data-icon="&#xe902;"></span>Zoom View
          </uib-tab-heading>
          <center ng-if="hideZoomImage">
            <img src="<?php echo get_template_directory_uri(); ?>/images/no-image.jpg"/>
          </center>
          <div class="hit-image-modal" ng-if="!hideZoomImage"></div>
        </uib-tab>

      </uib-tabset>
      <uib-tabset>
        <uib-tab>

          <uib-tab-heading>
            Visueller Graph <img
                src="<?php echo get_template_directory_uri(); ?>/images/visualgraph.png"/>
          </uib-tab-heading>
          <div class="d3-graph">
          </div>
        </uib-tab>
        <uib-tab>
          <uib-tab-heading>
            Listenansicht <img
                src="<?php echo get_template_directory_uri(); ?>/images/pathview.png"/>
          </uib-tab-heading>
          <pathview hit="hit" data="data"></pathview>
        </uib-tab>
        <uib-tab>
          <uib-tab-heading>
            Volltextansicht <img
                src="<?php echo get_template_directory_uri(); ?>/images/fulltextview.png"/>
          </uib-tab-heading>


          <h3>Werksdaten</h3>
          <div class="row">
            <div class="col-sm-12">
              <h4>Allgemeines</h4>
              <span class="additional_info_medium">Archivnummer: </span> {{ hit.archivnr }}</p>
              <p><span class="additional_info_medium">persistent link: </span> <a
                    href="detail/?archivnr={{ hit.archivnr }}">Zum Datensatz {{ hit.archivnr }}</a>
              <p><span class="additional_info_medium">Literatur: </span>
              <div ng-repeat="hit_literatur in hit.literatur track by $index"
                   ng-bind-html="hit_literatur | highlight:searchkeyword"></div>
              </p>

            </div>
          </div>
          <div class="row">
            <div class="col-sm-4"><h4>Themen</h4>
              <p><span class="additional_info_medium">Bildthema: </span><span
                    ng-repeat="hit_bildthema in hit.bildthema track by $index"
                    ng-bind-html="hit_bildthema | highlight:searchkeyword"> </span></p>
              <p><span class="additional_info_medium">Anbringung: </span><span
                    ng-repeat="hit_anbringung in hit.anbringung track by $index"
                    ng-bind-html="hit_anbringung | highlight:searchkeyword">  </span></p>
              <p><span class="additional_info_medium">Quelle: </span>
              <div ng-repeat="hit_quelle in hit.quelle track by $index"
                   ng-bind-html="hit_quelle | highlight:searchkeyword"></div>
              </p>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4"><h4>Herstellung</h4>
              <p><span class="additional_info_medium">KünsterIn: </span>
              <div ng-repeat="hit_kuenstler in hit.kuenstler track by $index"
                   ng-bind-html="hit_kuenstler | highlight:searchkeyword"></div>
              </p>
              <p><span class="additional_info_medium">Material/Technik: </span>
              <div ng-repeat="hit_material_technik in hit.material_technik track by $index"
                   ng-bind-html="hit_material_technik | highlight:searchkeyword"></div>
              </p>
              <p><span class="additional_info_medium">Entstehungsort: </span>
              <div ng-repeat="hit_entstehungsort in hit.entstehungsort track by $index"
                   ng-bind-html="hit_entstehungsort | highlight:searchkeyword"></div>
              </p>
              <p><span class="additional_info_medium">Datierung: </span><span
                    ng-bind-html="hit.datierung | highlight:searchkeyword">  </span></p>
              <p><span class="additional_info_medium">Ante: </span><span
                    ng-bind-html="hit.ante | highlight:searchkeyword"> </span></p>
              <p><span class="additional_info_medium">Post: </span><span
                    ng-bind-html="hit.post | highlight:searchkeyword"> </span></p>
            </div>

            <div class="col-sm-4"><h4>Bildträger</h4>
              <!--<p><span class="additional_info_medium">Material:</span> <div ng-repeat="hit_material in hit.material track by $index">{{ hit_material }}</div></p>
                            <p><span class="additional_info_medium">Technik:</span><div ng-repeat="hit_technik in hit.technik track by $index"> {{ hit_technik }}</div></p>-->
              <p><span class="additional_info_medium">Material: </span><span
                    ng-bind-html="hit.material | highlight:searchkeyword"> </span></p>
              <p><span class="additional_info_medium">Technik: </span><span
                    ng-bind-html="hit.technik | highlight:searchkeyword"> </span></p>
              <p><span class="additional_info_medium">Objektart: </span><span
                    ng-repeat="hit_objektart in hit.objektart track by $index"
                    ng-bind-html="hit_objektart | highlight:searchkeyword">  </span></p>
              <p><span class="additional_info_medium">Objektgruppe: </span><span
                    ng-bind-html="hit.objektgruppe | highlight:searchkeyword">  </span></p>
              <p><span class="additional_info_medium">Motivtypus: </span><span
                    ng-bind-html="hit.motivtypus | highlight:searchkeyword">  </span></p>
              <p><span class="additional_info_medium">sakral/profan: </span><span
                    ng-bind-html="hit.sakral_profan | highlight:searchkeyword">  </span></p>
              <p><span class="additional_info_medium">Gebäude Kontext: </span><span
                    ng-bind-html="hit.gebaeudekontext | highlight:searchkeyword">  </span></p>
              <p><span class="additional_info_medium">Form: </span><span
                    ng-bind-html="hit.form | highlight:searchkeyword">  </span></p>
              <p><span class="additional_info_medium">Maße: </span><span
                    ng-repeat="hit_masze in hit.masze track by $index"
                    ng-bind-html="hit_masze | highlight:searchkeyword">  </span></p>
              <p><span class="additional_info_medium">Ensemble: </span><span
                    ng-bind-html="hit.ensemble | highlight:searchkeyword">  </span></p>
            </div>

            <div class="col-sm-4"><h4>Lokalisierung</h4>
              <p><span class="additional_info_medium">Staat: </span><span
                    ng-bind-html="hit.staat | highlight:searchkeyword"> </span></p>
              <p><span class="additional_info_medium">Bundesland: </span><span
                    ng-bind-html=" hit.bundesland | highlight:searchkeyword">  </span></p>
              <p><span class="additional_info_medium">Standort: </span><span
                    ng-bind-html="hit.standort  | highlight:searchkeyword"> </span></p>
              <p><span class="additional_info_medium">Institution: </span><span
                    ng-repeat="hit_institution in hit.institution track by $index"
                    ng-bind-html="hit_institution | highlight:searchkeyword">  </span></p>
              <p><span class="additional_info_medium">Herkunft: </span><span
                    ng-bind-html="hit.herkunft | highlight:searchkeyword">  </span></p>
              <p><span class="additional_info_medium">InvNr: </span><span
                    ng-repeat="hit_invnr in hit.invnr track by $index"
                    ng-bind-html="hit_invnr | highlight:searchkeyword">  </span></p>
              <p><span class="additional_info_medium">Fol: </span><span
                    ng-repeat="hit_fol in hit.fol track by $index"
                    ng-bind-html="hit_fol | highlight:searchkeyword">  </span>
              </p>
              <p><span class="additional_info_medium">Provenienz: </span><span
                    ng-repeat="hit_provenienz in hit.provenienz track by $index"
                    ng-bind-html="hit_provenienz | highlight:searchkeyword">  </span></p>
              <p><span class="additional_info_medium">Negativ: </span><span
                    ng-bind-html=" hit.negativnr | highlight:searchkeyword">  </span></p>
              <p><span class="additional_info_medium">Dia Nr.: </span><span
                    ng-repeat="hit_dianr in hit.dianr track by $index"
                    ng-bind-html="hit_dianr | highlight:searchkeyword"
                    ng-style="{'padding-right':'10px'}"></span></p>
            </div>
          </div>
          <!--      <p>{{ hit.ensemble }}</p>
                          <p>{{ hit.objektgruppe }}</p>
                          <p>{{ hit.masze }}</p>
                          <p>Standort: {{ hit.standort }}</p>
                          <p>Provenienz: {{ hit.provenienz }}</p>
                          <p>Institution: {{ hit.institution }}</p>
                          <p>Bundesland: {{ hit.bundesland }}</p>
                          <p>Staat: {{ hit.staat }}</p>
                          <p>Herkunft: {{ hit.herkunft }}</p>
                          -->
          <h3>Beschreibungen</h3>
          <div class="additional_full">

    <span ng-repeat="volltextEntity in volltextData.description.entities track by $index">
      <!--<span class="additional_info_id_full">{{volltextEntity.id}}</span>-->
      <span ng-repeat="(key, value) in volltextEntity track by $index">
          <i class="additional_info_small">{{key}}</i><span ng-if="key === 'id' || key === 'type'"
                                                            class="additional_info_medium"
                                                            ng-bind-html=" value | highlight:searchkeyword"></span>
        <span ng-repeat="(key, value) in value track by $index">
          <span ng-bind-html=" value.key | highlight:searchkeyword"> </span> <span
              ng-bind-html=" value.value | highlight:searchkeyword"> </span>
        </span>
      </span>
    </span>
          </div>
          <h3>Beziehungen</h3>
          <!-- ein span hier und es gibt keine zeilenumbrüche -->
          <div ng-repeat="volltextRelation in volltextData.description.relations track by $index">
            <span class="additional_info_small_e">{{volltextData.description.entities[volltextRelation[0]].id}} </span>
            <span
                class="additionieral_info_medium">{{volltextData.description.entities[volltextRelation[0]].type}}</span>
            <span
                ng-repeat="(key, value) in volltextData.description.entities[volltextRelation[0]] track by $index">
        <span ng-if="key !== 'id' && key !== 'type'" class="additional_info_small">{{key}}</span>
        <span ng-repeat="(key, value) in value track by $index"
              ng-bind-html=" value.value | highlight:searchkeyword"></span>
      </span>
            - {{ volltextRelation[2] }} -
            <span class="additional_info_small_e">{{volltextData.description.entities[volltextRelation[1]].id}} </span>
            <span class="additional_info_medium">{{volltextData.description.entities[volltextRelation[1]].type}}</span>
            <span
                ng-repeat="(key, value) in volltextData.description.entities[volltextRelation[1]] track by $index">
        <span ng-if="key !== 'id' && key !== 'type'" class="additional_info_small">{{key}}</span>
        <span ng-if="key !== 'sex'">
          <span ng-repeat="(key, value) in value track by $index"
                ng-bind-html=" value.value | highlight:searchkeyword"></span>
        </span>
        <span ng-if="key === 'sex'">
          <!-- TO DO map keys http://stackoverflow.com/questions/21110428/angularjs-ng-if-function-call-from-same-controller-not-working -->
          <span ng-repeat="(key, value) in value track by $index"
                ng-bind-html=" value.value | highlight:searchkeyword"></span>
        </span>

      </span>
            <!--<br/>-->
          </div>
        </uib-tab>
      </uib-tabset>
      <h2 class="hit-description">{{ hit._highlightResult.beschreibung.value }}</h2>
      <uib-tabset>
        <uib-tab>
          <uib-tab-heading>
            Informationen zum Datensatz<!--<span ng-bind-html="hit.objekt | trusted_html"></span>-->
          </uib-tab-heading>
          <p><span class="additional_info_medium">Archivnummer:</span> {{ hit.archivnr }}</p>
          <p><span class="additional_info_medium">persistent link:</span> <a
                href="detail/?archivnr={{ hit.archivnr }}">Zum
              Datensatz {{ hit.archivnr }}</a>
          <p><span class="additional_info_medium">Literatur:</span>
          <div ng-repeat="hit_literatur in hit.literatur track by $index"> {{ hit_literatur }}</div>
          </p>
        </uib-tab>
        <uib-tab heading="Themen">
          <p><span class="additional_info_medium">Bildthema:</span><span
                ng-repeat="hit_bildthema in hit.bildthema track by $index"> {{ hit_bildthema }} </span>
          </p>
          <p><span class="additional_info_medium">Anbringung:</span>
          <div ng-repeat="hit_anbringung in hit.anbringung track by $index"> {{ hit_anbringung }}
          </div>
          </p>
          <p><span class="additional_info_medium">Quelle:</span>
          <div ng-repeat="hit_quelle in hit.quelle track by $index"> {{ hit_quelle }}</div>
          </p>
        </uib-tab>
        <uib-tab heading="Herstellung">
          <p><span class="additional_info_medium">KünsterIn:</span><span
                ng-repeat="hit_kuenstler in hit.kuenstler track by $index"> {{ hit_kuenstler }}</span>
          </p>
          <p><span class="additional_info_medium">Material/Technik:</span><span
                ng-repeat="hit_material_technik in hit.material_technik track by $index"> {{ hit_material_technik }}</span>
          </p>
          <p><span class="additional_info_medium">Entstehungsort:</span><span
                ng-repeat="hit_entstehungsort in hit.entstehungsort track by $index">{{ hit_entstehungsort }}</span>
          </p>
          <p><span class="additional_info_medium">Datierung:</span> {{ hit.datierung }}</p>
          <p><span class="additional_info_medium">Ante:</span> {{ hit.ante }}</p>
          <p><span class="additional_info_medium">Post:</span> {{ hit.post }}</p>
        </uib-tab>
        <uib-tab heading="Bildträger">
          <p><span class="additional_info_medium">Material:</span> {{ hit.material }}</p>
          <p><span class="additional_info_medium">Technik:</span> {{ hit.technik }}</p>
          <p><span class="additional_info_medium">Objektart:</span><span
                ng-repeat="hit_objektart in hit.objektart track by $index"> {{ hit_objektart }}</span>
          </p>
          <p><span class="additional_info_medium">Objektgruppe:</span> {{ hit.objektgruppe }}</p>
          <p><span class="additional_info_medium">Motivtypus:</span> {{ hit.motivtypus }}</p>
          <p><span class="additional_info_medium">sakral/profan:</span> {{ hit.sakral_profan }}</p>
          <p><span class="additional_info_medium">Gebäude Kontext:</span> {{ hit.gebaeudekontext }}
          </p>
          <p><span class="additional_info_medium">Form:</span> {{ hit.form }}</p>
          <p><span class="additional_info_medium">Maße:</span><span
                ng-repeat="hit_masze in hit.masze track by $index"> {{ hit_masze }}</span>
          </p>
          <p><span class="additional_info_medium">Ensemble:</span> {{ hit.ensemble }}</p>

        </uib-tab>
        <uib-tab heading="Lokalisierung">
          <p><span class="additional_info_medium">Staat:</span> {{ hit.staat }}</p>
          <p><span class="additional_info_medium">Bundesland:</span> {{ hit.bundesland }}</p>
          <p><span class="additional_info_medium">Standort:</span> {{ hit.standort }}</p>
          <p><span class="additional_info_medium">Institution:</span><span
                ng-repeat="hit_institution in hit.institution track by $index"> {{ hit_institution }}</span>
          </p>
          <p><span class="additional_info_medium">Herkunft:</span> {{ hit.herkunft }}</p>
          <p><span class="additional_info_medium">InvNr:</span><span
                ng-repeat="hit_invnr in hit.invnr track by $index"> {{ hit_invnr }}</span>
          </p>
          <p><span class="additional_info_medium">Fol:</span><span
                ng-repeat="hit_fol in hit.fol track by $index"> {{ hit_fol }}</span>
          </p>
          <p><span class="additional_info_medium">Provenienz:</span><span
                ng-repeat="hit_provenienz in hit.provenienz track by $index"> {{ hit_provenienz }}</span>
          </p>
          <p><span class="additional_info_medium">Negativ:</span> {{ hit.negativnr }}</p>
          <p><span class="additional_info_medium">Dia Nr.:</span><span
                ng-repeat="hit_dianr in hit.dianr track by $index"> {{ hit_dianr }}</span></p>
        </uib-tab>

        <!--
                <uib-tab heading="Beschreibungen">
                  <uib-tabset class="hit-description-tabs">
                    <uib-tab ng-repeat="(typ, hits) in descriptions">
                      <uib-tab-heading>
                        <span ng-bind-html="typ + ' (' + hits.length + ')' | trusted_html"></span>
                      </uib-tab-heading>
                      <uib-accordion>
                        <div uib-accordion-group ng-repeat="hit in hits | orderBy: 'id'">
                          <uib-accordion-heading>
                            {{hit.id}} {{ hit.Name }} {{ hit.Form }} {{ hit.Ort }} {{ hit.Handlung }} {{ hit.Gestus }} {{ hit.Geschlecht }} {{ hit.Subjektname }}
                          </uib-accordion-heading>
                          <div class="row">
                            <div class="col-sm-3">
                              <h4>Name</h4>
                              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque pretium turpis eget commodo porta. Morbi nec ante ac enim convallis facilisis posuere nec velit. Phasellus vel risus nec lacus auctor vestibulum. Curabitur sapien odio, ullamcorper blandit tristique sit amet, lacinia quis neque. Curabitur eget tellus maximus, pulvinar elit dapibus, egestas enim. Sed vel porta enim. Donec auctor mattis erat, id fermentum augue vestibulum vel. Phasellus malesuada nisi a ligula lobortis, non tristique est convallis. Vestibulum sit amet odio tellus. Nullam egestas nibh et tellus molestie, nec consequat enim ornare. Vivamus convallis magna lacinia eros dapibus condimentum. Pellentesque ut lacus lorem.
                            </div>
                            <div class="col-sm-3">
                              <h4>Geschlecht</h4>
                              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque pretium turpis eget commodo porta. Morbi nec ante ac enim convallis facilisis posuere nec velit. Phasellus vel risus nec lacus auctor vestibulum. Curabitur sapien odio, ullamcorper blandit tristique sit amet, lacinia quis neque. Curabitur eget tellus maximus, pulvinar elit dapibus, egestas enim. Sed vel porta enim. Donec auctor mattis erat, id fermentum augue vestibulum vel. Phasellus malesuada nisi a ligula lobortis, non tristique est convallis. Vestibulum sit amet odio tellus. Nullam egestas nibh et tellus molestie, nec consequat enim ornare. Vivamus convallis magna lacinia eros dapibus condimentum. Pellentesque ut lacus lorem.
                            </div>
                            <div class="col-sm-3">
                              <h4>Stand</h4>
                              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque pretium turpis eget commodo porta. Morbi nec ante ac enim convallis facilisis posuere nec velit. Phasellus vel risus nec lacus auctor vestibulum. Curabitur sapien odio, ullamcorper blandit tristique sit amet, lacinia quis neque. Curabitur eget tellus maximus, pulvinar elit dapibus, egestas enim. Sed vel porta enim. Donec auctor mattis erat, id fermentum augue vestibulum vel. Phasellus malesuada nisi a ligula lobortis, non tristique est convallis. Vestibulum sit amet odio tellus. Nullam egestas nibh et tellus molestie, nec consequat enim ornare. Vivamus convallis magna lacinia eros dapibus condimentum. Pellentesque ut lacus lorem.
                            </div>
                            <div class="col-sm-3">
                              <h4>Gestus</h4>
                              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque pretium turpis eget commodo porta. Morbi nec ante ac enim convallis facilisis posuere nec velit. Phasellus vel risus nec lacus auctor vestibulum. Curabitur sapien odio, ullamcorper blandit tristique sit amet, lacinia quis neque. Curabitur eget tellus maximus, pulvinar elit dapibus, egestas enim. Sed vel porta enim. Donec auctor mattis erat, id fermentum augue vestibulum vel. Phasellus malesuada nisi a ligula lobortis, non tristique est convallis. Vestibulum sit amet odio tellus. Nullam egestas nibh et tellus molestie, nec consequat enim ornare. Vivamus convallis magna lacinia eros dapibus condimentum. Pellentesque ut lacus lorem.
                            </div>
                          </div>
                        </div>
                      </uib-accordion>
                    </uib-tab>
                  </uib-tabset>
                </uib-tab>
                -->
        <uib-tab heading="Alle Werksinformationen">
          <div ng-repeat="(key, value) in volltextData track by $index">
            <i class="additional_info_small" ng-if="key !=='description'">{{key}} :</i>
            <strong ng-if="key ==='archivnr'">{{value}}</strong>
            <span ng-repeat="(key, value) in value track by $index">
      <strong>{{value.value}}</strong>
              <!-- we do not use the thesuarus informmation yet but in future -->
              <!--<i ng-if="value.thesaurus_id" class="additional_info_small">Thes.: </i>{{value.thesaurus_id}}-->
        <i ng-if="value.literatur" class="additional_info_small">Lit.: </i>{{value.literatur}}
        <span ng-repeat="lod_entry in value.lod_entries"><span
              class="additional_info_small">{{lod_entry.source}}:</span> {{lod_entry.id}} </span>
              <!--{{value.lod_entries}}-->
        <span ng-repeat="comment in value.comments">{{comment.source}}: {{comment.id}}</span>
        {{value.comments}}
        <span ng-repeat="flag in value.flags">{{flag.source}}: {{flag.id}}</span>
              <!--{{value.flags}}-->
              <!-- BILDER Flags -->
        <span ng-if="value.flags.primary"> Primärbild </span>
        <span ng-if="value.flags.detail"> Detailbild </span>
        <span ng-if="value.flags.total"> Gesamtbild </span>
        <span ng-if="value.flags.outdated"> veraltet </span>
        <span ng-if="value.flags.remarkable"> bemerkenswert </span>
        <span ng-if="value.flags.questionable"> fraglich </span>
        <span ng-if="value.flags.unconfirmed"> nicht bestätigt </span>

      </span>
            <br/>
          </div>


        </uib-tab>
      </uib-tabset>
    </div>
    <div class="modal-footer" ng-if="!hideClose">
      <button type="button" class="btn btn-default" ng-click="$close()">
        Schlie&szlig;en
      </button>
    </div>
  </script>

  <script type="text/ng-template" id="/addtocart.html">

    <button type="button" class="add-to-cart" ng-click="addToCart()" ng-disabled="addToCartLoading">
      <i class="icon-Realienkunde-_Fotobestellung" ng-hide="addToCartLoading"></i>
      <span ng-show="addToCartLoading">
  <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>
</span>
    </button>

  </script>

  <script type="text/ng-template" id="/addtowishlist.html">

    <button type="button" class="add-to-wishlist" ng-click="openWishlistModal()"
            ng-disabled="addToWishlistLoading">
      <i class="icon-Realienkunde-_Wunschliste" ng-hide="addToWishlistLoading"></i>
      <span ng-if="addToWishlistLoading">
  <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>
</span>
    </button>

  </script>

  <script type="text/ng-template" id="/wishlistmodal.html">
    <div class="modal-header">
      <button type="button" class="close" ng-click="$close()">&times;</button>
    </div>
    <div class="modal-body">
      <form id="add-to-wishlist-form" method="POST" enctype="multipart/form-data" action="">

        <input type="hidden" name="quantity" value="1">
        <input type="hidden" name="wlid" id="wlid" value="session">
        <input type="hidden" name="add-to-wishlist-type" value="simple">

        <ul>
          <li ng-repeat="wishlist in wishlists">
            <button type="button" ng-click="addToWishlist(wishlist)">
              {{wishlist.post.post_title}}
            </button>
          </li>
        </ul>

        <button type="button" ng-click="addToWishlist()" ng-if="!hideAddNewbutton">
          Zu neuen Wunschliste hinzuf&uuml;gen
        </button>

      </form>

    </div>
  </script>

  <script type="text/ng-template" id="/facet.html">
    <facetcontainer facet-title="facetTitle">
      <ul>
        <li ng-repeat="facetValue in searchResult.facet_counts.facet_fields[facetConfig.facetfield] track by $index"
            ng-if="$index % 2 === 0 && $index < 20" class="facet-checkbox facet-line">

          <input type="checkbox" ng-click="toggleFacetValue(facetValue)"
                 ng-checked="isRefined(facetValue)"
                 id="facet-checkbox"/>
          <label for="facet-checkbox"><input type="checkbox"
                                             ng-click="toggleNotFacetValue(facetValue)"
                                             ng-checked="isNot(facetValue)"
                                             id="facet-checkbox-second"/>
          </label><label class="check-exclude" for="facet-checkbox-second"><a href=""
                                                                              class="facet-link toggle-refine"
                                                                              ng-class="{ 'facet-disjunctive': disjunctive, 'facet-refined': isRefined(facetValue) }"
                                                                              ng-click="toggleFacetValue(facetValue)">
              {{ facetValue }}
            </a></label>
          <span class="facet-count">
      <a href="" class="facet-link toggle-refine" ng-click="toggleFacetValue(facetValue)">{{ searchResult.facet_counts.facet_fields[facetConfig.facetfield][$index + 1] }}</a>
      /
      <a href="" class="facet-link toggle-refine" ng-click="expandFacetValue(facetValue)">{{ globalSearchResult.facet_counts.facet_fields_map[facetConfig.facetfield][facetValue] }}</a>
    </span>
        </li>
        <li ng-if="searchResult.facet_counts.facet_fields[facetConfig.facetfield].length >= 20">
          <a href="" ng-click="openFacetModal()" class="facet-link">Mehr anzeigen</a>
        </li>
      </ul>
    </facetcontainer>
  </script>

  <script type="text/ng-template" id="/facetmodal.html">
    <div class="modal-header">
      <button type="button" class="close" ng-click="$close()">&times;</button>
    </div>
    <div class="modal-body">
      <input type="text" ng-model="facetModalFilter" class="form-control">
      <ul>
        <li
            ng-repeat="facetValue in searchResult.facet_counts.facet_fields[facetConfig.facetfield] | filter: filterUnuseful() | filter: facetModalFilter | orderBy: 'toString()' track by $index"
            ng-if="$index % 2 === 0 && $index < 100">
          <a href="" ng-click="toggleFacetValue(facetValue)">
            {{ facetValue }}
          </a>
        </li>
      </ul>
    </div>
  </script>

  <script type="text/ng-template" id="/hierarchicalfacet.html">
    <facetcontainer facet-title="facetTitle">
      <treecontrol class="tree-light" tree-model="treedata">
      <span ng-click="toggleFacetValue(node.originalValue)"
            class="facet-lable-over"><span>{{node.label}}</span></span>
        <span class="facet-count">
    <a href="" class="facet-link toggle-refine" ng-click="toggleFacetValue(node.originalValue)">{{ node.count }}</a>
    /
    <a href="" class="facet-link toggle-refine" ng-click="expandFacetValue(node.originalValue)">{{ globalSearchResult.facet_counts.facet_fields_map[facetConfig.facetfield][node.originalValue] }}</a>
  </span>
      </treecontrol>
    </facetcontainer>
  </script>

  <script type="text/ng-template" id="/facetcontainer.html">
    <div class="facet" ng-class="{open: facetOpen}">
      <h5 ng-bind-html="facetTitle | trusted_html" ng-click="toggleFacetOpen()"></h5>
      <div ng-transclude="" ng-show="facetOpen" class="slide">
      </div>
    </div>
  </script>

  <search index-name="<?php echo get_field('indexname'); ?>" ng-cloak="">
    <div class="search-main-container" ng-repeat="currentSearch in searches track by $index" index="$index" ng-init="searchResultsIndex = $index;">

          <button type="button" class="close" ng-click="removeTab(searchResultsIndex)" ng-if="searches.length > 1">&times;</button>

          <div class="selectedFacets" ng-if="showSelectedFacets(currentSearch.selectedFacets)">
            <div class="selectedFacetsCaption">Suchgeschichte</div>
            <div ng-repeat="(facetTitleKey, facetEntries) in currentSearch.selectedFacets"
                 ng-if="showFacetSelection(facetEntries)">
              <span class="selectedFacetTitle">{{ showFacetTitle(facetTitleKey) }}:</span>
              <span ng-repeat="(facetEntryKey, facetEntrySelected) in facetEntries track by $index"
                    ng-if="facetEntrySelected">
                <span class="selectedFacetValue">
                  {{showSelectedFacetValue(facetEntries, facetEntryKey, facetTitleKey)}}
                </span>
                <button type="button" class="remove-facet-value" ng-click="toggleFacetValue(currentSearch.selectedFacets, facetTitleKey, facetEntryKey)">
                  &times;
                </button>
              </span>
            </div>
          </div>

          <div class="row">
            <div class="search-container">
              <div class="collection-input-container form-group">
                <input id="search-input" type="text" autocomplete="off" spellcheck="false"
                       autocorrect="off" placeholder="Suchtext eingeben..."
                       class="form-control" ng-model="currentSearch.searchtext">
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-sm-9">
              <div class="row">
                <div class="search-result-count">
                  {{searchResults[searchResultsIndex].response.numFound | number}} Ergebnisse
                </div>
                <div class="search-celltype">
                  <select class="btn sort-pages btn-secondary dropdown-toggle"
                          ng-model="currentSearch.rows"
                          ng-options="hitsPerPageOption.id as hitsPerPageOption.name for hitsPerPageOption in hitsPerPageOptions">
                  </select>
                </div>
              </div>
              <div class="hits">
                <?php echo get_field('hithtml'); ?>
              </div>
              <div class="row">
                <div class="search-pagination">
                  <div uib-pagination ng-change="pageChanged()" ng-model="currentSearch.page"
                       total-items="searchResults[searchResultsIndex].response.numFound"
                       items-per-page="searchResults[searchResultsIndex].responseHeader.params.rows"
                       max-size="10"
                       previous-text="&lt;" next-text="&gt;"></div>
                </div>
              </div>
            </div>

            <div class="col-sm-3">
              <uib-tabset active="activefacettab" class="search-facet-tabs tab-animation"
                          ng-init="activefacettab=0;">
                <?php
                  $facettabs = get_field('facettabs');
                  $facettabindex = 0;
                  foreach ($facettabs as $facettab) {
                ?>
                  <uib-tab index="<?php echo $facettabindex;
                  $facettabindex++; ?>" heading="<?php echo $facettab['title']; ?>">
                    <br/>

                    <?php if ($facettab['title'] === 'Geobrowser') { ?>
                      <geobrowser active-index="activefacettab"></geobrowser>
                      <br/>
                    <?php } ?>

                    <?php if ($facettab['title'] === 'Expertensuche') { ?>
                      <!--<expertsearch active-index="activefacettab"></expertsearch>-->
                      <expertsearch></expertsearch>

                      <br/>
                    <?php } ?>

                    <?php if ($facettab['facets'] != '') { ?>
                      <facet facet-config="tmpFacetConfig" current-search="currentSearch"
                             search-result="searchResults[searchResultsIndex]" disjunctive="true"
                             ng-repeat='tmpFacetConfig in <?php echo $facettab['facets']; ?>'></facet>
                    <?php } ?>

                    <?php if ($facettab['hierarchicalfacets'] != '') { ?>
                      <hierarchicalfacet facet-config="tmpFacetConfig"
                                         current-search="currentSearch"
                                         search-result="searchResults[searchResultsIndex]"
                                         disjunctive="true"
                                         ng-repeat='tmpFacetConfig in <?php echo $facettab['hierarchicalfacets']; ?>'></hierarchicalfacet>
                    <?php } ?>

                  </uib-tab>

                  <?php
                }
                ?>

              </uib-tabset>
            </div>
          </div>

    </div>

  </search>

<?php
  get_footer();
?>