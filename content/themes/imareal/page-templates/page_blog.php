<?php /* Template Name: Kollektion */
get_header();
?>

<div class="collection-main-container">

	<div class="collection-main-caption">
		&Uuml;ber zwei Einträge
	</div>
	
	<div class="collection-input-container form-group has-icon-left">
	    <input type="text" class="form-control"><select class="form-control"><option>Beschreibungen</option></select>
	    <i class="glyphicon icon-Realienkunde-_Suche icon-left"></i>
	</div>
	
</div>

<div class="collection-image-container">
  
  <ul class="collection-selection">
      <li sameheight="">
        <button type="button" ng-click="openModal(hit)" style="background: url(http://cf000036.sbg.ac.at/iipsrv/iipsrv.fcgi?FIF=/7019501.tif&amp;WID=225&amp;HEI=225&amp;CVT=JPG); background-size: cover;"></button>
      </li><li class="active" sameheight="">
        <button type="button" ng-click="openModal(hit)" style="background: url(http://cf000036.sbg.ac.at/iipsrv/iipsrv.fcgi?FIF=/7019505.tif&amp;WID=225&amp;HEI=225&amp;CVT=JPG); background-size: cover;"></button>
      </li><li sameheight="">
        <button type="button" ng-click="openModal(hit)" style="background: url(http://cf000036.sbg.ac.at/iipsrv/iipsrv.fcgi?FIF=/7019514.tif&amp;WID=225&amp;HEI=225&amp;CVT=JPG); background-size: cover;"></button>
      </li><li sameheight="">
        <button type="button" ng-click="openModal(hit)" style="background: url(http://cf000036.sbg.ac.at/iipsrv/iipsrv.fcgi?FIF=/7019511.tif&amp;WID=225&amp;HEI=225&amp;CVT=JPG); background-size: cover;"></button>
      </li><li sameheight="">
        <button type="button" ng-click="openModal(hit)" style="background: url(http://cf000036.sbg.ac.at/iipsrv/iipsrv.fcgi?FIF=/7019521.tif&amp;WID=225&amp;HEI=225&amp;CVT=JPG); background-size: cover;"></button>
      </li>
      <!--
      <li sameheight="">
          <button type="button" ng-click="openModal(hit)" style="background: url(http://cf000036.sbg.ac.at/iipsrv/iipsrv.fcgi?FIF=/media/thumbnail/pyramids/7019501.tif&amp;WID=225&amp;HEI=225&amp;CVT=JPG); background-size: cover;"></button>
      </li><li class="active" sameheight="">
          <button type="button" ng-click="openModal(hit)" style="background: url(http://cf000036.sbg.ac.at/iipsrv/iipsrv.fcgi?FIF=/media/thumbnail/pyramids/7019505.tif&amp;WID=225&amp;HEI=225&amp;CVT=JPG); background-size: cover;"></button>
      </li><li sameheight="">
          <button type="button" ng-click="openModal(hit)" style="background: url(http://cf000036.sbg.ac.at/iipsrv/iipsrv.fcgi?FIF=/media/thumbnail/pyramids/7019514.tif&amp;WID=225&amp;HEI=225&amp;CVT=JPG); background-size: cover;"></button>
      </li><li sameheight="">
          <button type="button" ng-click="openModal(hit)" style="background: url(http://cf000036.sbg.ac.at/iipsrv/iipsrv.fcgi?FIF=/media/thumbnail/pyramids/7019511.tif&amp;WID=225&amp;HEI=225&amp;CVT=JPG); background-size: cover;"></button>
      </li><li sameheight="">
          <button type="button" ng-click="openModal(hit)" style="background: url(http://cf000036.sbg.ac.at/iipsrv/iipsrv.fcgi?FIF=/media/thumbnail/pyramids/7019521.tif&amp;WID=225&amp;HEI=225&amp;CVT=JPG); background-size: cover;"></button>
      </li>
      -->
  </ul>
  
  <div class="collection-info">
    <span class="collection-name">Kollektionsname:</span> 14.393 Ergebnisse
  </div>
  
  <collection collection="<?php the_field('collection'); ?>"></collection>
</div>

<script type="text/ng-template" id="/collection.html">
  <ul>
      <li ng-repeat="hit in searchResult.response.docs" sameheight="">
        <button type="button" ng-click="openModal(hit)" style="background: url({{ retrieveImageUrl(hit) }}); background-size: cover;"></button>
      </li>
  </ul>
</script>

<?php
get_footer();
?>