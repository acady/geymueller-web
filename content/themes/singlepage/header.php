<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta charset="<?php bloginfo('charset'); ?>"/>
  <base href="/">
  <?php wp_head(); ?>
</head>
<body id="page-template" <?php body_class(); ?>>

<!-- -->


<script type="text/ng-template" id="/taggedview.html">

    <div class="row">
        <div class="col-sm-12 taggedView">
            <img ng-src="{{ retrieveImageUrl(hit) }}" class="img-responsive" />

            <!-- eine Klammer weil es ein normales json objekt ist -->

            <span ng-mouseover="hoverIn(node)" ng-mouseleave="hoverOut(node)" ng-repeat="node in taggedtreedata track by $index" ng-if="node.tagRect.x1 || node.tagPoint.x"
                  ng-style="{left: retrieveLeft(node), top: retrieveTop(node), 'width': retrieveWidth(node), 'height': retrieveHeight(node), 'border-width': retrieveBorderWidth(node), 'border-radius': retrieveBorderRadius(node)}" class="bild">
        <div class="tag_info" ng-show="node.hoverEdit" ng-style="{left: retrieveRightInfo(node), top: retrieveTopInfo(node)}">
              <span class="tag_info_title">
                {{node.title}} <i class="tag_info_group">({{node.group}})</i>
              </span>
          <span class="additional_info_medium_e">{{node.number}}</span>
          <span class="tag_info_block">
                <span ng-if="node.sex" ng-bind="node.sex"></span>
                <span ng-if="node.stand" ng-bind="node.stand"></span>
                <span ng-if="node.gestus" ng-bind="node.gestus"></span>
                <span ng-if="node.farbe" ng-bind="node.farbe"></span>
                <span ng-if="node.form" ng-bind="node.form"></span>
                <span ng-if="node.material" ng-bind="node.material"></span>
            <hr ng-if="node.tagRect.x1">
                <i ng-if="node.tagRect.x1" style="font-size: 10px;"> X1: {{node.tagRect.x1}} | Y1: {{node.tagRect.y1}} - X2: {{node.tagRect.x2}} | Y2: {{node.tagRect.y2}}</i>
          </span>
        </div>
      </span>
        </div>
    </div>
</script>

<script type="text/ng-template" id="/pathview.html">
    <div class="row">
        <div class="col-sm-6 treeView">
            <treecontrol class="tree-light" tree-model="treedata" expanded-nodes="expandedNodes" on-selection="showSelected(node)" selected-node="selectedTreeData">
                <i>{{node.group}}: </i><span class="data_title">{{node.title}}</span> <span class="data_e_value">({{node.number}})</span>
            </treecontrol>
        </div>
        <div class="col-sm-6">
            <div class="pathview-container" id="path_attributes">
                <span ng-bind-html="selectedTreeData.title" class="data_title_value"></span>
                <span class="data_e_value" ng-bind-html="trustAsHtml(selectedTreeData.number)"></span>
                <br>
                <div class="text-left"><i class="data_attr_group" ng-bind-html="trustAsHtml(selectedTreeData.group)"></i></div>
                <hr>

                <span  ng-if="selectedTreeData.title">Name:  <span class="data_attr" ng-bind-html="trustAsHtml(selectedTreeData.title)"></span><br/>
          <span  ng-if="selectedTreeData.data_title">
          <button ng-if="selectedTreeData.data_title" type="button" class="btn btn-default btn-add-data-text" ng-click="toggleTitleCollapsed()"><div class="btn-add-data-text-title">{{selectedTreeData.data_title}}</div></button><br/>
          <div uib-collapse="!titleCollapsed">
            <div class="data_attr_more" ng-bind-html="trustAsHtml(selectedTreeData.data_title)"></div>
          </div>
        </span>

        <span  ng-if="selectedTreeData.sex">Geschlecht: <span class="data_attr" ng-bind-html="trustAsHtml(selectedTreeData.sex)"></span><br/>
          <button ng-if="selectedTreeData.data_sex" type="button" class="btn btn-default btn-add-data-text"  ng-click="toggleSexCollapsed()"><div class="btn-add-data-text-title">{{selectedTreeData.data_sex}}</div></button><br/>
          <div uib-collapse="!sexCollapsed">
            <div class="data_attr_more" ng-bind-html="trustAsHtml(selectedTreeData.data_sex)"></div>
          </div>
        </span>

        <span  ng-if="selectedTreeData.stand">dStand: <span class="data_attr" ng-bind-html="trustAsHtml(selectedTreeData.stand)"></span><br/>
          <button ng-if="selectedTreeData.data_stand" type="button" class="btn btn-default btn-add-data-text" ng-click="toggleStandCollapsed()"><div class="btn-add-data-text-title">{{selectedTreeData.data_stand}}</div></button><br/>
          <div uib-collapse="!standCollapsed">
            <div class="data_attr_more" ng-bind-html="trustAsHtml(selectedTreeData.data_stand)"></div>
          </div>
        </span>


        <span  ng-if="selectedTreeData.gestus">Gestus:  <span class="data_attr" ng-bind-html="trustAsHtml(selectedTreeData.gestus)"></span><br/>
          <button ng-if="selectedTreeData.data_gestus" type="button" class="btn btn-default btn-add-data-text" ng-click="toggleGestusCollapsed()"><div class="btn-add-data-text-title">{{selectedTreeData.data_gestus}}</div></button><br/>
          <div uib-collapse="!gestusCollapsed">
            <div class="data_attr_more" ng-bind-html="trustAsHtml(selectedTreeData.data_gestus)"></div>
          </div>
        </span>

        <span  ng-if="selectedTreeData.farbe">Farbe: <span class="data_attr" ng-bind-html="trustAsHtml(selectedTreeData.farbe)"></span><br/>
          <button ng-if="selectedTreeData.data_farbe" type="button" class="btn btn-default btn-add-data-text" ng-click="toggleFarbeCollapsed()""><div class="btn-add-data-text-title">{{selectedTreeData.data_farbe}}</div></button><br/>
          <div uib-collapse="!farbeCollapsed">
            <div class="data_attr_more" ng-bind-html="trustAsHtml(selectedTreeData.data_farbe)"></div>
          </div>
        </span>

        <span  ng-if="selectedTreeData.form">Form: <span class="data_attr" ng-bind-html="trustAsHtml(selectedTreeData.form)"></span><br/>
          <button ng-if="selectedTreeData.data_form"  type="button" class="btn btn-default btn-add-data-text" ng-click="toggleFormCollapsed()"><div class="btn-add-data-text-title">{{selectedTreeData.data_form}}</div></button><br/>
          <div uib-collapse="!formCollapsed">
            <div class="data_attr_more" ng-bind-html="trustAsHtml(selectedTreeData.data_form)"></div>
          </div>
        </span>

        <span  ng-if="selectedTreeData.material">Material: <span class="data_attr" ng-bind-html="trustAsHtml(selectedTreeData.material)"></span><br/>
          <button ng-if="selectedTreeData.data_material" type="button" class="btn btn-default btn-add-data-text" ng-click="toggleMaterialCollapsed()"><div class="btn-add-data-text-title">{{selectedTreeData.data_material}}</div></button><br/>
          <div uib-collapse="!materialCollapsed">
            <div class="data_attr_more" ng-bind-html="trustAsHtml(selectedTreeData.data_material)"></div>
          </div>
        </span>

        <span  ng-if="selectedTreeData.text">Text: <span class="data_attr" ng-bind-html="trustAsHtml(selectedTreeData.text)"></span><br/>
          <button ng-if="selectedTreeData.data_text" type="button" class="btn btn-default btn-add-data-text" ng-click="toggleTextCollapsed()"><div class="btn-add-data-text-title">{{selectedTreeData.data_text}}</div></button><br/>
          <div uib-collapse="!textCollapsed">
            <div class="data_attr_more" ng-bind-html="trustAsHtml(selectedTreeData.data_text)"></div>
          </div>
        </span>

        <hr>

        <img ng-if="selectedTreeData.imageRect" class="attr_tree_image" ng-src="{{selectedTreeData.imageRect | ampersandhtml}}" alt="Rechteck Tag"></img>
        <br/>
        <img ng-if="selectedTreeData.imagePoint" class="attr_tree_image" ng-src="{{selectedTreeData.imagePoint | ampersandhtml}}"alt="Point Tag" /></img>

                    <!-- so geht as auch mit html code -->
            </div>
        </div>
    </div>
</script>

<script type="text/ng-template" id="/geobrowser.html">
    <div id="map" class="map">
    </div>
</script>

<script type="text/ng-template" id="/expertsearch.html">

    <a href="http://realonline.imareal.sbg.ac.at/browser/" class="button" target="_blank">Cypher Abfrage</a>
    <!--<button href="http://localhost:8474/browser/" formtarget="_blank">Cypher Abfrage</button>-->

    <textarea class="expertsearch" placeholder="Geben Sie hier Ihre Archivnummern ein..."></textarea>
    </div>
</script>

<script type="text/ng-template" id="/quellemodal.html">
    <div class="modal-header">
        <button type="button" class="close" ng-click="$close()">&times;</button>
        <h3>{{quelle}}</h3>
    </div>
    <div class="modal-body">
        <div ng-repeat="verse in quellecontent.verses"><span class="additional_info_small ng-scope">{{verse.id}}:</span> {{verse.value}}</div>
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

<script type="text/ng-template" id="/addtocart.html">

    <button type="button" class="add-to-cart" ng-click="addToCart()" ng-disabled="addToCartLoading">
        <i class="icon-Realienkunde-_Fotobestellung" ng-hide="addToCartLoading"></i>
        <span ng-show="addToCartLoading">
    <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>
  </span>
    </button>

</script>

<script type="text/ng-template" id="/addtowishlist.html">

    <button type="button" class="add-to-wishlist" ng-click="openWishlistModal()" ng-disabled="addToWishlistLoading">
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
            <li ng-repeat="facetValue in searchResult.facet_counts.facet_fields[facetConfig.facetfield] track by $index" ng-if="$index % 2 === 0 && $index < 20" class="facet-checkbox facet-line">

                <input type="checkbox" ng-click="toggleFacetValue(facetValue)" ng-checked="isRefined(facetValue)" id="facet-checkbox"/>
                <label for="facet-checkbox"><input type="checkbox" ng-click="toggleNotFacetValue(facetValue)" ng-checked="isNot(facetValue)"  id="facet-checkbox-second"/>
                </label><label class="check-exclude" for="facet-checkbox-second"><a href="" class="facet-link toggle-refine" ng-class="{ 'facet-disjunctive': disjunctive, 'facet-refined': isRefined(facetValue) }" ng-click="toggleFacetValue(facetValue)">
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
            <li ng-repeat="facetValue in searchResult.facet_counts.facet_fields[facetConfig.facetfield] | filter: filterUnuseful() | filter: facetModalFilter | orderBy: 'toString()' track by $index" ng-if="$index % 2 === 0 && $index < 100">
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
            <span ng-click="toggleFacetValue(node.originalValue)" class="facet-lable-over"><span>{{node.label}}</span></span>
            <span class="facet-count">
      <a href="" class="facet-link toggle-refine" ng-click="toggleFacetValue(node.originalValue)">{{ node.count }}</a>
      /
      <a href="" class="facet-link toggle-refine" ng-click="expandFacetValue(node.originalValue)">{{ globalSearchResult.facet_counts.facet_fields_map[facetConfig.facetfield][node.originalValue] }}</a>
    </span>
        </treecontrol>
    </facetcontainer>
</script>

<script type="text/ng-template" id="/antepostfacet.html">
    <facetcontainer facet-title="facetTitle">
        <input type="checkbox" class="facet-check-antepost" id="chk_exactmatch" ng-model="antepostfacetconfig.exactmatch" class="form-control" ng-change="exactmatchChanged()">
        <label for="chk_exactmatch" class="facet-lable">Exakte Jahreszahlen</label>
        <div ng-if="!antepostfacetconfig.exactmatch">
            <br/>
            <input type="radio" class="facet-check-antepost" id="chk_contain" name="antepostfacet.mode" ng-model="antepostfacetconfig.mode" class="form-control" value="contain" ng-change="modeChanged()">
            <label for="chk_contain" class="facet-lable">Enthalten</label>
            <br/>
            <input type="radio" class="facet-check-antepost" id="chk_overlap" name="antepostfacet.mode" ng-model="antepostfacetconfig.mode" class="form-control" value="overlap" ng-change="modeChanged()">
            <label for="chk_overlap" class="facet-lable">&Uuml;berschneiden:</label>
            <br/>
            <span class="facet-lable-input">von</span>
            <br>
            <input type="text" ng-model="antepostfacetconfig.post" class="form-control">
            <p>
                <ion-range-slider type="double" min="min" max="max" from="" to="antepostfacetconfig.post" on-change="sliderChanged(a)"></ion-range-slider>
                <rzslider rz-slider-model="antepostfacetconfig.post"
                          rz-slider-high="antepostfacetconfig.ante"
                          rz-slider-options="sliderOptions"></rzslider>
            </p>

            <span class="facet-lable-input">bis</span>
            <br>
            <input type="text" ng-model="antepostfacetconfig.ante" class="form-control">
        </div>
        <div ng-if="antepostfacetconfig.exactmatch">
            <span class="facet-lable-input">Post</span>
            <br>

            <input type="text" ng-model="antepostfacetconfig.exactpost" class="form-control">
            <br>
            <span class="facet-lable-input">Ante</span>
            <br>

            <input type="text" ng-model="antepostfacetconfig.exactante" class="form-control">
        </div>
        <br>
        <canvas class="chart chart-bar" chart-data="data" chart-labels="labels" chart-colors="colors" chart-options="chartOptions">
        </canvas>
    </facetcontainer>
</script>

<script type="text/ng-template" id="/facetcontainer.html">
    <div class="facet" ng-class="{open: facetOpen}">
        <h5 ng-bind-html="facetTitle | trusted_html" ng-click="toggleFacetOpen()"></h5>
        <div ng-transclude="" ng-show="facetOpen" class="slide">
        </div>
    </div>
</script>

<!-- -->

<header class="navbar navbar-onex">
  <div class="container">
    <div class="nav navbar-header">
      <div class="logo-container text-left">

        <?php if (of_get_option('logo') != "") { ?>
          <a href="<?php echo esc_url(home_url('/')); ?>">
            <img src="<?php echo esc_url(of_get_option('logo')); ?>" class="site-logo"
                 alt="<?php bloginfo('name'); ?>"/>
          </a>
        <?php } else { ?>
          <div class="name-box">
            <a href="<?php echo esc_url(home_url('/')); ?>"><h1 class="site-name"><?php bloginfo('name'); ?></h1>
            </a><br/>
            <?php if ('blank' != get_header_textcolor() && '' != get_header_textcolor()) { ?>
              <span class="site-tagline"><?php bloginfo('description'); ?></span>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
      <nav class="site-nav main-menu" id="navbar-collapse" role="navigation">
        <?php wp_nav_menu(array('theme_location' => 'primary', 'depth' => 0, 'fallback_cb' => false, 'container' => '', 'container_class' => 'main-menu', 'menu_id' => 'menu-main', 'menu_class' => 'main-nav', 'link_before' => '<span>', 'link_after' => '</span>', 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s<li class="nav_focus">focus</li><li class="nav_default cur">default</li></ul>')); ?>
      </nav>
    </div>
  </div>
</header>