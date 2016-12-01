<div class="row">
  <div class="hit-cell hit-cell-rectangle"
       ng-repeat-start="hit in searchResults[searchResultsIndex].response.docs">
    <div>
      <button type="button" class="hit-btn"
              ng-click="openModal(hit, searchResults[searchResultsIndex].responseHeader.params.searchtext)">
        <img ng-src="{{ retrieveImageUrl(hit) }}" alt="{{ hit.Objekt }}" class="hit-img">
      </button>
      <div>
<!--        <div class="hit-wishlist">-->
<!--          <add-to-wishlist-button product="hit"></add-to-wishlist-button>-->
<!--        </div>-->
        <div class="hit-text-full">
          <searchhit data-content="bildthema" data-label></searchhit>
          <searchhit data-content="archivnr" data-label></searchhit>
          <searchhit data-content="ensemble" data-label></searchhit>
          <searchhit data-content="datierung" data-label></searchhit>
          <searchhit data-content="kuenstler" data-label></searchhit>
          <searchhit data-content="objekt" data-label></searchhit>
          <searchhit data-content="objektgruppe" data-label></searchhit>
          <searchhit data-content="material_technik" data-label></searchhit>
          <searchhit data-content="institution" data-label></searchhit>
          <searchhit data-content="provenienz" data-label></searchhit>
          <searchhit data-content="standort" data-label></searchhit>
          <searchhit data-content="literatur" data-label></searchhit>
          <span class="property">
						<strong>Quelle: </strong>
						<span ng-repeat="quelle in hit.quelle">
              <button class="btn-quelle" ng-click="openQuelleModal(quelle)">{{quelle}}</button>
              <span ng-if="!$last"> , </span>
            </span>
					</span>
        </div>
        <div class="hit-text-body">
          <searchhit data-content="beschreibung"></searchhit>
        </div>
      </div>
    </div>
  </div>
  <div ng-repeat-end=""></div>
</div>