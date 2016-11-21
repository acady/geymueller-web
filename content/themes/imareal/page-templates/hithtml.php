<div class="row">
	<div class="hit-cell"
		 ng-class="{ 'hit-cell-sm': celltype === 'sm', 'hit-cell-lg': celltype === 'lg', 'hit-cell-rectangle': celltype === 'rectangle' }"
		 ng-repeat-start="hit in searchResults[searchResultsIndex].response.docs">
		<button type="button" class="hit-btn hit-btn-overlay-container"
				ng-click="openModal(hit, searchResults[searchResultsIndex].responseHeader.params.searchtext)" style="background-image: url('{{ retrieveImageUrl(hit) }}')" ng-if="celltype === 'sm'">
            <div class="hit-btn-overlay">
				<searchhit data-content="archivnr"></searchhit><br>
                <searchhit data-content="bildthema"></searchhit>
            </div>
		</button>
		<div ng-if="celltype === 'lg' || celltype === 'rectangle'">
			<button type="button" class="hit-btn" ng-click="openModal(hit, searchResults[searchResultsIndex].responseHeader.params.searchtext)">
				<img ng-src="{{ retrieveImageUrl(hit) }}" alt="{{ hit.Objekt }}" class="hit-img">
			</button>
			<div ng-if="celltype === 'lg'">
				<div class="hit-text-head">
					<strong><searchhit data-content="bildthema"></searchhit></strong>
					<searchhit data-content="ensemble"></searchhit>
					<searchhit data-content="datierung"></searchhit>
				</div>
				<div class="hit-text-body">
					<searchhit data-content="body"></searchhit>
				</div>
			</div>
			<div ng-if="celltype === 'rectangle'">
				<div class="hit-wishlist">
					<add-to-wishlist-button product="hit"></add-to-wishlist-button>
				</div>
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
						<span ng-repeat="quelle in hit.quelle"><button class="btn-quelle" ng-click="openQuelleModal(quelle)">{{quelle}}</button><span ng-if="!$last"> , </span></span>
					</span>
				</div>
				<div class="hit-text-body">
					<searchhit data-content="beschreibung"></searchhit>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix" ng-if="celltype === 'lg' && $index%2==1"></div>
	<div ng-repeat-end=""></div>
</div>