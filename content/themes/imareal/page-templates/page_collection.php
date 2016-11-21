<?php /* Template Name: Kollektion */
get_header();
?>

<div class="collection-main-container">

    <div class="collection-main-caption">
        &Uuml;ber 23.000 Aufnahmen
    </div>
    
    <div class="collection-input-container form-group has-icon-left">
      <form action="/suche/">
        <input type="text" name="searchtext" class="form-control"><select name="searchfield" class="form-control">
          <option value="suche_alles">Alles</option>
          <option value="suche_beschreibungen">Beschreibungen</option>
          <option value="suche_werke">Werke</option>
        </select>
        <i class="glyphicon icon-Realienkunde-_Suche icon-left"></i>
        <button type="submit" class="hidden"></button>
      </form>
    </div>
    <div  class="collection-secondary-caption">
       <a href="http://www.imareal.sbg.ac.at" target="_blank">am Institut für Realienkunde des Mittelalters und der frühen Neuzeit</a>
    </div> online....
    
</div>

<div class="collection-image-container" ng-controller="CollectionController">
  
  <ul class="collection-selection">
      <li sameheight="" ng-class="{'active': $index === activeCollectionIndex}" ng-repeat="collection in collections track by $index">
          <button  type="button" ng-click="setActiveCollectionIndex($index)" ng-style="{'background-image': 'url(' + retrieveImageUrl(collection) + ')', 'background-size': 'cover'}">
              <div class="collection-popover" ng-if="$index !== activeCollectionIndex" class="hit-btn-overlay" ng-style="{'min-width': '50px', 'min-height': '50px', 'color': '#000000', 'opacity':'1' }" uib-popover="Weitere sehen...." popover-trigger="'mouseenter'" popover-animation="true" popover-placement="bottom"></div>
          </button>
      </li>
  </ul>
  
  <div class="collection-info" ng-cloak>
    <span class="collection-name">{{activeColl}} </span> <!-- {{numFound}} Ergebnisse --> <span class="collection-description"> Die hier sichtbaren Bilder sind eine Auswahl des Institutes.</span>
  </div>
      <ul>
        <li ng-repeat="hit in hits" sameheight="">
          <button type="button" class="hit-btn-overlay-container" ng-click="openModal(hit)" style="background: url({{ retrieveImageUrl(hit) }}); background-size: cover; background-position: center center;">
              <div class="hit-btn-overlay"><span ng-repeat="hit_bildthema in hit.bildthema track by $index">{{hit_bildthema}} </span></div>
          </button>
        </li>
      </ul>
</div>

<?php
get_footer();
?>