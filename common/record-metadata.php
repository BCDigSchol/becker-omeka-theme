<?php if(isset(get_view()->item)): //check if this looks like an item show page ?>

<?php
//dig through the elements for display that are passed into this file
//put it all into a new array of just the elements we want
//this should let you collect the elements you want in the order you want
//follow this pattern to get more or change the order
$wantedElements = array();
/*$wantedElements[''] = $elementsForDisplay['Dublin Core']['Title'];*/
if(isset($elementsForDisplay['Item Type Metadata'])) {
}
$wantedElements['Title'] = $elementsForDisplay['Dublin Core']['Title'];
$wantedElements['Abstract'] = $elementsForDisplay['Dublin Core']['Abstract'];
$wantedElements['Author'] = $elementsForDisplay['Dublin Core']['Creator'];
$wantedElements['Date'] = $elementsForDisplay['Dublin Core']['Date'];
$wantedElements['Transcription'] = $elementsForDisplay['Dublin Core']['Has Part'];
$wantedElements ['Subject'] = $elementsForDisplay ['Dublin Core'] ['Subject'];
$wantedElements ['Condition'] = $elementsForDisplay ['Dublin Core'] ['Description'];
$wantedElements ['Place'] = $elementsForDisplay ['Dublin Core'] ['Coverage'];
$wantedElements ['Medium'] = $elementsForDisplay ['Dublin Core'] ['Medium'];
$wantedElements ['Dimensions'] = $elementsForDisplay ['Dublin Core'] ['Extent'];
$wantedElements ['Genre'] = $elementsForDisplay ['Dublin Core'] ['Type'];
$wantedElements ['Coordinates'] = $elementsForDisplay ['Dublin Core'] ['Spatial Coverage'];
/*$wantedElements ['Temporal Coverage'] = $elementsForDisplay ['Dublin Core'] ['Temporal Coverage'];*/
$wantedElements['Source'] = $elementsForDisplay['Dublin Core']['Source'];
$wantedElements['URI'] = $elementsForDisplay['Dublin Core']['Relation'];
$wantedElements['Ref. Number'] = $elementsForDisplay['Dublin Core']['Identifier'];
/*$wantedElements['PMID'] = $elementsForDisplay['Dublin Core']['Alternative Title'];*/
?>


<div class="element-set">
    <?php foreach ($wantedElements as $elementName => $elementInfo): ?>
    <div id="<?php echo text_to_id(html_escape("$elementName")); ?>" class="element">
        <h3><?php echo html_escape(__($elementName)); ?></h3>
        <?php foreach ($elementInfo['texts'] as $text): ?>
            <div class="element-text"><?php echo $text; ?></div>
        <?php endforeach; ?>
    </div><!-- end element -->
    <?php endforeach; ?>
</div><!-- end element-set -->

<?php else: ?>


<?php foreach ($elementsForDisplay as $setName => $setElements): ?>
<div class="element-set">
    <h2><?php echo html_escape(__($setName)); ?></h2>
    <?php foreach ($setElements as $elementName => $elementInfo): ?>
    <div id="<?php echo text_to_id(html_escape("$setName $elementName")); ?>" class="element">
        <h3><?php echo html_escape(__($elementName)); ?></h3>
        <?php foreach ($elementInfo['texts'] as $text): ?>
            <div class="element-text"><?php echo $text; ?></div>
        <?php endforeach; ?>
    </div><!-- end element -->
    <?php endforeach; ?>
</div><!-- end element-set -->
<?php endforeach; ?>

<?php endif; ?>
