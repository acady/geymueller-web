<?php /* Template Name: Suchseite */
get_header();
?>

<search index-name="<?php echo get_field('indexname'); ?>" ng-cloak="">

<div class="search-main-container">

<uib-tabset active="tabIndex" class="search-tabs">
<uib-tab ng-repeat="currentSearch in searches track by $index" index="$index" ng-init="searchResultsIndex = $index;">
	
	<uib-tab-heading>
		Suche: {{currentSearch.searchtext}}&nbsp;<button type="button" class="close" ng-click="removeTab(searchResultsIndex)" ng-if="searches.length > 1">&times;</button>
	</uib-tab-heading>
	
	<div class="selectedFacets" ng-if="showSelectedFacets(currentSearch.selectedFacets)">
		<div class="selectedFacetsCaption">Suchgeschichte</div>
		<div ng-repeat="(facetTitleKey, facetEntries) in currentSearch.selectedFacets" ng-if="showFacetSelection(facetEntries)">
			<span class="selectedFacetTitle">{{ showFacetTitle(facetTitleKey) }}:</span>
			<span ng-repeat="(facetEntryKey, facetEntrySelected) in facetEntries track by $index" ng-if="facetEntrySelected">
				<span class="selectedFacetValue">{{showSelectedFacetValue(facetEntries, facetEntryKey, facetTitleKey)}}</span>
				<button type="button" class="remove-facet-value" ng-click="toggleFacetValue(currentSearch.selectedFacets, facetTitleKey, facetEntryKey)">&times;</button>
			</span>
		</div>
	</div>
	
	<div class="row">
		<div class="search-container">
			<div class="collection-input-container form-group has-icon-left">
				<input id="search-input" type="text" autocomplete="off" spellcheck="false" autocorrect="off" placeholder="Suchtext oder Archivnummer eingeben..." class="form-control" ng-model="currentSearch.searchtext"><select class="form-control" ng-model="currentSearch.searchfield">
					<option value="suche_beschreibungen">Beschreibungen</option>
					<option value="suche_werke">Werke</option>
					<option value="suche_alles">Alles</option>
				</select>
				<i class="glyphicon icon-Realienkunde-_Suche icon-left"></i>
			</div>
		</div>
	</div>
	

	
	<div class="row">
		
		<div class="col-sm-3">
			
			<uib-tabset active="activefacettab" class="search-facet-tabs tab-animation" ng-init="activefacettab=0;">
				
				<?php
					$facettabs = get_field('facettabs');
					$facettabindex = 0;
					foreach ($facettabs as $facettab) {
				?>
				<uib-tab index="<?php echo $facettabindex; $facettabindex++; ?>" heading="<?php echo $facettab['title']; ?>">
					<br/>
					
					<?php if($facettab['title'] === 'Geobrowser') { ?>
						<geobrowser active-index="activefacettab"></geobrowser>
						<br/>
					<?php } ?>

					<?php if($facettab['title'] === 'Expertensuche') { ?>
						<!--<expertsearch active-index="activefacettab"></expertsearch>-->
						<expertsearch></expertsearch>

						<br/>
					<?php } ?>

					<?php if($facettab['title'] == 'Werke') { ?>
						<antepostfacet current-search="currentSearch" search-result="searchResults[searchResultsIndex]" min="700" max="1900"></antepostfacet>
					<?php } ?>
					
					<?php if($facettab['facets'] != '') { ?>
						<facet facet-config="tmpFacetConfig" current-search="currentSearch" search-result="searchResults[searchResultsIndex]" disjunctive="true" ng-repeat='tmpFacetConfig in <?php echo $facettab['facets']; ?>'></facet>
					<?php } ?>
					
					<?php if($facettab['hierarchicalfacets'] != '') { ?>
						<hierarchicalfacet facet-config="tmpFacetConfig" current-search="currentSearch" search-result="searchResults[searchResultsIndex]" disjunctive="true" ng-repeat='tmpFacetConfig in <?php echo $facettab['hierarchicalfacets']; ?>'></hierarchicalfacet>
					<?php } ?>
					
				</uib-tab>
				
				<?php
					}
				?>
				
			</uib-tabset>
			<!-- IntroJS implementierung -->
			<!--<a href='#' data-intro='Hier findet man die durchsuchbaren Bereiche....' ><span class="help-link">Was suchen.....</span></a>-->
		</div>
		
		<!-- Right Column -->
		<div class="col-sm-9">
				<div class="row">
					<div class="search-result-count">
						{{searchResults[searchResultsIndex].response.numFound | number}} Ergebnisse
					</div>
					<div class="search-celltype">
						<select class="btn sort-pages btn-secondary dropdown-toggle" ng-model="currentSearch.rows" ng-options="hitsPerPageOption.id as hitsPerPageOption.name for hitsPerPageOption in hitsPerPageOptions">
						</select>
						
						<button type="button" class="btn btn-link" ng-class="{active: celltype === 'sm'}" ng-click="celltype='sm'">
							<i class="glyphicon glyphicon-th"></i>
						</button>
						<button type="button" class="btn btn-link" ng-class="{active: celltype === 'lg'}" ng-click="celltype='lg'">
							<i class="glyphicon glyphicon-th-large"></i>
						</button>
						<button type="button" class="btn btn-link" ng-class="{active: celltype === 'rectangle'}" ng-click="celltype='rectangle'">
							<i class="glyphicon glyphicon-th-list"></i>
						</button>
						<button type="button" class="btn btn-link" ng-click="addAllResultsToWishlist()">
							<i class="icon-Realienkunde-_Wunschliste"></i>
						</button>
					</div>
				</div>
				<div class="hits">
					<?php echo get_field('hithtml'); ?>
				</div>
				<div class="row">
					<div class="search-pagination">
						<div uib-pagination ng-change="pageChanged()" ng-model="currentSearch.page" total-items="searchResults[searchResultsIndex].response.numFound" items-per-page="searchResults[searchResultsIndex].responseHeader.params.rows" max-size="10" previous-text="&lt;" next-text="&gt;"></div>
					</div>
				</div>
			</div>
		</div>
</uib-tab>

<uib-tab ng-click="startNewSearch();" ng-if="searchResults" disable="true">
  <uib-tab-heading>
    <i class="glyphicon glyphicon-plus"></i>
  </uib-tab-heading>
</uib-tab>

<uib-tab ng-click="openSaveModal();" ng-if="searchResults" disable="true">
  <uib-tab-heading>
    <i class="glyphicon glyphicon-floppy-save"></i>
  </uib-tab-heading>
</uib-tab>

<uib-tab ng-click="openLoadModal();" ng-if="searchResults" disable="true">
  <uib-tab-heading>
    <i class="glyphicon glyphicon-floppy-open"></i>
  </uib-tab-heading>
</uib-tab>

</uib-tabset>

</div>

</search>

<?php
get_footer();
?>